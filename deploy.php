<?php

declare(strict_types=1);

namespace Deployer;

use const PHP_EOL;

require 'contrib/npm.php';
require 'contrib/telegram.php';
require 'recipe/laravel.php';

// Config

set('application', '3D Printers');
set('repository', 'git@github.com:TheDragonCode/3d.dragon-code.pro.git');

set('telegram_token', $_SERVER['TELEGRAM_DEPLOY_TOKEN'] ?? null);
set('telegram_chat_id', $_SERVER['TELEGRAM_DEPLOY_CHAT_ID'] ?? null);

set(
    'telegram_text',
    'Deploying `{{branch}}` to *{{target}}*' . PHP_EOL . PHP_EOL . '*Application*: {{application}}'
);
set(
    'telegram_success_text',
    'Deployed some fresh code to *{{target}}*' . PHP_EOL . PHP_EOL . '*Application*: {{application}}'
);
set(
    'telegram_failure_text',
    'Something went wrong during deployment to *{{target}}*' . PHP_EOL . PHP_EOL . '*Application*: {{application}}'
);

// Hosts

host('production')
    ->setHostname('217.144.102.37')
    ->setRemoteUser('forge')
    ->setDeployPath('~/domains/3d.dragon-code.pro');

// Tasks

task('deploy', [
    'deploy:prepare',
    'deploy:vendors',
    'artisan:storage:link',
    'artisan:optimize',
    'artisan:migrate',
    'artisan:operations:before',
    'deploy:publish',
    'artisan:cache:clear',
    'artisan:operations',
]);

task('artisan:operations:before', function (): void {
    cd('{{release_path}}');
    run('{{bin/php}} artisan operations --before');
});

task('artisan:operations', function (): void {
    cd('{{release_path}}');
    run('{{bin/php}} artisan operations');
});

task('npm:build', function (): void {
    cd('{{release_path}}');
    run('{{bin/npm}} run build');
});

after('deploy:vendors', 'npm:install');
after('deploy:vendors', 'npm:build');

before('deploy', 'telegram:notify');

after('deploy:success', 'telegram:notify:success');

after('deploy:failed', 'deploy:unlock');
after('deploy:failed', 'telegram:notify:failure');
