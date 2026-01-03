<?php

declare(strict_types=1);

namespace App\Enums;

enum SourceType: string
{
    case Machine  = 'machine';
    case Filament = 'filament';
}
