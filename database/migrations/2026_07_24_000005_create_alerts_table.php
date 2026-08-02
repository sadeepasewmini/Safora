<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('alerts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('message');
            $table->enum('category', ['wildlife', 'crime', 'weather', 'road_closure', 'general'])->default('general');
            $table->string('area_name')->default('Island-wide');
            $table->enum('severity', ['info', 'warning', 'danger', 'critical'])->default('warning');
            $table->foreignId('published_by')->nullable()->constrained('users')->onDelete('set null');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alerts');
    }
};
