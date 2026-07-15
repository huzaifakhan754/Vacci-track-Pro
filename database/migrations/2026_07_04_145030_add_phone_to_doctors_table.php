<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 🔥 FIXED: Schema::table use kiya hai yahan
        Schema::table('doctors', function (Blueprint $table) {
            $table->string('phone')->nullable()->after('google_meet_link');
        });
    }

    public function down(): void
    {
        Schema::table('doctors', function (Blueprint $table) {
            $table->dropColumn('phone');
        });
    }
};