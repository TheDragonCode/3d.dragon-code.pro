<?php

namespace App\Data\Casts;

use Spatie\LaravelData\Casts\Cast;
use Spatie\LaravelData\Support\Creation\CreationContext;
use Spatie\LaravelData\Support\DataProperty;

use function array_first;
use function is_array;

class ArrayToIntegerCast implements Cast
{
    public function cast(DataProperty $property, mixed $value, array $properties, CreationContext $context): int
    {
        if (is_array($value)) {
            return (int) array_first($value);
        }

        return (int) $value;
    }
}
