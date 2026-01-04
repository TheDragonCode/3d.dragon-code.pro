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
        protected FilamentProfileService $filament,
        protected FilamentService $filamentType,
    ) {}

    public function import(User $user, Machine $machine, FilamentData $profile): void
    {
        $vendor = $this->vendor($profile);

        $filament = $this->filament($vendor, $profile->inherits ?: $profile->externalId);
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

    protected function vendor(FilamentData $filament): string
    {
        return Str::of($filament->inherits ?: $filament->externalId)->before(' ')->trim()->toString();
    }
}
