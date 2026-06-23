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
        Schema::create('blotters', function (Blueprint $table) {
            $table->id();
            $table->string('complainant_name');
            $table->string('respondent_name');
            $table->string('incident_type');
            $table->date('incident_date')->nullable();
            $table->string('incident_location')->nullable();
            $table->text('narrative')->nullable();
            $table->string('status')->default('Pending'); // Pending, Scheduled, Settled, Unsettled, Forwarded
            $table->dateTime('hearing_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blotters');
    }
};
