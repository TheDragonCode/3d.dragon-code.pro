<?php

declare(strict_types=1);

namespace App\Concerns;

use App\Models\FilamentType;

trait WithFilaments
{
    protected array $filamentTypes = [];

    protected function filamentType(string $value): FilamentType
    {
        return $this->filamentTypes[$value] ??= FilamentType::firstOrCreate(['title' => $value]);
    }
}
