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
        Schema::table('residents', function (Blueprint $table) {
            $table->index('household_id');
            $table->index('user_id');
            $table->index('sex');
            $table->index('relationship_to_head');
            $table->index('fully_vaccinated');
        });

        Schema::table('appointments', function (Blueprint $table) {
            $table->index('created_at');
        });

        Schema::table('transactions', function (Blueprint $table) {
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('residents', function (Blueprint $table) {
            $table->dropIndex(['household_id']);
            $table->dropIndex(['user_id']);
            $table->dropIndex(['sex']);
            $table->dropIndex(['relationship_to_head']);
            $table->dropIndex(['fully_vaccinated']);
        });

        Schema::table('appointments', function (Blueprint $table) {
            $table->dropIndex(['created_at']);
        });

        Schema::table('transactions', function (Blueprint $table) {
            $table->dropIndex(['created_at']);
        });
    }
};
