<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class UserFilament extends Pivot
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'machine_id',
        'filament_id',
        'color_id',
        'external_id',

        'pressure_advance',

        'filament_flow_ratio',
        'filament_max_volumetric_speed',

        'nozzle_temperature',
        'nozzle_temperature_initial_layer',
    ];

    protected function casts(): array
    {
        return [
            'pressure_advance' => 'float',

            'filament_flow_ratio'           => 'float',
            'filament_max_volumetric_speed' => 'float',

            'nozzle_temperature'               => 'int',
            'nozzle_temperature_initial_layer' => 'int',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function machine(): BelongsTo
    {
        return $this->belongsTo(Machine::class, 'machine_id', 'id');
    }

    public function filament(): BelongsTo
    {
        return $this->belongsTo(Filament::class, 'filament_id', 'id');
    }

    public function color(): BelongsTo
    {
        return $this->belongsTo(Color::class, 'color_id', 'id');
    }
}
