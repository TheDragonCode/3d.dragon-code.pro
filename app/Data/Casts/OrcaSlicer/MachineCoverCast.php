<?php

namespace App\Data\Casts\OrcaSlicer;

use Spatie\LaravelData\Casts\Cast;
use Spatie\LaravelData\Support\Creation\CreationContext;
use Spatie\LaravelData\Support\DataProperty;

use function rawurlencode;
use function str_replace;

class MachineCoverCast implements Cast
{
    protected string $url = 'https://raw.githubusercontent.com/OrcaSlicer/OrcaSlicer/main/resources/profiles/{vendor}/{machine}_cover.png';

    public function cast(DataProperty $property, mixed $value, array $properties, CreationContext $context): string
    {
        return str_replace([
            '{vendor}',
            '{machine}',
        ], [
            $this->encode($properties['meta']['profile']),
            $this->encode($value),
        ], $this->url);
    }

    protected function encode(string $value): string
    {
        return rawurlencode($value);
    }
}
