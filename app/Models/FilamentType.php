<?php

declare(strict_types=1);

namespace App\Models;

use App\Casts\FilamentTitleCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FilamentType extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
    ];

    protected function casts(): array
    {
        return [
            'title' => FilamentTitleCast::class,
        ];
    }
}
