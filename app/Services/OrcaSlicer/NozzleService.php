<?php

declare(strict_types=1);

namespace App\Services\OrcaSlicer;

use App\Concerns\WithNozzles;
use App\Enums\SourceType;
use App\Models\Map;

class NozzleService
{
    use WithNozzles;

    protected array $patterns = [
        '/\d*\.\d*\s*_*nozzle\s*_*(\d{1}\.\d{1,2})/',
        '/(\d{1}\.\d{1,2})m*\s*_*nozzle/',
        '/nozzle\s*_*(\d{1}\.\d{1,2})m*/',
    ];

    public function import(): void
    {
        Map::query()
            ->whereIn('type', [
                SourceType::Filament, SourceType::Process,
            ])
            ->each(fn (Map $map) => $this->store($map));
    }

    protected function store(Map $map): void
    {
        if ($value = $this->detect($map->key)) {
            $this->nozzle($value);

            return;
        }

        if ($value = $this->detect($map->path)) {
            $this->nozzle($value);
        }
    }

    protected function detect(string $value): ?float
    {
        foreach ($this->patterns as $pattern) {
            if (preg_match($pattern, $value, $matches)) {
                return (float) $matches[1];
            }
        }

        return null;
    }
}
