<?php

declare(strict_types=1);

namespace App\Exceptions;

use UnexpectedValueException;

class UnknownFilamentTypeException extends UnexpectedValueException
{
    public function __construct(string $value)
    {
        parent::__construct($value);
    }
}
