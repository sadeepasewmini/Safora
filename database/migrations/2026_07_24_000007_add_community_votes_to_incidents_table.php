<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('incidents', function (Blueprint $table) {
            $table->integer('upvotes_count')->default(1)->after('views_count');
            $table->integer('downvotes_count')->default(0)->after('upvotes_count');
            $table->string('sms_gateway_status')->nullable()->after('downvotes_count');
        });
    }

    public function down(): void
    {
        Schema::table('incidents', function (Blueprint $table) {
            $table->dropColumn(['upvotes_count', 'downvotes_count', 'sms_gateway_status']);
        });
    }
};
