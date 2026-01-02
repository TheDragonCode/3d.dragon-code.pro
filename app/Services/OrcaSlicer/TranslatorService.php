<?php

declare(strict_types=1);

namespace App\Services\OrcaSlicer;

use Gettext\Loader\PoLoader;
use Gettext\Translations;
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
        return $this->translations($locale)->find(null, $value)?->getTranslation() ?? $value;
    }

    protected function translations(string $locale): Translations
    {
        return $this->translator->loadFile(
            $this->getLocaleFilePath($locale)
        );
    }

    protected function getLocaleFilePath(string $locale): string
    {
        return $this->path("localization/i18n/$locale/OrcaSlicer_$locale.po");
    }

    protected function path(string $filename): string
    {
        return $this->storage->path(
            $this->directory . DIRECTORY_SEPARATOR . $filename
        );
    }
}
