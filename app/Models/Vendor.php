<?php

declare(strict_types=1);

namespace App\Models;

use App\Casts\SlugCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vendor extends Model
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

    public function printers(): Relation
    {
        return $this->hasMany(Printer::class);
    }

    public function filaments(): Relation
    {
        return $this->hasMany(Filament::class);
    }
}
