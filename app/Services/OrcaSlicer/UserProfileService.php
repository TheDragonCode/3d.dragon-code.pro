<?php

declare(strict_types=1);

namespace App\Services\OrcaSlicer;

use App\Concerns\WithColor;
use App\Data\OrcaSlicer\FilamentData;
use App\Models\Filament;
use App\Models\Machine;
use App\Models\User;
use Illuminate\Support\Str;

class UserProfileService
{
    use WithColor;

    public function __construct(
        protected FilamentService $filament,
        protected FilamentTypeService $filamentType,
    ) {}

    public function import(User $user, Machine $machine, FilamentData $profile): void
    {
        $vendor = $this->vendor($profile->inherits);

        $filament = $this->filament($vendor, $profile->inherits);
        $color    = $this->color($profile->color);

        $content = $this->filament->get($profile)->toArray();

        $user->userFilaments()->updateOrCreate([
            'machine_id'  => $machine->id,
            'filament_id' => $filament->id,
            'color_id'    => $color->id,
        ], $content);
    }

    protected function filament(string $vendor, string $filament): Filament
    {
        $path = $vendor . '/filament/' . $filament . '.json';

        $detected = $this->filamentType->detect($vendor, $filament, $path);

        return Filament::query()
            ->whereRelation('vendor', 'title', 'ilike', '%' . $vendor . '%')
            ->whereRelation('type', 'title', $detected)
            ->firstOrFail();
    }

    protected function vendor(string $name): string
    {
        return Str::of($name)->before(' ')->trim()->toString();
    }
}
