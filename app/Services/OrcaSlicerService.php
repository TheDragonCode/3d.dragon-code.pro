<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Container\Attributes\Storage;
use Illuminate\Support\Facades\Http;

class OrcaSlicerService
{
    protected const string SOURCE  = 'https://github.com/OrcaSlicer/OrcaSlicer/archive/refs/heads/main.zip';
    protected const string ARCHIVE = 'orca-slicer.zip';

    public function __construct(
        #[Storage('local')]
        protected $storage
    ) {}

    public function download(): void
    {
        Http::timeout(120)
            ->sink($this->path())
            ->throw()
            ->get(static::SOURCE)
            ->throw();
    }

    public function extract(): void {}

    public function cleanup(): void
    {
        if ($this->storage->exists(static::ARCHIVE)) {
            $this->storage->delete(static::ARCHIVE);
        }
    }

    protected function path(): string
    {
        return $this->storage->path(static::ARCHIVE);
    }
}
