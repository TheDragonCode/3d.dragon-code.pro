<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;

class FilamentType extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
    ];

    public function userFilaments(): HasManyThrough
    {
        return $this->hasManyThrough(
            UserFilament::class,
            Filament::class,
            'filament_type_id',
            'filament_id',
            'id',
            'id'
        );
    }
}
