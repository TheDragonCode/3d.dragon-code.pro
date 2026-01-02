<?php

namespace App\Data\Casts\OrcaSlicer;

use App\Data\OrcaSlicer\MachineData;
use Illuminate\Support\Collection;
use Spatie\LaravelData\Casts\Cast;
use Spatie\LaravelData\Support\Creation\CreationContext;
use Spatie\LaravelData\Support\DataProperty;

use function collect;
use function file_get_contents;
use function json_decode;

class MachinesCast implements Cast
{
    public function cast(DataProperty $property, mixed $value, array $properties, CreationContext $context): Collection
    {
        return collect($value)
            ->reject(fn (array $filament) => str_contains($filament['name'], 'fdm_'))
            ->map(function (array $machine) use ($properties) {
                $parameters = $this->parameters(
                    $properties['meta']['directory'],
                    $machine['sub_path']
                );

                return MachineData::from([
                    ...$machine,
                    ...$parameters,
                    ...$this->meta($properties),
                ]);
            });
    }

    protected function parameters(string $directory, string $profile): array
    {
        return json_decode(file_get_contents($directory . '/' . $profile), true);
    }

    protected function meta(array $properties): array
    {
        return ['meta' => $properties['meta']];
    }
}
