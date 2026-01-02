<?php

declare(strict_types=1);

use App\Models\LayerHeight;
use DragonCode\LaravelDeployOperations\Operation;

return new class extends Operation {
    protected array $values = [
        0.12,
        0.16,
        0.2,
        0.24,
    ];

    public function __invoke(): void
    {
        foreach ($this->values as $value) {
            LayerHeight::create(['title' => $value]);
        }
    }
};
