<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\SoftDeletes;
use LaravelLang\Models\HasTranslations;

class SettingsSection extends Model
{
    use HasFactory, SoftDeletes;
    use HasTranslations;

    protected $fillable = [
        'parent_id',

        'key',
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
