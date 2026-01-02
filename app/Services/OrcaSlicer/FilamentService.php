<?php

declare(strict_types=1);

namespace App\Services\OrcaSlicer;

use App\Data\OrcaSlicer\FilamentData;
use Illuminate\Container\Attributes\Config;
use Illuminate\Container\Attributes\Storage;
use Illuminate\Filesystem\FilesystemAdapter;

use function array_merge;
use function file_get_contents;
use function implode;
use function json_decode;

class FilamentService
{
    public function __construct(
        #[Storage('orca_slicer')]
        protected FilesystemAdapter $storage,
        #[Config('orca_slicer.directory')]
        protected string $directory
    ) {}

    public function get(string $vendor, string $profile): FilamentData
    {
        return FilamentData::from(
            $this->parameters($vendor, $profile)
        );
    }

    protected function parameters(string $vendor, string $profile): array
    {
        $parameters = $this->load($vendor, $profile);

        if (! $parent = $parameters['inherits'] ?? false) {
            return $parameters;
        }

        $previous = $this->parameters($vendor, $parent);

        return array_merge($previous, $parameters);
    }

    protected function load(string $vendor, string $profile): array
    {
        return json_decode(file_get_contents($this->path($vendor, $profile)), true);
    }

    protected function path(string $vendor, string $profile): string
    {
        return $this->storage->path(implode(DIRECTORY_SEPARATOR, [
            $vendor,
            'filament',
            $profile . '.json',
        ]));
    }
}
