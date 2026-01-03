<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\SourceType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Map extends Model
{
    protected $fillable = [
        'type',
        'key',
        'path',
    ];

    protected function casts(): array
    {
        return [
            'type' => SourceType::class,
        ];
    }

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }
}
