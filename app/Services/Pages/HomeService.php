<?php

declare(strict_types=1);

namespace App\Services\Pages;

use App\Models\Color;
use App\Models\FilamentType;
use App\Models\Machine;
use App\Models\UserFilament;
use Illuminate\Database\Eloquent\Builder;
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
            ->get(['id', 'title', 'hex']);
    }

    public function userFilaments(int $machineId, int $filamentTypeId, int $colorId, int $count = 100): Collection
    {
        return UserFilament::query()
            ->select([
                'machine_id',
                'filament_id',
                'color_id',
            ])
            ->selectRaw('count(*) as users_count')
            ->selectRaw('avg(pressure_advance) as pressure_advance')
            ->selectRaw('avg(filament_flow_ratio) as filament_flow_ratio')
            ->selectRaw('avg(filament_max_volumetric_speed) as filament_max_volumetric_speed')
            ->selectRaw('avg(nozzle_temperature) as nozzle_temperature')
            ->when($machineId, fn (Builder $builder) => $builder->where('machine_id', $machineId))
            ->when($colorId, fn (Builder $builder) => $builder->where('color_id', $colorId))
            ->when($filamentTypeId, fn (Builder $builder) => $builder
                ->whereRelation('filament', 'filament_type_id', $filamentTypeId)
            )
            ->with([
                'machine.vendor',
                'filament' => ['vendor', 'type'],
                'color',
            ])
            ->orderBy('machine_id')
            ->orderBy('filament_id')
            ->orderBy('color_id')
            ->groupBy(['machine_id', 'filament_id', 'color_id'])
            ->limit($count)
            ->get();
    }
}
