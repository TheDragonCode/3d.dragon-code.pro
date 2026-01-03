<?php

declare(strict_types=1);

namespace App\Concerns;

use App\Models\FilamentType;
use Illuminate\Support\Str;

trait WithFilaments
{
    protected array $filamentTypes = [];

    protected function filamentType(string $value): FilamentType
    {
        $normalized = $this->filamentTypeNormalize($value);

        return $this->filamentTypes[$value] ??= FilamentType::firstOrCreate(['title' => $normalized]);
    }

    protected function filamentTypeNormalize(string $value): string
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
            ->match('/([^\d][A-Z]{2,4}[+\-\s]?([A-Z]{2,4}|Silk|Wood)?)/')
            ->replace(' CF', '-CF', false)
            ->squish()
            ->trim('-')
            ->replaceMatches('/([A-Z]{2})[\s-]?([A-Z]{3,})/', '$2-$1')
            ->toString();
    }
}
