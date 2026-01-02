<?php

declare(strict_types=1);

namespace App\Models;

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
        'external_id',

        'title',
    ];

    public function vendor(): Relation
    {
        return $this->belongsTo(Vendor::class);
    }

    public function type(): Relation
    {
        return $this->belongsTo(FilamentType::class);
    }
}
