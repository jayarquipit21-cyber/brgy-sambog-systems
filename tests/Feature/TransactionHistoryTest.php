<?php

namespace Tests\Feature;

use App\Livewire\TransactionHistory;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class TransactionHistoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_sees_all_document_transactions(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $residentA = User::factory()->create(['role' => 'resident']);
        $residentB = User::factory()->create(['role' => 'resident']);

        Transaction::create([
            'user_id' => $residentA->id,
            'payer_name' => 'Resident A',
            'service_type' => 'document',
            'item_name' => 'Barangay Clearance',
            'quantity' => 1,
            'unit_price' => 50.00,
            'total_amount' => 50.00,
            'amount_paid' => 50.00,
            'payment_status' => 'paid',
            'payment_method' => 'cash',
            'official_receipt_number' => 'OR-DOC-001',
            'paid_at' => now(),
        ]);

        Transaction::create([
            'user_id' => $residentB->id,
            'payer_name' => 'Resident B',
            'service_type' => 'rental',
            'item_name' => 'Basketball Court Rental',
            'quantity' => 1,
            'unit_price' => 200.00,
            'total_amount' => 200.00,
            'amount_paid' => 200.00,
            'payment_status' => 'paid',
            'payment_method' => 'cash',
            'official_receipt_number' => 'OR-RNT-001',
            'paid_at' => now(),
        ]);

        $this->actingAs($admin);

        Livewire::test(TransactionHistory::class, ['serviceType' => 'document'])
            ->assertSee('Barangay Clearance')
            ->assertSee('Resident A')
            ->assertSee('OR-DOC-001')
            ->assertDontSee('Basketball Court Rental');
    }

    public function test_resident_only_sees_their_own_transactions(): void
    {
        $residentA = User::factory()->create(['role' => 'resident']);
        $residentB = User::factory()->create(['role' => 'resident']);

        Transaction::create([
            'user_id' => $residentA->id,
            'payer_name' => 'Resident A',
            'service_type' => 'document',
            'item_name' => 'Barangay Clearance',
            'quantity' => 1,
            'unit_price' => 50.00,
            'total_amount' => 50.00,
            'amount_paid' => 50.00,
            'payment_status' => 'paid',
            'payment_method' => 'cash',
            'official_receipt_number' => 'OR-DOC-001',
            'paid_at' => now(),
        ]);

        Transaction::create([
            'user_id' => $residentB->id,
            'payer_name' => 'Resident B',
            'service_type' => 'document',
            'item_name' => 'Certificate of Residency',
            'quantity' => 1,
            'unit_price' => 50.00,
            'total_amount' => 50.00,
            'amount_paid' => 50.00,
            'payment_status' => 'paid',
            'payment_method' => 'cash',
            'official_receipt_number' => 'OR-DOC-002',
            'paid_at' => now(),
        ]);

        $this->actingAs($residentA);

        Livewire::test(TransactionHistory::class, ['serviceType' => 'document'])
            ->assertSee('Barangay Clearance')
            ->assertSee('OR-DOC-001')
            ->assertDontSee('Certificate of Residency')
            ->assertDontSee('OR-DOC-002');
    }

    public function test_admin_and_resident_pages_render_transaction_history(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);

        $this->get(route('admin.services.documents'))
            ->assertOk()
            ->assertSeeLivewire('transaction-history');

        $this->get(route('admin.services.rentals'))
            ->assertOk()
            ->assertSeeLivewire('transaction-history');

        $resident = User::factory()->create(['role' => 'resident']);
        $this->actingAs($resident);

        $this->get(route('services.documents'))
            ->assertOk()
            ->assertSeeLivewire('transaction-history');

        $this->get(route('services.rentals'))
            ->assertOk()
            ->assertSeeLivewire('transaction-history');
    }
}
