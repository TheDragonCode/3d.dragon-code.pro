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
        'filament_id',

        'nozzle_temp_first_layer',
        'nozzle_temp_other_layers',

        'cool_plate_temp_first_layer',
        'cool_plate_temp_other_layers',

        'pei_plate_temp_first_layer',
        'pei_plate_temp_other_layers',

        'max_volumetric_speed',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function filament(): BelongsTo
    {
        return $this->belongsTo(Filament::class);
    }
}
