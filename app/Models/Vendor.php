<?php

declare(strict_types=1);

namespace App\Models;

use App\Casts\SlugCast;
use App\Events\SluggableEvent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vendor extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'slug',
        'title',
    ];

    protected $dispatchesEvents = [
        'saving' => SluggableEvent::class,
    ];

    protected function casts(): array
    {
        return [
            'slug' => SlugCast::class,
        ];
    }

    public function machines(): Relation
    {
        return $this->hasMany(Machine::class);
    }

    public function filaments(): Relation
    {
        return $this->hasMany(Filament::class);
    }

    public function maps(): HasMany
    {
        return $this->hasMany(Map::class);
    }
}
