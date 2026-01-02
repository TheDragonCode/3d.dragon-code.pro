<?php

declare(strict_types=1);

namespace App\Casts;

use App\Exceptions\UnknownFilamentTypeException;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

use function report;

class FilamentTitleCast implements CastsAttributes
{
    public function get(Model $model, string $key, mixed $value, array $attributes): string
    {
        return $value;
    }

    public function set(Model $model, string $key, mixed $value, array $attributes): string
    {
        if ($title = $this->perform($value)) {
            return $title;
        }

        report(new UnknownFilamentTypeException($value));

        return 'Unknown';
    }

    protected function perform(string $value): string
    {
        return Str::of($value)
            ->replace(['Generic', 'Value'], '')
            ->replace(['High Speed', '@HS', ' HS'], '-HS', false)
            ->replace(['High Flow', '@HF', ' HF'], '-HF', false)
            ->replace(' plus', '+', false)
            ->replace('-silk', ' Silk', false)
            ->replace('-wood', ' Wood', false)
            ->before('@')
            ->squish()
            ->match('/[^\d]([A-Z]{2,4}[+\-\s]?([A-Z]{2,4}|Silk|Wood)?)/')
            ->squish()
            ->trim('-')
            ->toString();
    }
}
