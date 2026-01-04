<?php

declare(strict_types=1);

namespace App\Services\OrcaSlicer;

use App\Data\OrcaSlicer\FilamentData;
use App\Enums\SourceType;
use App\Models\Map;
use Illuminate\Container\Attributes\Config;
use Illuminate\Container\Attributes\Storage;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\Str;

class FilamentService
{
    public function __construct(
        #[Storage('orca_slicer')]
        protected FilesystemAdapter $storage,
        #[Config('orca_slicer.directory')]
        protected string $directory,
    ) {}

    public function get(FilamentData $filament): FilamentData {}

    protected function findPath(string $profile, string $key): ?string
    {
        return Map::query()
            ->where('type', SourceType::Filament)
            ->where('profile', $profile)
            ->where('key', $key)
            ->first()?->path;
    }

    protected function profile(string $key): string
    {
        return Str::before($key, ' ');
    }

    protected function read(string $filename): array
    {
        return $this->storage->json(
            $this->directory . '/resources/profiles/' . $filename
        );
    }
}
