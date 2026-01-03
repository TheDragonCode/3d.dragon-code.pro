<?php

declare(strict_types=1);

namespace App\Concerns;

use App\Models\Vendor;

trait WithVendor
{
    protected array $vendors = [];

    protected function vendor(string $name): Vendor
    {
        return $this->vendors[$name] ??= Vendor::firstOrCreate(['title' => $name]);
    }
}
