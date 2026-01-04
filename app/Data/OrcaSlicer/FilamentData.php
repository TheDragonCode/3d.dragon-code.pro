<?php

namespace App\Data\OrcaSlicer;

use App\Data\Casts\ArrayToFloatCast;
use App\Data\Casts\ArrayToIntegerCast;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapName(SnakeCaseMapper::class)]
class FilamentData extends Data
{
    public function __construct(
        #[MapInputName('filament_settings_id')]
        #[MapOutputName('external_id')]
        public string $settingsId,

        #[MapInputName('default_filament_colour')]
        public ?string $color = null,

        public ?string $inherits = null,

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
