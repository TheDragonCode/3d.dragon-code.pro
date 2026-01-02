<?php

declare(strict_types=1);

namespace App\Exceptions;

use OutOfRangeException;

class FilamentProfileNotFoundException extends OutOfRangeException
{
    public function __construct(string $vendor, string $profile, string $path)
    {
        parent::__construct("Profile [$vendor/$profile] not found in [$path].");
    }
}
