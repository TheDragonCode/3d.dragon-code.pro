<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Filament;
use App\Models\User;
use App\Models\UserFilament;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class UserFilamentFactory extends Factory
{
    protected $model = UserFilament::class;

    public function definition(): array
    {
        return [
            'nozzle_temp_first_layer'  => $this->faker->randomNumber(),
            'nozzle_temp_other_layers' => $this->faker->randomNumber(),

            'cool_plate_temp_first_layer'  => $this->faker->randomNumber(),
            'cool_plate_temp_other_layers' => $this->faker->randomNumber(),

            'pei_plate_temp_first_layer'  => $this->faker->randomNumber(),
            'pei_plate_temp_other_layers' => $this->faker->randomNumber(),

            'max_volumetric_speed' => $this->faker->randomNumber(),

            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'user_id'     => User::factory(),
            'filament_id' => Filament::factory(),
        ];
    }
}
