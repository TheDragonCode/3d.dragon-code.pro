<?php

declare(strict_types=1);

namespace App\Models;

use App\Casts\HexCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Color extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'hex',
    ];

    protected function casts(): array
    {
        return [
            'hex' => HexCast::class,
        ];
    }

    public function userFilament(): HasMany
    {
        return $this->hasMany(UserFilament::class);
    }
}
