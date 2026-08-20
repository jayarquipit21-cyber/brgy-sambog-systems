<?php

namespace Tests\Unit;

use App\Models\Appointment;
use App\Models\ServiceFee;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TransactionAndServiceFeeTest extends TestCase
{
    use RefreshDatabase;

    public function test_transaction_auto_generates_unique_code_on_creation(): void
    {
        $transaction1 = Transaction::create([
            'payer_name' => 'Juan Dela Cruz',
            'service_type' => 'document',
            'item_name' => 'Barangay Clearance',
            'quantity' => 1,
            'unit_price' => 50.00,
            'total_amount' => 50.00,
            'amount_paid' => 50.00,
            'payment_status' => 'paid',
        ]);

        $transaction2 = Transaction::create([
            'payer_name' => 'Maria Santos',
            'service_type' => 'rental',
            'item_name' => 'Monoblock Chair',
            'quantity' => 10,
            'unit_price' => 5.00,
            'total_amount' => 50.00,
            'amount_paid' => 50.00,
            'payment_status' => 'paid',
        ]);

        $datePrefix = now()->format('Ymd');
        $this->assertEquals("TXN-{$datePrefix}-0001", $transaction1->transaction_code);
        $this->assertEquals("TXN-{$datePrefix}-0002", $transaction2->transaction_code);
    }

    public function test_transaction_preserves_custom_code_if_provided(): void
    {
        $transaction = Transaction::create([
            'transaction_code' => 'CUSTOM-TXN-12345',
            'payer_name' => 'Pedro Penduko',
            'service_type' => 'document',
            'item_name' => 'Certificate of Residency',
            'quantity' => 1,
            'unit_price' => 50.00,
            'total_amount' => 50.00,
            'amount_paid' => 50.00,
            'payment_status' => 'paid',
        ]);

        $this->assertEquals('CUSTOM-TXN-12345', $transaction->transaction_code);
    }

    public function test_transaction_relationships(): void
    {
        $user = User::factory()->create(['role' => 'resident']);
        $admin = User::factory()->create(['role' => 'admin']);
        $appointment = Appointment::create([
            'user_id' => $user->id,
            'purpose' => 'Clearance Request',
            'status' => 'approved',
        ]);

        $transaction = Transaction::create([
            'appointment_id' => $appointment->id,
            'user_id' => $user->id,
            'processed_by' => $admin->id,
            'payer_name' => $user->name,
            'service_type' => 'document',
            'item_name' => 'Barangay Clearance',
            'quantity' => 1,
            'unit_price' => 50.00,
            'total_amount' => 50.00,
            'amount_paid' => 50.00,
            'payment_status' => 'paid',
        ]);

        $this->assertEquals($user->id, $transaction->user->id);
        $this->assertEquals($appointment->id, $transaction->appointment->id);
        $this->assertEquals($admin->id, $transaction->processor->id);
    }

    public function test_transaction_query_scopes(): void
    {
        Transaction::create([
            'payer_name' => 'Paid Document',
            'service_type' => 'document',
            'item_name' => 'Barangay Clearance',
            'total_amount' => 50.00,
            'amount_paid' => 50.00,
            'payment_status' => 'paid',
        ]);

        Transaction::create([
            'payer_name' => 'Pending Rental',
            'service_type' => 'rental',
            'item_name' => 'Gym Basketball Court',
            'total_amount' => 200.00,
            'amount_paid' => 0.00,
            'payment_status' => 'pending',
        ]);

        $this->assertCount(1, Transaction::paid()->get());
        $this->assertEquals('Paid Document', Transaction::paid()->first()->payer_name);

        $this->assertCount(1, Transaction::pending()->get());
        $this->assertEquals('Pending Rental', Transaction::pending()->first()->payer_name);

        $this->assertCount(1, Transaction::documents()->get());
        $this->assertEquals('Paid Document', Transaction::documents()->first()->payer_name);

        $this->assertCount(1, Transaction::rentals()->get());
        $this->assertEquals('Pending Rental', Transaction::rentals()->first()->payer_name);
    }

    public function test_transaction_mark_as_paid_and_waived_methods(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $transaction = Transaction::create([
            'payer_name' => 'Applicant Name',
            'service_type' => 'document',
            'item_name' => 'Clearance',
            'total_amount' => 50.00,
            'amount_paid' => 0.00,
            'payment_status' => 'pending',
        ]);

        $transaction->markAsPaid(50.00, 'gcash', 'OR-2026-9999', $admin->id, 'GCash payment confirmed');

        $transaction->refresh();
        $this->assertEquals('paid', $transaction->payment_status);
        $this->assertEquals(50.00, $transaction->amount_paid);
        $this->assertEquals('gcash', $transaction->payment_method);
        $this->assertEquals('OR-2026-9999', $transaction->official_receipt_number);
        $this->assertEquals($admin->id, $transaction->processed_by);
        $this->assertEquals('GCash payment confirmed', $transaction->notes);
        $this->assertNotNull($transaction->paid_at);

        // Test markAsWaived
        $transaction2 = Transaction::create([
            'payer_name' => 'Indigent Resident',
            'service_type' => 'document',
            'item_name' => 'Indigency Certificate',
            'total_amount' => 50.00,
            'amount_paid' => 0.00,
            'payment_status' => 'pending',
        ]);

        $transaction2->markAsWaived($admin->id, 'Indigent fee waiver');
        $transaction2->refresh();

        $this->assertEquals('waived', $transaction2->payment_status);
        $this->assertEquals(0.00, $transaction2->amount_paid);
        $this->assertEquals('free_exemption', $transaction2->payment_method);
        $this->assertEquals('Indigent fee waiver', $transaction2->notes);
    }

    public function test_service_fee_helpers(): void
    {
        ServiceFee::create([
            'category' => 'document',
            'name' => 'Barangay Clearance',
            'code' => 'DOC-BC',
            'default_fee' => 50.00,
            'fee_unit' => 'per document',
            'is_active' => true,
        ]);

        ServiceFee::create([
            'category' => 'rental',
            'name' => 'Court Rental',
            'code' => 'RNT-CRT',
            'default_fee' => 200.00,
            'fee_unit' => 'per hour',
            'is_active' => true,
        ]);

        ServiceFee::create([
            'category' => 'document',
            'name' => 'Disabled Service',
            'code' => 'DOC-DIS',
            'default_fee' => 100.00,
            'fee_unit' => 'per item',
            'is_active' => false,
        ]);

        $docFees = ServiceFee::getFeesForCategory('document');
        $this->assertCount(1, $docFees);
        $this->assertEquals('Barangay Clearance', $docFees->first()->name);

        $rentalFees = ServiceFee::getFeesForCategory('rental');
        $this->assertCount(1, $rentalFees);
        $this->assertEquals('Court Rental', $rentalFees->first()->name);

        $this->assertEquals(50.00, ServiceFee::getFeeByName('Barangay Clearance'));
        $this->assertEquals(0.00, ServiceFee::getFeeByName('Non Existent Fee'));
    }
}
