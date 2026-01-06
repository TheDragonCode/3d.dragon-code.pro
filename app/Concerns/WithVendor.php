<?php

declare(strict_types=1);

namespace App\Concerns;

use App\Models\Vendor;
use Illuminate\Support\Str;

trait WithVendor
{
    protected array $vendors = [];

    protected function vendor(string $name): Vendor
    {
        return $this->vendors[$name] ??= Vendor::query()
            ->whereRaw('lower(title) = ?', [Str::lower($name)])
            ->firstOrCreate(values: ['title' => $name]);
    }
}
