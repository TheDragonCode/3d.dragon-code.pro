<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\SourceType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class Map extends Model
{
    protected $fillable = [
        'parent_id',
        'vendor_id',

        'type',
        'profile',

        'key',
        'path',
    ];

    protected function casts(): array
    {
        return [
            'type' => SourceType::class,
        ];
    }

    public function parent(): Relation
    {
        return $this->belongsTo(static::class, 'parent_id', 'id');
    }

    public function vendor(): Relation
    {
        return $this->belongsTo(Vendor::class);
    }
}
