<?php

declare(strict_types=1);

namespace App\Models;

use LaravelLang\Models\Casts\TrimCast;
use LaravelLang\Models\Eloquent\Translation;

class SettingsSectionTranslation extends Translation
{
    protected $fillable = [
        'locale',
        'title',
    ];

    protected $casts = [
        'title' => TrimCast::class,
    ];
}
