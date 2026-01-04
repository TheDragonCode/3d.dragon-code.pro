<?php

namespace App\Data\OrcaSlicer;

use App\Data\Casts\ArrayToFloatCast;
use App\Data\Casts\ArrayToIntegerCast;
use App\Data\Casts\ArrayToStringCast;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapName(SnakeCaseMapper::class)]
class FilamentData extends Data
{
    public function __construct(
        #[MapInputName('filament_settings_id')]
        #[WithCast(ArrayToStringCast::class)]
        public string $externalId,

        #[MapInputName('default_filament_colour')]
        #[WithCast(ArrayToStringCast::class)]
        public string $color,

        public string $inherits,

        #[WithCast(ArrayToFloatCast::class)]
        public float $pressureAdvance = 0,

        #[WithCast(ArrayToFloatCast::class)]
        public float $filamentFlowRatio = 0,
        #[WithCast(ArrayToFloatCast::class)]
        public float $filamentMaxVolumetricSpeed = 0,

        #[WithCast(ArrayToIntegerCast::class)]
        public int $nozzleTemperature = 0,
        #[WithCast(ArrayToIntegerCast::class)]
        public int $nozzleTemperatureInitialLayer = 0,
    ) {}
}
