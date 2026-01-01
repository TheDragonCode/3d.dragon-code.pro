<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\LayerHeight;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class LayerHeightFactory extends Factory
{
    protected $model = LayerHeight::class;

    public function definition(): array
    {
        return [
            'slug'       => $this->faker->slug(),
            'title'      => $this->faker->randomFloat(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
