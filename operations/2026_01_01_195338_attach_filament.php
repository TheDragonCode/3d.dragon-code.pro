<?php

declare(strict_types=1);

use App\Models\Filament;
use App\Models\Machine;
use App\Models\User;
use DragonCode\LaravelDeployOperations\Operation;

return new class extends Operation {
    protected array $items = [
        [
            'filament' => 'Bambu Lab PETG HF Yellow',

            'nozzle_temperature_initial_layer' => 235,
            'nozzle_temperature'               => 235,

            'pressure_advance' => 0.0701,

            'filament_flow_ratio'           => 1.045,
            'filament_max_volumetric_speed' => 24,
        ],
        [
            'filament' => 'BestFilament PETG Green',

            'nozzle_temperature_initial_layer' => 245,
            'nozzle_temperature'               => 245,

            'pressure_advance' => 0.092,

            'filament_flow_ratio'           => 0.9975,
            'filament_max_volumetric_speed' => 15,
        ],
        [
            'filament' => 'BestFilament PETG Blue',

            'nozzle_temperature_initial_layer' => 245,
            'nozzle_temperature'               => 245,

            'pressure_advance' => 0.0764,

            'filament_flow_ratio'           => 0.9971,
            'filament_max_volumetric_speed' => 20,
        ],
        [
            'filament' => 'Creality PETG-HS Grey',

            'nozzle_temperature_initial_layer' => 220,
            'nozzle_temperature'               => 220,

            'pressure_advance' => 0.0485,

            'filament_flow_ratio'           => 0.9912,
            'filament_max_volumetric_speed' => 23,
        ],
        [
            'filament' => 'Creality PETG-HS White',

            'nozzle_temperature_initial_layer' => 220,
            'nozzle_temperature'               => 220,

            'pressure_advance' => 0.0672,

            'filament_flow_ratio'           => 0.972,
            'filament_max_volumetric_speed' => 22,
        ],
        [
            'filament' => 'Geetech PLA Silk Gold',

            'nozzle_temperature_initial_layer' => 222,
            'nozzle_temperature'               => 222,

            'pressure_advance' => 0.0598,

            'filament_flow_ratio'           => 0.9668,
            'filament_max_volumetric_speed' => 10,
        ],
        [
            'filament' => 'Syntech PETG Blue',

            'nozzle_temperature_initial_layer' => 240,
            'nozzle_temperature'               => 240,

            'pressure_advance' => 0.0876,

            'filament_flow_ratio'           => 0.9975,
            'filament_max_volumetric_speed' => 16.5,
        ],
    ];

    public function __invoke(): void
    {
        $user    = $this->user();
        $machine = $this->machine();

        foreach ($this->items as $item) {
            $filament = $this->filament($item['filament']);

            $item['machine_id'] = $machine->id;

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

    protected function machine(): Machine
    {
        return Machine::firstOrFail();
    }
};
