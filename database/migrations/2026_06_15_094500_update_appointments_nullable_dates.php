<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->date('appointment_date')->nullable()->change();
            $table->string('appointment_time')->nullable()->change();
            $table->string('status')->default('approved-pending')->change();
        });

        // Update existing records
        DB::table('appointments')
            ->where('status', 'pending')
            ->update(['status' => 'approved-pending']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('appointments')
            ->where('status', 'approved-pending')
            ->update(['status' => 'pending']);

        Schema::table('appointments', function (Blueprint $table) {
            $table->date('appointment_date')->nullable(false)->change();
            $table->string('appointment_time')->nullable(false)->change();
            $table->string('status')->default('pending')->change();
        });
    }
};
