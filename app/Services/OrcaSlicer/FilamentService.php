<?php

declare(strict_types=1);

namespace App\Services\OrcaSlicer;

use App\Concerns\WithFilaments;
use App\Enums\SourceType;
use App\Models\Filament;
use App\Models\Map;
use Illuminate\Support\Str;

class FilamentService
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
        $typeId = $this->detect($map->key, $map->path);

        Filament::updateOrCreate([
            'vendor_id'        => $map->vendor_id,
            'filament_type_id' => $typeId,
        ]);
    }

    public function detect(string $key, string $path): int
    {
        $value = $this->prepare($key, $path);

        foreach ($this->getFilamentTypes() as $type) {
            if (Str::contains($value, $type->title)) {
                return $type->id;
            }
        }

        return $this->getFilamentTypes()->get('Unknown')->id;
    }

    protected function prepare(string $key, string $path): string
    {
        return Str::of($key)
            ->append(' ', $path)
            ->replace(['@HS', '@HF'], ' HS')
            ->replace('@', ' ')
            ->toString();
    }
}
