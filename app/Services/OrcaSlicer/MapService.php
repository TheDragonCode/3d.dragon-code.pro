<?php

declare(strict_types=1);

namespace App\Services\OrcaSlicer;

use App\Concerns\WithVendor;
use App\Enums\SourceType;
use App\Models\Map;
use App\Models\Vendor;
use Illuminate\Container\Attributes\Config;
use Illuminate\Container\Attributes\Storage;
use Illuminate\Filesystem\FilesystemAdapter;

class MapService
{
    use WithVendor;

    public function __construct(
        #[Storage('orca_resources')]
        protected FilesystemAdapter $storage,
        #[Config('orca_slicer.except_files')]
        protected array $exceptFiles,
    ) {}

    public function import(): void
    {
        foreach ($this->profiles() as $filename) {
            if ($this->skip($filename)) {
                continue;
            }

            $profile = $this->load($filename);

            $vendor = $this->vendor(
                $profile['name']
            );

            $name = $this->profileName($filename);

            $this->machines($vendor, $name, $profile['machine_model_list']);
            $this->filaments($vendor, $name, $profile['filament_list']);
            $this->processes($vendor, $name, $profile['process_list']);
        }
    }

    public function importSubFilaments(): void
    {
        Map::query()
            ->where('type', SourceType::Filament)
            ->whereRaw('(LENGTH("path") - LENGTH(REPLACE("path", \'/\', \'\'))) = 3')
            ->get()
            ->each(fn (Map $map) => $this->subFilament($map));
    }

    protected function subFilament(Map $map): void
    {
        $profile = explode('/', $map->path)[2];

        $vendor = $this->vendor($profile);

        $item = $map->replicate()->fill([
            'parent_id' => $map->id,
            'vendor_id' => $vendor->id,
            'profile'   => $profile,
        ]);

        if ($item->doesntExist()) {
            $item->save();
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
            'profile' => $profile,
            'path'    => $profile . '/' . $path,
        ]);
    }

    /**
     * @return string[]
     */
    protected function profiles(): array
    {
        return $this->storage->files('profiles');
    }

    protected function profileName(string $filename): string
    {
        return pathinfo($filename, PATHINFO_FILENAME);
    }

    protected function skip(string $filename): bool
    {
        if (pathinfo($filename, PATHINFO_EXTENSION) !== 'json') {
            return true;
        }

        return in_array(pathinfo($filename, PATHINFO_BASENAME), $this->exceptFiles, true);
    }

    protected function load(string $filename): array
    {
        return $this->storage->json($filename);
    }
}
