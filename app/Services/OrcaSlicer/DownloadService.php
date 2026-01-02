<?php

declare(strict_types=1);

namespace App\Services\OrcaSlicer;

use Illuminate\Container\Attributes\Config;
use Illuminate\Container\Attributes\Storage;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use RuntimeException;
use ZipArchive;

use function dirname;

class DownloadService
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
            ->sink($this->path(false))
            ->throw()
            ->get($this->source)
            ->throw();
    }

    public function extract(): void
    {
        $archive     = $this->path(false);
        $destination = dirname($this->path());

        File::ensureDirectoryExists($destination);

        $zip = new ZipArchive;

        if ($zip->open($archive) !== true) {
            throw new RuntimeException('Unable to open archive: ' . $archive);
        }

        if (! $zip->extractTo($destination)) {
            $zip->close();

            throw new RuntimeException('Unable to extract archive to destination: ' . $destination);
        }

        $zip->close();
    }

    public function release(): void
    {
        $this->cleanup(false);

        $this->storage->move(
            'temp/' . $this->directory,
            $this->directory
        );

        $this->cleanup();
    }

    public function cleanup(bool $temp = true): void
    {
        $filename = $this->archiveFilename($temp);

        if ($this->storage->exists($filename)) {
            $this->storage->delete($filename);
        }

        $this->storage->deleteDirectory($this->tempPrefix($temp) . $this->directory);
    }

    protected function path(bool $temp = true): string
    {
        return $this->storage->path(
            $this->archiveFilename($temp)
        );
    }

    protected function archiveFilename(bool $temp): string
    {
        return $this->tempPrefix($temp) . $this->archive;
    }

    protected function tempPrefix(bool $temp): string
    {
        return $temp ? 'temp/' : '';
    }
}
