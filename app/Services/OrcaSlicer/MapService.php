<?php

declare(strict_types=1);

namespace App\Services\OrcaSlicer;

use App\Concerns\WithVendor;
use App\Enums\SourceType;
use App\Models\Vendor;
use Illuminate\Container\Attributes\Config;
use Illuminate\Container\Attributes\Storage;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use SplFileInfo;

class MapService
{
    use WithVendor;

    public function __construct(
        #[Storage('orca_slicer')]
        protected FilesystemAdapter $storage,
        #[Config('orca_slicer.source')]
        protected string $source,
        #[Config('orca_slicer.archive')]
        protected string $archive,
        #[Config('orca_slicer.directory')]
        protected string $directory,
        #[Config('orca_slicer.except_files')]
        protected array $exceptFiles,
    ) {}

    public function import(): void
    {
        foreach ($this->profiles() as $file) {
            if ($this->skip($file)) {
                continue;
            }

            $profile = $this->load(
                $file->getRealPath()
            );

            $vendor = $this->vendor(
                $profile['name']
            );

            $profileName = $this->profileName($file);

            $this->machines(
                $vendor,
                $profileName,
                $profile['machine_model_list']
            );

            $this->filaments(
                $vendor,
                $profileName,
                $profile['filament_list']
            );

            $this->processes(
                $vendor,
                $profileName,
                $profile['process_list']
            );
        }
    }

    protected function machines(Vendor $vendor, string $profile, array $machines): void
    {
        foreach ($machines as $machine) {
            $this->store(SourceType::Machine, $vendor, $profile, $machine['name'], $machine['sub_path']);
        }
    }

    protected function filaments(Vendor $vendor, string $profile, array $filaments): void
    {
        foreach ($filaments as $filament) {
            $this->store(SourceType::Filament, $vendor, $profile, $filament['name'], $filament['sub_path']);
        }
    }

    protected function processes(Vendor $vendor, string $profile, array $processes): void
    {
        foreach ($processes as $process) {
            $this->store(SourceType::Process, $vendor, $profile, $process['name'], $process['sub_path']);
        }
    }

    protected function store(SourceType $type, Vendor $vendor, string $profile, string $name, string $path): void
    {
        $vendor->maps()->updateOrCreate([
            'type' => $type,
            'key'  => $name,
        ], [
            'path' => $profile . '/' . $path,
        ]);
    }

    /**
     * @return SplFileInfo[]
     */
    protected function profiles(): array
    {
        return File::files(
            $this->profilesPath()
        );
    }

    protected function profileName(SplFileInfo $file): string
    {
        $name      = $file->getFilename();
        $extension = $file->getExtension();

        return Str::before($name, '.' . $extension);
    }

    protected function skip(SplFileInfo $file): bool
    {
        if ($file->getExtension() !== 'json') {
            return true;
        }

        return in_array($file->getFilename(), $this->exceptFiles, true);
    }

    protected function load(string $path): array
    {
        return json_decode(file_get_contents($path), true);
    }

    protected function profilesPath(): string
    {
        return $this->path('resources/profiles');
    }

    protected function path(string $filename): string
    {
        return $this->storage->path(
            $this->directory . DIRECTORY_SEPARATOR . $filename
        );
    }
}
