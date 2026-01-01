<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class UserMachine extends Pivot
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'machine_id',
        'nozzle_id',

        'filament_load_time',
        'filament_unload_time',
        'tool_change_time',

        'can_change_filament',
    ];

    protected $attributes = [
        'filament_load_time'   => 0,
        'filament_unload_time' => 0,
        'tool_change_time'     => 0,

        'can_change_filament' => false,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function machine(): BelongsTo
    {
        return $this->belongsTo(Machine::class);
    }

    public function nozzle(): BelongsTo
    {
        return $this->belongsTo(Nozzle::class);
    }

    protected function casts(): array
    {
        return [
            'user_id'    => 'int',
            'machine_id' => 'int',
            'nozzle_id'  => 'int',

            'filament_load_time'   => 'int',
            'filament_unload_time' => 'int',
            'tool_change_time'     => 'int',

            'can_change_filament' => 'boolean',
        ];
    }
}
