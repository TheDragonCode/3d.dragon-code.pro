<?php

declare(strict_types=1);

namespace App\Services\OrcaSlicer;

use Illuminate\Container\Attributes\Config;
use Illuminate\Container\Attributes\Storage;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\Facades\Http;
use RuntimeException;
use ZipArchive;

use function dirname;

class OrcaSlicerService
{
    public function __construct(
        #[Storage('orca_slicer')]
        protected FilesystemAdapter $storage,
        #[Config('orca_slicer.source')]
        protected string $source,
        #[Config('orca_slicer.archive')]
        protected string $archive,
        #[Config('orca_slicer.directory')]
        protected string $directory,
    ) {}

    public function download(): void
    {
        Http::timeout(120)
            ->sink($this->path())
            ->throw()
            ->get($this->source)
            ->throw();
    }

    public function extract(): void
    {
        $archive     = $this->path();
        $destination = dirname($archive);

        $zip = new ZipArchive;

        if ($zip->open($this->path()) !== true) {
            throw new RuntimeException('Unable to open archive: ' . $archive);
        }

        if (! $zip->extractTo($destination)) {
            $zip->close();

            throw new RuntimeException('Unable to extract archive to destination: ' . $destination);
        }

        $zip->close();
    }

    public function cleanup(): void
    {
        if ($this->storage->exists($this->archive)) {
            $this->storage->delete($this->archive);
        }

        $this->storage->deleteDirectory($this->directory);
    }

    protected function path(): string
    {
        return $this->storage->path(
            $this->archive
        );
    }
}
