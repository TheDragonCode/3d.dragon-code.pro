<?php

namespace App\Data\Casts\OrcaSlicer;

use App\Data\OrcaSlicer\FilamentData;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Spatie\LaravelData\Casts\Cast;
use Spatie\LaravelData\Support\Creation\CreationContext;
use Spatie\LaravelData\Support\DataProperty;

use function array_key_exists;
use function array_merge;
use function file_exists;
use function str_contains;

class FilamentCast implements Cast
{
    public function cast(DataProperty $property, mixed $value, array $properties, CreationContext $context): Collection
    {
        return collect($value)
            ->reject(fn (array $filament) => str_contains($filament['name'], 'fdm_filament'))
            ->map(function (array $filament) use ($properties) {
                $parameters = $this->mergeParameters(
                    $properties['meta']['directory'],
                    $filament['sub_path']
                );

                dd(
                    $parameters
                );

                return FilamentData::from([
                    ...$filament,
                    ...$parameters,
                    ...$this->meta($properties),
                ]);
            });
    }

    protected function mergeParameters(string $directory, string $profile): array
    {
        $parameters = $this->parameters($directory, $profile);

        if (! array_key_exists('inherits', $parameters)) {
            return $parameters;
        }

        $parent = $this->mergeParameters($directory, $parameters['inherits']);

        return array_merge($parent, $parameters);
    }

    protected function parameters(string $directory, string $profile): array
    {
        $profile = Str::finish($profile, '.json');

        return json_decode(file_get_contents($directory . '/' . $profile . ''), true);
    }

    protected function parameterExists(string $directory, string $profile): bool
    {
        return file_exists($directory . '/' . $profile);
    }

    protected function meta(array $properties): array
    {
        return ['meta' => $properties['meta']];
    }
}
