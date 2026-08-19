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
        Schema::create('service_fees', function (Blueprint $table) {
            $table->id();
            $table->string('category')->index(); // 'document' or 'rental'
            $table->string('name')->unique(); // e.g. 'Barangay Clearance'
            $table->string('code')->nullable()->unique(); // e.g. 'BC-001'
            $table->decimal('default_fee', 10, 2)->default(0.00);
            $table->string('fee_unit')->default('per request'); // 'per request', 'per piece', 'per day', 'per hour'
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_free_exemption_eligible')->default(false); // e.g., Indigency / RA 11261
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_fees');
    }
};
