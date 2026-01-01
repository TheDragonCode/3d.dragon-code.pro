<?php

declare(strict_types=1);

use App\Models\Vendor;
use DragonCode\LaravelDeployOperations\Operation;

return new class extends Operation {
    public function __invoke(): void
    {
        $this->machine($this->vendor(), 'K1 Max');
    }

    protected function machine(Vendor $vendor, string $title): void
    {
        $vendor->machines()->create([
            'title' => $title,
        ]);
    }

    protected function vendor(): Vendor
    {
        return Vendor::create([
            'title' => 'Creality',
        ]);
    }
};
