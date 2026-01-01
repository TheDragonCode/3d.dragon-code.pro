<?php

declare(strict_types=1);

use App\Models\Nozzle;
use DragonCode\LaravelDeployOperations\Operation;

return new class extends Operation {
    public function __invoke(): void
    {
        Nozzle::create([
            'title' => 0.4,
        ]);
    }
};
