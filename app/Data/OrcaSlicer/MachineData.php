<?php

namespace App\Data\OrcaSlicer;

use App\Data\Casts\OrcaSlicer\MachineCoverCast;
use App\Data\Casts\OrcaSlicer\MachineTitleCast;
use App\Data\Casts\OrcaSlicer\NozzleDiametersCast;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Data;

class MachineData extends Data
{
    public function __construct(
        #[MapInputName('name')]
        #[WithCast(MachineTitleCast::class)]
        public string $title,

        #[MapInputName('nozzle_diameter')]
        #[WithCast(NozzleDiametersCast::class)]
        public array $nozzleDiameters,

        #[MapInputName('name')]
        #[WithCast(MachineCoverCast::class)]
        public string $cover
    ) {}
}
