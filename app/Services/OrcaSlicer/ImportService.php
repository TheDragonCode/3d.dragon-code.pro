<?php

declare(strict_types=1);

namespace App\Services\OrcaSlicer;

use App\Data\OrcaSlicer\FilamentData;
use App\Data\OrcaSlicer\MachineData;
use App\Data\OrcaSlicer\ProfileData;
use App\Models\Filament;
use App\Models\FilamentType;
use App\Models\Machine;
use App\Models\Nozzle;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Container\Attributes\Config;
use Illuminate\Container\Attributes\Storage;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use SplFileInfo;

use function array_merge;
use function config;
use function file_get_contents;
use function in_array;
use function json_decode;

class ImportService
{
    protected array $filamentTypes = [];

    protected array $machines = [];

    protected ?User $user;

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
        foreach ($this->profileFiles() as $profile) {
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
            $this->filaments($vendor, $data->filaments);
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

    protected function filaments(Vendor $vendor, Collection $items): void
    {
        $items->each(function (FilamentData $filament) use ($vendor) {
            $type = $this->filamentType($filament->title);

            $model = $vendor->filaments()->updateOrCreate([
                'external_id' => $filament->settingId,
            ], array_merge($filament->toArray(), ['filament_type_id' => $type->id]));

            // TODO: Добавить
            //$machine = $this->machine($filament->title);
            //
            //if (! $machine) {
            //    dd(
            //        $filament->toArray()
            //    );
            //
            //    return;
            //}
            //
            //$this->userFilament($this->commonUser(), $model, $filament);
        });
    }

    protected function userFilament(User $user, Filament $filament, FilamentData $data): void
    {
        $user->filaments()->attach($filament, $data->toArray());
    }

    protected function filamentType(string $name): FilamentType
    {
        return $this->filamentTypes[$name] ??= FilamentType::firstOrCreate(['title' => $name]);
    }

    protected function machine(string $name): ?Machine
    {
        $name = Str::afterLast($name, '@');

        return $this->machines[$name] ??= Machine::firstWhere('title', $name);
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
    protected function profileFiles(): array
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

    protected function commonUser(): User
    {
        return $this->user ??= User::firstWhere('email', config('user.common.email'));
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
