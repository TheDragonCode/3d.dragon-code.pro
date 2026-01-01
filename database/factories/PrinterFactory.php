<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Printer;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class PrinterFactory extends Factory
{
    protected $model = Printer::class;

    public function definition(): array
    {
        return [
            'slug'  => $this->faker->slug(),
            'title' => $this->faker->word(),

            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
