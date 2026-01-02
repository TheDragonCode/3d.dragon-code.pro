<?php

declare(strict_types=1);

namespace App\Services;

use Gettext\Loader\PoLoader;
use Illuminate\Container\Attributes\Storage;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\Facades\Http;
use RuntimeException;
use ZipArchive;

use function dirname;

class OrcaSlicerService
{
    protected const string SOURCE    = 'https://github.com/OrcaSlicer/OrcaSlicer/archive/refs/heads/main.zip';
    protected const string ARCHIVE   = 'orca-slicer.zip';
    protected const string DIRECTORY = 'OrcaSlicer-main';

    public function __construct(
        #[Storage('local')]
        protected FilesystemAdapter $storage,
        protected PoLoader $translator
    ) {}

    public function download(): void
    {
        Http::timeout(120)
            ->sink($this->archivePath())
            ->throw()
            ->get(static::SOURCE)
            ->throw();
    }

    public function extract(): void
    {
        $archive     = $this->archivePath();
        $destination = dirname($archive);

        $zip = new ZipArchive;

        if ($zip->open($this->archivePath()) !== true) {
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
        if ($this->storage->exists(static::ARCHIVE)) {
            $this->storage->delete(static::ARCHIVE);
        }

        $this->storage->deleteDirectory(static::DIRECTORY);
    }

    public function translate(string $locale, string $value): string
    {
        $translations = $this->translator->loadFile(
            $this->repositoryPath("localization/i18n/$locale/OrcaSlicer_$locale.po")
        );

        return $translations->find(null, $value)?->getTranslation() ?? $value;
    }

    protected function archivePath(): string
    {
        return $this->storage->path(static::ARCHIVE);
    }

    protected function repositoryPath(string $filename = ''): string
    {
        return $this->storage->path(static::DIRECTORY . DIRECTORY_SEPARATOR . $filename);
    }
}
