<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('user_filament', function (Blueprint $table): void {
            $table->id();
            
            $table->foreignId('user_id')->constrained('users')->restrictOnDelete();
            $table->foreignId('machine_id')->constrained('machines')->restrictOnDelete();
            $table->foreignId('filament_id')->constrained('filaments')->restrictOnDelete();

            $table->decimal('pressure_advance', 6, 4);

            $table->decimal('filament_flow_ratio', 5, 3);
            $table->decimal('filament_max_volumetric_speed', 4);

            $table->integer('nozzle_temperature');
            $table->integer('nozzle_temperature_initial_layer');

            $table->timestamps();
        });
    }
};
