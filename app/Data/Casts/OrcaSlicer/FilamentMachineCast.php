<?php

namespace App\Data\Casts\OrcaSlicer;

use Illuminate\Support\Str;
use Spatie\LaravelData\Casts\Cast;
use Spatie\LaravelData\Support\Creation\CreationContext;
use Spatie\LaravelData\Support\DataProperty;

class FilamentMachineCast implements Cast
{
    public function cast(DataProperty $property, mixed $value, array $properties, CreationContext $context): string
    {
        return Str::afterLast($value, '@');
    }
}
