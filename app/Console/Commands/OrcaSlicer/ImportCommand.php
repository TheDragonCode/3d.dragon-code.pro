<?php

declare(strict_types=1);

namespace App\Console\Commands\OrcaSlicer;

use App\Services\OrcaSlicer\DownloadService;
use App\Services\OrcaSlicer\FilamentService;
use App\Services\OrcaSlicer\FilamentTypeService;
use App\Services\OrcaSlicer\MachineService;
use App\Services\OrcaSlicer\MapService;
use App\Services\OrcaSlicer\NozzleService;
use Illuminate\Console\Command;

class ImportCommand extends Command
{
    protected $signature = 'orca-slicer:import';

    protected $description = 'Update resources from OrcaSlicer';

    public function handle(
        DownloadService $download,
        MapService $map,
        MachineService $machine,
        NozzleService $nozzle,
        FilamentTypeService $type,
        FilamentService $filament,
    ): void {
        //$this->components->task('Clean up', fn () => $download->cleanup());
        //$this->components->task('Download', fn () => $download->download());
        //$this->components->task('Extract', fn () => $download->extract());
        //$this->components->task('Release', fn () => $download->release());

        $this->components->task('Import profile maps', fn () => $map->import());
        $this->components->task('Import sub filament maps', fn () => $map->importSubFilaments());
        $this->components->task('Import machines', fn () => $machine->import());
        $this->components->task('Import nozzles', fn () => $nozzle->import());
        $this->components->task('Import filament types', fn () => $type->import());
        $this->components->task('Import filaments', fn () => $filament->import());
    }
}
