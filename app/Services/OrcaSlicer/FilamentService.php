<?php

declare(strict_types=1);

namespace App\Services\OrcaSlicer;

use App\Data\OrcaSlicer\FilamentData;
use App\Exceptions\FilamentProfileNotFoundException;
use Illuminate\Container\Attributes\Config;
use Illuminate\Container\Attributes\Storage;
use Illuminate\Filesystem\FilesystemAdapter;

use function array_merge;
use function file_exists;
use function file_get_contents;
use function implode;
use function json_decode;
use function report;

class FilamentService
{
    public function __construct(
        #[Storage('orca_slicer')]
        protected FilesystemAdapter $storage,
        #[Config('orca_slicer.directory')]
        protected string $directory
    ) {}

    public function get(string $vendor, string $profile, array $meta): ?FilamentData
    {
        if (! $parameters = $this->parameters($vendor, $profile)) {
            return null;
        }

        $parameters['machine'] = $profile;
        $parameters['meta']    = $meta;

        return FilamentData::from($parameters);
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
        $path = $this->path($vendor, $profile);

        if (! file_exists($path)) {
            report(new FilamentProfileNotFoundException($vendor, $profile, $path));

            return [];
        }

        return json_decode(file_get_contents($this->path($vendor, $profile)), true);
    }

    protected function path(string $vendor, string $profile): string
    {
        return $this->storage->path(implode(DIRECTORY_SEPARATOR, [
            $this->directory,
            'resources/profiles',
            $vendor,
            'filament',
            $profile . '.json',
        ]));
    }
}
