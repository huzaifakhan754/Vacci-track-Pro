<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up(): void
{
    Schema::table('parent_requests', function (Blueprint $table) {
        // hospital_id ke baad doctor_id ka column add karega jo nullable hoga
        $table->unsignedBigInteger('doctor_id')->nullable()->after('hospital_id');
        
        // Foreign key connection (Optional, par acchi practice h)
        $table->foreign('doctor_id')->references('id')->on('doctors')->onDelete('set null');
    });
}

public function down(): void
{
    Schema::table('parent_requests', function (Blueprint $table) {
        $table->dropForeign(['doctor_id']);
        $table->dropColumn('doctor_id');
    });
}
};
