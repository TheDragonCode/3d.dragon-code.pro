<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Services\OrcaSlicer\DownloadService;
use App\Services\OrcaSlicer\ImportService;
use Illuminate\Console\Command;

class OrcaSlicerCommand extends Command
{
    protected $signature = 'orca-slicer';

    protected $description = 'Update resources from OrcaSlicer';

    public function handle(DownloadService $download, ImportService $import): void
    {
        //$this->components->task('Clean up', fn () => $download->cleanup());
        //$this->components->task('Download', fn () => $download->download());
        //$this->components->task('Extract', fn () => $download->extract());
        $this->components->task('Import profiles', fn () => $import->profiles());
    }
}
