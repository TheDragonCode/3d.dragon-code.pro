<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('printers', function (Blueprint $table) {
            $table->id();

            $table->foreignId('vendor_id')->constrained('vendors')->restrictOnDelete();

            $table->string('slug')->unique();
            $table->string('title');

            $table->timestamps();
            $table->softDeletes();
        });
    }
};
