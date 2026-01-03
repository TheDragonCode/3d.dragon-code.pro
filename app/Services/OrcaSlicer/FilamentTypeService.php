<?php

declare(strict_types=1);

namespace App\Services\OrcaSlicer;

use App\Concerns\WithFilaments;
use App\Enums\SourceType;
use App\Models\Map;

class FilamentTypeService
{
    use WithFilaments;

    public function import(): void
    {
        Map::query()
            ->where('type', SourceType::Filament)
            ->each(fn (Map $map) => $this->store($map));
    }

    protected function store(Map $map): void
    {
        if (! $value = $this->detect($map->key)) {
            return;
        }

        $this->filamentType($value);
    }

    protected function detect(string $value): ?string {}
}
