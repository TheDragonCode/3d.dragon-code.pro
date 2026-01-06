<?php

declare(strict_types=1);

namespace App\Concerns;

use App\Models\Color;
use Illuminate\Support\Str;

trait WithColor
{
    protected array $colors = [];

    protected array $colorMap = [
        'Yellow' => '#FFFF00',
        'Green'  => '#00FF00',
        'Blue'   => '#0000FF',
        'Grey'   => '#808080',
        'White'  => '#FFFFFF',
        'Gold'   => '#FFCF40',
    ];

    protected function color(string $name): Color
    {
        return $this->colors[$name] ??= Color::query()
            ->whereRaw('lower(title) = ?', [Str::lower($name)])
            ->firstOrCreate(values: [
                'title' => $name,
                'hex'   => $this->colorMap[$name] ?? '#000000',
            ]);
    }
}
