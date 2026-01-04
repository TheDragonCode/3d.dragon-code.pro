<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('maps', function (Blueprint $table) {
            $table->id();

            $table->foreignId('vendor_id')->constrained('vendors')->cascadeOnDelete();
            $table->foreignId('parent_id')->nullable()->constrained('maps')->cascadeOnDelete();

            $table->string('type');

            $table->string('profile');

            $table->string('key');
            $table->string('path');

            $table->timestamps();

            $table->index(['type', 'key']);
            $table->unique(['vendor_id', 'type', 'key']);
        });
    }
};
