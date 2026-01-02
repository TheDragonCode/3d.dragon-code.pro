<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Services\OrcaSlicer\DownloadService;
use Illuminate\Console\Command;

class DownloadOrcaSlicerCommand extends Command
{
    protected $signature = 'download:orca-slicer';

    protected $description = 'Command description';

    public function handle(DownloadService $service): void
    {
        $this->components->task('Clean up', fn () => $service->cleanup());
        $this->components->task('Download', fn () => $service->download());
        $this->components->task('Extract', fn () => $service->extract());
    }
}
