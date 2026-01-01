<?php

declare(strict_types=1);

use App\Models\Filament;
use App\Models\User;
use DragonCode\LaravelDeployOperations\Operation;

return new class extends Operation {
    protected array $items = [
        [
            'filament' => 'Bambu Lab PETG HF Yellow',

            'nozzle_temp_first_layer'  => 235,
            'nozzle_temp_other_layers' => 235,

            'cool_plate_temp_first_layer'  => 70,
            'cool_plate_temp_other_layers' => 70,

            'pei_plate_temp_first_layer'  => 70,
            'pei_plate_temp_other_layers' => 70,

            'max_volumetric_speed' => 24,
        ],
        [
            'filament' => 'BestFilament PETG Green',

            'nozzle_temp_first_layer'  => 245,
            'nozzle_temp_other_layers' => 245,

            'cool_plate_temp_first_layer'  => 60,
            'cool_plate_temp_other_layers' => 60,

            'pei_plate_temp_first_layer'  => 80,
            'pei_plate_temp_other_layers' => 80,

            'max_volumetric_speed' => 15,
        ],
        [
            'filament' => 'BestFilament PETG Blue',

            'nozzle_temp_first_layer'  => 245,
            'nozzle_temp_other_layers' => 245,

            'cool_plate_temp_first_layer'  => 60,
            'cool_plate_temp_other_layers' => 60,

            'pei_plate_temp_first_layer'  => 80,
            'pei_plate_temp_other_layers' => 80,

            'max_volumetric_speed' => 20,
        ],
        [
            'filament' => 'Creality PETG-HS Grey',

            'nozzle_temp_first_layer'  => 220,
            'nozzle_temp_other_layers' => 220,

            'cool_plate_temp_first_layer'  => 55,
            'cool_plate_temp_other_layers' => 55,

            'pei_plate_temp_first_layer'  => 50,
            'pei_plate_temp_other_layers' => 50,

            'max_volumetric_speed' => 23,
        ],
        [
            'filament' => 'Creality PETG-HS White',

            'nozzle_temp_first_layer'  => 220,
            'nozzle_temp_other_layers' => 220,

            'cool_plate_temp_first_layer'  => 55,
            'cool_plate_temp_other_layers' => 55,

            'pei_plate_temp_first_layer'  => 50,
            'pei_plate_temp_other_layers' => 50,

            'max_volumetric_speed' => 22,
        ],
        [
            'filament' => 'Geetech PLA Silk Gold',

            'nozzle_temp_first_layer'  => 222,
            'nozzle_temp_other_layers' => 222,

            'cool_plate_temp_first_layer'  => 65,
            'cool_plate_temp_other_layers' => 65,

            'pei_plate_temp_first_layer'  => 65,
            'pei_plate_temp_other_layers' => 65,

            'max_volumetric_speed' => 10,
        ],
        [
            'filament' => 'Syntech PETG Blue',

            'nozzle_temp_first_layer'  => 240,
            'nozzle_temp_other_layers' => 240,

            'cool_plate_temp_first_layer'  => 60,
            'cool_plate_temp_other_layers' => 60,

            'pei_plate_temp_first_layer'  => 70,
            'pei_plate_temp_other_layers' => 70,

            'max_volumetric_speed' => 16.5,
        ],
    ];

    public function __invoke(): void
    {
        $user = $this->user();

        foreach ($this->items as $item) {
            $filament = $this->filament($item['filament']);

            $this->store($user, $filament, $item);
        }
    }

    protected function store(User $user, Filament $filament, array $values): void
    {
        $user->filaments()->attach($filament, $values);
    }

    protected function user(): User
    {
        return User::firstWhere('email', config('user.admin.email'));
    }

    protected function filament(string $title): Filament
    {
        return Filament::firstWhere(['title' => $title]);
    }
};
