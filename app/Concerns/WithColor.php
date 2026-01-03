<?php

declare(strict_types=1);

namespace App\Concerns;

use App\Models\Color;

trait WithColor
{
    protected array $colors = [];

    protected function color(string $name): Color
    {
        return $this->colors[$name] ??= Color::firstOrCreate(['title' => $name]);
    }
}
