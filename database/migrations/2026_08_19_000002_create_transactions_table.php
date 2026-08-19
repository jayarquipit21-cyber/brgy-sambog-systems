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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_code')->unique()->index(); // e.g. 'TXN-20260819-0001'
            $table->foreignId('appointment_id')->nullable()->constrained('appointments')->nullOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('payer_name');
            $table->string('payer_address')->nullable();
            $table->string('service_type')->default('document')->index(); // 'document', 'rental', 'other'
            $table->string('item_name')->index(); // e.g. 'Barangay Clearance'
            $table->integer('quantity')->default(1);
            $table->decimal('unit_price', 10, 2)->default(0.00);
            $table->decimal('total_amount', 10, 2)->default(0.00)->index();
            $table->decimal('amount_paid', 10, 2)->default(0.00);
            $table->string('payment_status')->default('pending')->index(); // 'paid', 'pending', 'waived', 'refunded'
            $table->string('payment_method')->default('cash')->index(); // 'cash', 'gcash', 'maya', 'bank_transfer', 'free_exemption'
            $table->string('official_receipt_number')->nullable()->index(); // e.g. 'OR-2026-0042'
            $table->foreignId('processed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->text('notes')->nullable();
            $table->timestamp('paid_at')->nullable()->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
