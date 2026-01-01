<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\FilamentType;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class FilamentTypeFactory extends Factory
{
    protected $model = FilamentType::class;

    public function definition(): array
    {
        return [
            'title'      => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
