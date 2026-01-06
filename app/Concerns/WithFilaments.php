<?php

declare(strict_types=1);

namespace App\Concerns;

use App\Models\Filament;
use App\Models\FilamentType;
use App\Models\Vendor;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

trait WithFilaments
{
    protected array $filamentTypes = [];

    protected array $filaments = [];

    protected ?Collection $loadedFilamentTypes = null;

    protected function filamentType(string $name): FilamentType
    {
        return $this->filamentTypes[$name] ??= FilamentType::query()
            ->whereRaw('lower(title) = ?', [Str::lower($name)])
            ->firstOrCreate(values: ['title' => $name]);
    }

    protected function filament(Vendor $vendor, FilamentType $filamentType): Filament
    {
        $key = $vendor->id . '-' . $filamentType->id;

        return $this->filaments[$key] ??= $vendor->filaments()->updateOrCreate([
            'filament_type_id' => $filamentType->id,
        ]);
    }

    /**
     * @return Collection<FilamentType>
     */
    protected function getFilamentTypes(): Collection
    {
        return $this->loadedFilamentTypes ??= FilamentType::query()
            ->orderByRaw('LENGTH("title") DESC')
            ->orderByDesc('title')
            ->get()
            ->keyBy('title');
    }
}
