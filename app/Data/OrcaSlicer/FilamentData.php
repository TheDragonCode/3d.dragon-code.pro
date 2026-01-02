<?php

namespace App\Data\OrcaSlicer;

use App\Data\Casts\ArrayToFloatCast;
use App\Data\Casts\ArrayToIntegerCast;
use App\Data\Casts\OrcaSlicer\FilamentMachineCast;
use App\Data\Casts\OrcaSlicer\FilamentTitleCast;
use Illuminate\Support\Str;
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
        #[MapOutputName('external_id')]
        public string $settingId,

        #[MapInputName('name')]
        #[WithCast(FilamentTitleCast::class)]
        public string $title,

        #[MapInputName('name')]
        #[WithCast(FilamentMachineCast::class)]
        public string $machine,

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

    public static function prepareForPipeline(array $properties): array
    {
        $properties['filament_id'] ??= Str::slug($properties['name']);
        $properties['setting_id']  ??= $properties['filament_id'];

        return $properties;
    }
}
