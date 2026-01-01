<?php

declare(strict_types=1);

namespace App\Models;

use App\Casts\SlugCast;
use App\Events\SluggableEvent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\SoftDeletes;

class Filament extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'vendor_id',
        'filament_type_id',
        'color_id',

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

    public function vendor(): Relation
    {
        return $this->belongsTo(Vendor::class);
    }

    public function type(): Relation
    {
        return $this->belongsTo(FilamentType::class);
    }

    public function color(): Relation
    {
        return $this->belongsTo(Color::class);
    }
}
