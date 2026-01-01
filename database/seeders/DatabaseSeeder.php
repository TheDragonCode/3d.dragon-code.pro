<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->count(3)->createMany([
            'password' => 'password',

            'email_verified_at' => now(),
        ]);
    }
}
