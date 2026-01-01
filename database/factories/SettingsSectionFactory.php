<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\SettingsSection;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class SettingsSectionFactory extends Factory
{
    protected $model = SettingsSection::class;

    public function definition(): array
    {
        return [
            'key' => $this->faker->unique()->word(),

            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
