<?php

declare(strict_types=1);

use App\Console\Commands\OrcaSlicer\ImportCommand;
use DragonCode\LaravelDeployOperations\Operation;

return new class extends Operation {
    public function __invoke(): void
    {
        $this->artisan(ImportCommand::class);
    }

    public function shouldOnce(): bool
    {
        return false;
    }

    public function shouldRun(): bool
    {
        return app()->isProduction();
    }

    public function needBefore(): bool
    {
        return false;
    }
};
