<?php

declare(strict_types=1);

namespace App\Services\OrcaSlicer;

use App\Concerns\WithFilaments;
use App\Enums\SourceType;
use App\Models\Map;
use Illuminate\Support\Str;

class FilamentTypeService
{
    use WithFilaments;

    protected string $pattern = '/\\b((?:E)?(?:PLA|ABS|ASA|PETG|PET|PCTG|PAHT|PPA|PA(?:\\d{0,3})?|PC-ABS|PC|PP|PVA|BVOH|PVB|TPU|TPE|HIPS|PEEK|PEKK|PPSU?|PCTPE))(?:[\\s-]?(?:\\+|CF|GF|HT|HF|HS|LW|SE|PRO|PLUS|ULTRA|TOUGH|BASIC|ELITE|SILK|WOOD|MATTE|GLOW|AERO|METAL|SPEED|FAST|HIGH\\s*FLOW|HIGH\\s*SPEED))*\\b/i';

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

    protected function detect(string $value): ?string
    {
        if (! preg_match($this->pattern, $value, $matches)) {
            return null;
        }

        return Str::of($matches[0])
            ->replace('_', '-', false)
            ->squish()
            ->trim('-')
            ->toString();
    }
}
