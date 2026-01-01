<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('user_filament', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained('users')->restrictOnDelete();
            $table->foreignId('filament_id')->constrained('filaments')->restrictOnDelete();

            $table->integer('nozzle_temp_first_layer');
            $table->integer('nozzle_temp_other_layers');

            $table->integer('cool_plate_temp_first_layer');
            $table->integer('cool_plate_temp_other_layers');

            $table->integer('pei_plate_temp_first_layer');
            $table->integer('pei_plate_temp_other_layers');

            $table->decimal('max_volumetric_speed', 4);

            $table->timestamps();
        });
    }
};
