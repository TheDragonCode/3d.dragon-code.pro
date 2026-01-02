<?php

declare(strict_types=1);

namespace App\Services\OrcaSlicer;

use App\Data\OrcaSlicer\MachineData;
use App\Data\OrcaSlicer\ProfileData;
use App\Models\Nozzle;
use App\Models\Vendor;
use Illuminate\Container\Attributes\Config;
use Illuminate\Container\Attributes\Storage;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use SplFileInfo;

use function file_get_contents;
use function in_array;
use function json_decode;

class ImportService
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
        #[Config('orca_slicer.except_files')]
        protected array $exceptFiles,
    ) {}

    public function profiles(): void
    {
        foreach ($this->files() as $profile) {
            if ($this->needSkip($profile)) {
                continue;
            }

            $data = $this->load(
                $profile->getRealPath(),
                $this->profileDirectory($profile),
                $this->profileName($profile)
            );

            $vendor = $this->vendor($data->title);

            $this->machines($vendor, $data->machines);
        }
    }

    protected function machines(Vendor $vendor, Collection $items): void
    {
        $items->each(function (MachineData $machine) use ($vendor) {
            $vendor->machines()->updateOrCreate([
                'title' => $machine->title,
            ], $machine->toArray());

            $this->nozzles($machine->nozzleDiameters);
        });
    }

    protected function nozzles(array $diameters): void
    {
        foreach ($diameters as $diameter) {
            Nozzle::firstOrCreate(['title' => $diameter]);
        }
    }

    protected function vendor(string $name): Vendor
    {
        return Vendor::firstOrCreate(['title' => $name]);
    }

    protected function load(string $path, string $directory, string $profile): ProfileData
    {
        return ProfileData::from([
            'data' => json_decode(file_get_contents($path), true),
            'meta' => [
                'directory' => $directory,
                'profile'   => $profile,
            ],
        ]);
    }

    protected function needSkip(SplFileInfo $file): bool
    {
        if ($file->getExtension() !== 'json') {
            return true;
        }

        return in_array($file->getFilename(), $this->exceptFiles, true);
    }

    /**
     * @return SplFileInfo[]
     */
    protected function files(): array
    {
        return File::files(
            $this->getMachinesPath()
        );
    }

    protected function profileDirectory(SplFileInfo $profile): string
    {
        $path      = $profile->getRealPath();
        $extension = $profile->getExtension();

        return Str::beforeLast($path, ".$extension");
    }

    protected function profileName(SplFileInfo $profile): string
    {
        $filename  = $profile->getFilename();
        $extension = $profile->getExtension();

        return Str::beforeLast($filename, ".$extension");
    }

    protected function getMachinesPath(): string
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
