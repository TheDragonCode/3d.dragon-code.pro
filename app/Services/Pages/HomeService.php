<?php

declare(strict_types=1);

namespace App\Services\Pages;

use App\Models\Color;
use App\Models\FilamentType;
use App\Models\Machine;
use App\Models\UserFilament;
use Illuminate\Database\Eloquent\Collection;

class HomeService
{
    public function machines(): Collection
    {
        return Machine::query()
            ->whereHas('userFilament')
            ->with('vendor')
            ->orderBy('vendor_id')
            ->orderBy('title')
            ->get(['id', 'title', 'vendor_id']);
    }

    public function filamentTypes(): Collection
    {
        return FilamentType::query()
            ->whereHas('userFilaments')
            ->orderBy('title')
            ->get(['id', 'title']);
    }

    public function colors(): Collection
    {
        return Color::query()
            ->whereHas('userFilament')
            ->orderBy('title')
            ->get(['title', 'hex']);
    }

    public function userFilaments(): Collection
    {
        return UserFilament::query()
            ->with([
                'machine.vendor',
                'filament' => ['vendor', 'type'],
                'color',
            ])
            ->orderBy('machine_id')
            ->orderBy('filament_id')
            ->orderBy('color_id')
            ->orderBy('id')
            ->get();
    }
}
