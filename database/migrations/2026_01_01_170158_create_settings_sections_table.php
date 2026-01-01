<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('settings_sections', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('parent_id')->nullable();

            $table->string('title');

            $table->timestamps();
            $table->softDeletes();
        });
    }
};
