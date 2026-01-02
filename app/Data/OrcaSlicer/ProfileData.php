<?php

namespace App\Data\OrcaSlicer;

use App\Data\Casts\OrcaSlicer\MachinesCast;
use Illuminate\Support\Collection;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Data;

class ProfileData extends Data
{
    public function __construct(
        #[MapInputName('data.name')]
        public string $title,

        #[MapInputName('data.machine_model_list')]
        #[WithCast(MachinesCast::class)]
        public Collection $machines
    ) {}
}
