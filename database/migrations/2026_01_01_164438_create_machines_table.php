<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('machines', function (Blueprint $table): void {
            $table->id();

            $table->foreignId('vendor_id')->constrained('vendors')->restrictOnDelete();

            $table->string('slug');
            $table->string('title');

            $table->string('cover')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->unique(['vendor_id', 'slug']);
        });
    }
};
