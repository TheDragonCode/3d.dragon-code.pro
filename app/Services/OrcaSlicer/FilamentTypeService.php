<?php

declare(strict_types=1);

namespace App\Services\OrcaSlicer;

use App\Concerns\WithFilaments;
use Illuminate\Container\Attributes\Storage;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\Str;

class FilamentTypeService
{
    use WithFilaments;

    public function __construct(
        #[Storage('orca_resources')]
        protected FilesystemAdapter $storage,
    ) {}

    public function import(): void
    {
        collect($this->load())
            ->forget(['version'])
            ->flatten()
            ->unique()
            ->map(fn (string $type) => Str::contains($type, '-') ? $type : [$type, $type . '+'])
            ->flatten()
            ->crossJoin(['', 'HS'])
            ->map(fn (array $pair) => trim(implode(' ', $pair)))
            ->prepend('Unknown')
            ->each(fn (string $type) => $this->filamentType($type));
    }

    protected function load(): array
    {
        return $this->storage->json('info/filament_info.json');
    }
}
