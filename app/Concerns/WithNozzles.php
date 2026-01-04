<?php

declare(strict_types=1);

namespace App\Concerns;

use App\Models\Nozzle;
use Illuminate\Support\Str;

trait WithNozzles
{
    protected array $nozzles = [];

    protected function nozzle(string|float $value): Nozzle
    {
        return $this->nozzles[(string) $value] ??= Nozzle::firstOrCreate(['title' => $value]);
    }
}
