<?php

declare(strict_types=1);

namespace App\Services;

class OrcaSlicerService
{
    protected const string SOURCE = 'https://github.com/OrcaSlicer/OrcaSlicer/archive/refs/heads/main.zip';

    public function download(): void {}

    public function extract(): void {}

    public function cleanup(): void {}
}
