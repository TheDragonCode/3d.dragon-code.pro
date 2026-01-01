<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('settings_section_translations', function (Blueprint $table): void {
            $table->id();

            $table->foreignId('item_id')
                ->constrained('settings_sections')
                ->cascadeOnDelete();

            $table->string('locale');

            $table->string('title')->nullable();

            $table->unique(['item_id', 'locale']);
        });
    }
};
