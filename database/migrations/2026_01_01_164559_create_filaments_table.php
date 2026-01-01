<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('filaments', function (Blueprint $table): void {
            $table->id();

            $table->foreignId('vendor_id')->constrained('vendors')->restrictOnDelete();
            $table->foreignId('filament_type_id')->constrained('filament_types')->restrictOnDelete();
            $table->foreignId('color_id')->constrained('colors')->restrictOnDelete();

            $table->string('slug')->unique();
            $table->string('title');

            $table->timestamps();
            $table->softDeletes();
        });
    }
};
