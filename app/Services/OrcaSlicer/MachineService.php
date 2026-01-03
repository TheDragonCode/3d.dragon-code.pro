<?php

declare(strict_types=1);

namespace App\Services\OrcaSlicer;

use App\Enums\SourceType;
use App\Models\Map;

class MachineService
{
    protected string $url = 'https://raw.githubusercontent.com/OrcaSlicer/OrcaSlicer/main/resources/profiles/{vendor}/{machine}_cover.png';

    public function import(): void
    {
        Map::query()
            ->with('vendor')
            ->where('type', SourceType::Machine)
            ->each(fn (Map $map) => $this->store($map));
    }

    protected function store(Map $map): void
    {
        $map->vendor->machines()->updateOrCreate([
            'title' => $map->vendor->title,
        ], [
            'cover' => $this->url($map->profile, $map->key),
        ]);
    }

    protected function url(string $vendor, string $machine): string
    {
        return str_replace([
            '{vendor}',
            '{machine}',
        ], [
            $this->encode($vendor),
            $this->encode($machine),
        ], $this->url);
    }

    protected function encode(string $value): string
    {
        return rawurlencode($value);
    }
}
