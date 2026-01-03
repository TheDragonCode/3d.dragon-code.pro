<?php

declare(strict_types=1);

namespace App\Console\Commands\OrcaSlicer;

use App\Services\OrcaSlicer\DownloadService;
use App\Services\OrcaSlicer\MapService;
use Illuminate\Console\Command;

class ImportCommand extends Command
{
    protected $signature = 'orca-slicer:import';

    protected $description = 'Update resources from OrcaSlicer';

    public function handle(DownloadService $download, MapService $map): void
    {
        //$this->components->task('Clean up', fn () => $download->cleanup());
        //$this->components->task('Download', fn () => $download->download());
        //$this->components->task('Extract', fn () => $download->extract());
        //$this->components->task('Release', fn () => $download->release());
        $this->components->task('Import map', fn () => $map->import());
    }
}
