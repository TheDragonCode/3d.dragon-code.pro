<?php

declare(strict_types=1);

namespace App\Models;

use App\Casts\SlugCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\SoftDeletes;

class Printer extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'slug',
        'title',
    ];

    protected function casts(): array
    {
        return [
            'slug' => SlugCast::class,
        ];
    }

    public function vendor(): Relation
    {
        return $this->belongsTo(Vendor::class);
    }
}
