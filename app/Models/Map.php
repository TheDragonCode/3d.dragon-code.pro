<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\SourceType;
use Illuminate\Database\Eloquent\Model;

class Map extends Model
{
    protected $fillable = [
        'type',
        'vendor',
        'key',
        'path',
    ];

    protected function casts(): array
    {
        return [
            'type' => SourceType::class,
        ];
    }
}
