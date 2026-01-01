<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Machine;
use App\Models\Nozzle;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class UserMachineFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id'    => User::factory(),
            'machine_id' => Machine::factory(),
            'nozzle_id'  => Nozzle::factory(),

            'filament_load_time'   => $this->faker->randomNumber(),
            'filament_unload_time' => $this->faker->randomNumber(),
            'tool_change_time'     => $this->faker->randomNumber(),

            'can_change_filament' => $this->faker->boolean(),

            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

        ];
    }
}
