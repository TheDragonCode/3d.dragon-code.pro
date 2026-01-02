<?php

declare(strict_types=1);

use App\Models\Color;
use DragonCode\LaravelDeployOperations\Operation;

return new class extends Operation {
    protected array $values = [
        ['Natural', 'transparent'],
        ['Black', '#000000'],
        ['White', '#FFFFFF'],
        ['Grey', '#808080'],
        ['Red', '#FF0000'],
        ['Green', '#00FF00'],
        ['Blue', '#0000FF'],
        ['Yellow', '#FFFF00'],
        ['Purple', '#800080'],
        ['Cyan', '#00FFFF'],
        ['Orange', '#FFA500'],
        ['Pink', '#FFC0CB'],
        ['Brown', '#A52A2A'],
        ['Teal', '#008080'],
        ['Lime', '#00FF00'],
        ['Maroon', '#800000'],
        ['Navy', '#000080'],
        ['Olive', '#808000'],
        ['Silver', '#C0C0C0'],
        ['Aqua', '#00FFFF'],
        ['Gold', '#FFD700'],
        ['Bronse', '#CD7F32'],
        ['Marble', '#F7F3F0'],
    ];

    public function __invoke(): void
    {
        foreach ($this->values as $item) {
            Color::updateOrCreate(
                ['title' => $item[0]],
                ['hex' => $item[1]]
            );
        }
    }
};
