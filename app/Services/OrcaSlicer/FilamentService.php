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

    public function get(FilamentData $filament): FilamentData
    {
        if (! $filament->inherits) {
            return $filament;
        }

        $profile = $this->profile($filament->inherits);
        $content = $this->perform($profile, $filament->inherits);

        $source = $filament->toArray();

        $source['filament_settings_id'] = $filament->externalId;

        return FilamentData::from(
            array_merge($this->clean($content), $this->clean($source))
        );
    }

    protected function perform(string $profile, string $key, array $values = []): array
    {
        if (! $path = $this->findPath($profile, $key)) {
            return $values;
        }

        $content = $this->clean(
            $this->read($path)
        );

        if (! $parent = $content['inherits'] ?? null) {
            return array_merge($content, $values);
        }

        return $this->perform($profile, $parent, array_merge($content, $values));
    }

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

    protected function clean(array $values): array
    {
        return array_filter($values);
    }
}
