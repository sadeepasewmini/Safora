<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('incident_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->enum('type', ['crime', 'wildlife', 'disaster', 'road']);
            $table->string('icon')->default('bi-exclamation-triangle');
            $table->enum('risk_level', ['low', 'medium', 'high', 'critical'])->default('medium');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('incident_categories');
    }
};
