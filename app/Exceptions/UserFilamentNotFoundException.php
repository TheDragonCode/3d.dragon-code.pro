<?php

declare(strict_types=1);

namespace App\Exceptions;

use OutOfRangeException;

class UserFilamentNotFoundException extends OutOfRangeException
{
    public function __construct(string $vendor, string $filament)
    {
        parent::__construct("Vendor: [$vendor] Filament: [$filament]");
    }
}
