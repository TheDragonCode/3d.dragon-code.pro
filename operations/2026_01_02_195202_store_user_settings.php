<?php

declare(strict_types=1);

use App\Concerns\WithColor;
use App\Concerns\WithFilaments;
use App\Concerns\WithVendor;
use App\Models\Color;
use App\Models\Filament;
use App\Models\Machine;
use App\Models\User;
use DragonCode\LaravelDeployOperations\Operation;

return new class extends Operation {
    use WithVendor;
    use WithFilaments;
    use WithColor;

    protected array $items = [
        [
            'vendor' => 'Bambulab',
            'type'   => 'PETG-HF',
            'color'  => 'Yellow',

            'pressure_advance' => 0.0701,

            'filament_flow_ratio'           => 1.045,
            'filament_max_volumetric_speed' => 24,

            'nozzle_temperature'               => 235,
            'nozzle_temperature_initial_layer' => 235,
        ],
        [
            'vendor' => 'BestFilament',
            'type'   => 'PETG',
            'color'  => 'Green',

            'pressure_advance' => 0.092,

            'filament_flow_ratio'           => 0.9975,
            'filament_max_volumetric_speed' => 15,

            'nozzle_temperature'               => 245,
            'nozzle_temperature_initial_layer' => 245,
        ],
        [
            'vendor' => 'BestFilament',
            'type'   => 'PETG',
            'color'  => 'Blue',

            'pressure_advance' => 0.07638,

            'filament_flow_ratio'           => 0.9971,
            'filament_max_volumetric_speed' => 20,

            'nozzle_temperature'               => 245,
            'nozzle_temperature_initial_layer' => 245,
        ],
        [
            'vendor' => 'BestFilament',
            'type'   => 'PLA',
            'color'  => 'Grey',

            'pressure_advance' => 0.03991,

            'filament_flow_ratio'           => 0.98,
            'filament_max_volumetric_speed' => 21,

            'nozzle_temperature'               => 225,
            'nozzle_temperature_initial_layer' => 225,
        ],
        [
            'vendor' => 'Creality',
            'type'   => 'PLA-HS',
            'color'  => 'Grey',

            'pressure_advance' => 0.04852,

            'filament_flow_ratio'           => 0.991188,
            'filament_max_volumetric_speed' => 23,

            'nozzle_temperature'               => 220,
            'nozzle_temperature_initial_layer' => 220,
        ],
        [
            'vendor' => 'Creality',
            'type'   => 'PLA-HS',
            'color'  => 'White',

            'pressure_advance' => 0.0672,

            'filament_flow_ratio'           => 0.972,
            'filament_max_volumetric_speed' => 22,

            'nozzle_temperature'               => 220,
            'nozzle_temperature_initial_layer' => 220,
        ],
        [
            'vendor' => 'eSUN',
            'type'   => 'PETG-HS',
            'color'  => 'White',

            'pressure_advance' => 0.09078,

            'filament_flow_ratio'           => 1.0291,
            'filament_max_volumetric_speed' => 21.5,

            'nozzle_temperature'               => 260,
            'nozzle_temperature_initial_layer' => 260,
        ],
        [
            'vendor' => 'eSUN',
            'type'   => 'PLA Silk',
            'color'  => 'Green',

            'pressure_advance' => 0.054,

            'filament_flow_ratio'           => 0.9849,
            'filament_max_volumetric_speed' => 17.185,

            'nozzle_temperature'               => 220,
            'nozzle_temperature_initial_layer' => 220,
        ],
        [
            'vendor' => 'Geeetech',
            'type'   => 'PLA Silk',
            'color'  => 'Gold',

            'pressure_advance' => 0.05976,

            'filament_flow_ratio'           => 0.96679,
            'filament_max_volumetric_speed' => 10,

            'nozzle_temperature'               => 225,
            'nozzle_temperature_initial_layer' => 225,
        ],
        [
            'vendor' => 'Syntech',
            'type'   => 'PETG',
            'color'  => 'Blue',

            'pressure_advance' => 0.0876,

            'filament_flow_ratio'           => 0.9975,
            'filament_max_volumetric_speed' => 16.5,

            'nozzle_temperature'               => 240,
            'nozzle_temperature_initial_layer' => 240,
        ],
        [
            'vendor' => 'Syntech',
            'type'   => 'PETG',
            'color'  => 'Green',

            'pressure_advance' => 0.081,

            'filament_flow_ratio'           => 0.97,
            'filament_max_volumetric_speed' => 14,

            'nozzle_temperature'               => 245,
            'nozzle_temperature_initial_layer' => 245,
        ],
        [
            'vendor' => 'Syntech',
            'type'   => 'PETG',
            'color'  => 'White',

            'pressure_advance' => 0.06,

            'filament_flow_ratio'           => 0.927675,
            'filament_max_volumetric_speed' => 19,

            'nozzle_temperature'               => 235,
            'nozzle_temperature_initial_layer' => 235,
        ],
    ];

    protected ?Machine $machine;

    protected array $colors = [];

    public function __invoke(): void
    {
        $user    = $this->user();
        $machine = $this->machine();

        foreach ($this->items as $item) {
            $vendor   = $this->vendor($item['vendor']);
            $type     = $this->filamentType($item['type']);
            $filament = $this->filament($vendor, $type);
            $color    = $this->color($item['color']);
            $id       = $this->makeId($item);

            $this->store($user, $machine, $filament, $color, $id, $item);
        }
    }

    protected function makeId(array $item): string
    {
        return implode('-', [$item['vendor'], $item['type'], $item['color']]);
    }

    protected function store(
        User $user,
        Machine $machine,
        Filament $filament,
        Color $color,
        string $id,
        array $values
    ): void {
        $user->filaments()->attach($filament, [
            'machine_id'  => $machine->id,
            'color_id'    => $color->id,
            'external_id' => $id,
            ...$values,
        ]);
    }

    protected function user(): User
    {
        return User::firstWhere('email', config('user.admin.email'));
    }

    protected function machine(): Machine
    {
        return $this->machine ??= Machine::firstWhere('slug', 'k1-max');
    }
};
