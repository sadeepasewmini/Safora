<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('safe_places', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('type', ['police', 'hospital', 'fire_station', 'shelter', 'pharmacy']);
            $table->string('address');
            $table->string('area_name');
            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 10, 7);
            $table->string('phone')->nullable();
            $table->boolean('is_24_7')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('safe_places');
    }
};
