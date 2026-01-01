<?php

declare(strict_types=1);

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SlugCast implements CastsAttributes
{
    public function get(Model $model, string $key, mixed $value, array $attributes): string
    {
        return $value;
    }

    public function set(Model $model, string $key, mixed $value, array $attributes): string
    {
        return Str::of($value)->squish()->slug()->toString();
    }
}
