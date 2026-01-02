<?php

namespace App\Data\Casts\OrcaSlicer;

use App\Services\OrcaSlicer\FilamentService;
use Illuminate\Support\Collection;
use Spatie\LaravelData\Casts\Cast;
use Spatie\LaravelData\Support\Creation\CreationContext;
use Spatie\LaravelData\Support\DataProperty;

use function app;
use function str_contains;

class FilamentCast implements Cast
{
    public function cast(DataProperty $property, mixed $value, array $properties, CreationContext $context): Collection
    {
        return collect($value)
            ->reject(fn (array $filament) => str_contains($filament['name'], 'fdm_'))
            ->map(fn (array $filament) => $this->filament()->get(
                $properties['meta']['profile'],
                $filament['name'],
                $properties['meta']
            ))
            ->filter();
    }

    protected function filament(): FilamentService
    {
        return app(FilamentService::class);
    }
}
