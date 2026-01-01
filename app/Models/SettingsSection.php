<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\SoftDeletes;

class SettingsSection extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'parent_id',
        'title',
    ];

    public function parent(): Relation
    {
        return $this->belongsTo(static::class);
    }

    public function childrens(): Relation
    {
        return $this->hasMany(SettingsSection::class, 'parent_id');
    }
}
