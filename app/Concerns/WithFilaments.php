<?php

declare(strict_types=1);

namespace App\Concerns;

use App\Models\Filament;
use App\Models\FilamentType;
use App\Models\Vendor;

trait WithFilaments
{
    protected array $filamentTypes = [];

    protected array $filaments = [];

    protected function filamentType(string $value): FilamentType
    {
        return $this->filamentTypes[$value] ??= FilamentType::firstOrCreate(['title' => $value]);
    }

    protected function filament(Vendor $vendor, FilamentType $filamentType): Filament
    {
        $key = $vendor->id . '-' . $filamentType->id;

        return $this->filaments[$key] ??= $vendor->filaments()->updateOrCreate([
            'filament_type_id' => $filamentType->id,
        ]);
    }
}
