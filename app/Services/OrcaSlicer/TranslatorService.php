<?php

declare(strict_types=1);

namespace App\Services\OrcaSlicer;

use Gettext\Loader\PoLoader;
use Illuminate\Container\Attributes\Config;
use Illuminate\Container\Attributes\Storage;
use Illuminate\Filesystem\FilesystemAdapter;

class TranslatorService
{
    public function __construct(
        #[Storage('orca_slicer')]
        protected FilesystemAdapter $storage,
        #[Config('orca_slicer.directory')]
        protected string $directory,
        protected PoLoader $translator,
    ) {}

    public function translate(string $locale, string $value): string
    {
        $translations = $this->translator->loadFile(
            $this->path("localization/i18n/$locale/OrcaSlicer_$locale.po")
        );

        return $translations->find(null, $value)?->getTranslation() ?? $value;
    }

    protected function path(string $filename): string
    {
        return $this->storage->path($this->directory . DIRECTORY_SEPARATOR . $filename);
    }
}
