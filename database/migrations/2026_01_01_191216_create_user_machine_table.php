<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('user_machine', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained('users')->restrictOnDelete();
            $table->foreignId('machine_id')->constrained('machines')->restrictOnDelete();
            $table->foreignId('nozzle_id')->constrained('nozzles')->restrictOnDelete();

            $table->integer('filament_load_time');
            $table->integer('filament_unload_time');
            $table->integer('tool_change_time');

            $table->boolean('can_change_filament');

            $table->timestamps();
        });
    }
};
