<?php

namespace App\Data\OrcaSlicer;

use App\Data\Casts\OrcaSlicer\FilamentTitleCast;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapName(SnakeCaseMapper::class)]
class FilamentData extends Data
{
    public function __construct(
        public string $settingId,

        #[MapInputName('name')]
        #[WithCast(FilamentTitleCast::class)]
        public string $title,

        public float $pressureAdvance = 0,

        public float $filamentFlowRatio,
        public float $filamentMaxVolumetricSpeed,

        public int $nozzleTemperature,
        public int $nozzleTemperatureInitialLayer,
    ) {}
}
