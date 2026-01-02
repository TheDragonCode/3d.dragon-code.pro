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

            $table->string('external_id');

            $table->string('title');

            $table->timestamps();
            $table->softDeletes();

            $table->unique(['vendor_id', 'external_id']);
        });
    }
};
