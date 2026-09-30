<?php

namespace Tests\Feature;

use App\Livewire\Admin\ManageAppointments;
use App\Livewire\BookAppointment;
use App\Livewire\MyAppointments;
use App\Models\Appointment;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class DuplicateAndCancelledRequestsTest extends TestCase
{
    use RefreshDatabase;

    public function test_duplicate_document_request_is_prevented(): void
    {
        $resident = User::factory()->create(['role' => 'resident']);
        $this->actingAs($resident);

        // First document request succeeds
        Livewire::test(BookAppointment::class)
            ->set('appointment_category', 'document')
            ->set('document_type', 'Barangay Clearance')
            ->set('purpose_details', 'For passport application')
            ->call('book')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('appointments', [
            'user_id' => $resident->id,
            'status' => 'pending',
        ]);

        // Duplicate request for the same document should fail with validation error on document_type
        Livewire::test(BookAppointment::class)
            ->set('appointment_category', 'document')
            ->set('document_type', 'Barangay Clearance')
            ->set('purpose_details', 'Another application')
            ->call('book')
            ->assertHasErrors(['document_type']);
    }

    public function test_duplicate_custom_document_request_is_prevented(): void
    {
        $resident = User::factory()->create(['role' => 'resident']);
        $this->actingAs($resident);

        // First custom document request succeeds
        Livewire::test(BookAppointment::class)
            ->set('appointment_category', 'document')
            ->set('document_type', 'Other / Custom Barangay Document')
            ->set('purpose_details', 'Certificate of Tree Cutting Clearance')
            ->call('book')
            ->assertHasNoErrors();

        // Duplicate custom document request should fail
        Livewire::test(BookAppointment::class)
            ->set('appointment_category', 'document')
            ->set('document_type', 'Other / Custom Barangay Document')
            ->set('purpose_details', 'Certificate of Tree Cutting Clearance')
            ->call('book')
            ->assertHasErrors(['document_type']);
    }

    public function test_active_approved_document_request_prevents_duplicate(): void
    {
        $resident = User::factory()->create(['role' => 'resident']);
        $this->actingAs($resident);

        // Pre-create an approved appointment
        Appointment::create([
            'user_id' => $resident->id,
            'purpose' => 'Certificate of Residency',
            'status' => 'approved',
            'appointment_date' => now()->addDays(2),
            'appointment_time' => '10:00 AM - 11:00 AM',
        ]);

        // Trying to book the same document while previous is active/approved should fail
        Livewire::test(BookAppointment::class)
            ->set('appointment_category', 'document')
            ->set('document_type', 'Certificate of Residency')
            ->call('book')
            ->assertHasErrors(['document_type']);
    }

    public function test_resident_can_re_request_document_after_cancellation(): void
    {
        $resident = User::factory()->create(['role' => 'resident']);
        $this->actingAs($resident);

        // Pre-create a cancelled appointment
        Appointment::create([
            'user_id' => $resident->id,
            'purpose' => 'Barangay Clearance',
            'status' => 'cancelled',
        ]);

        // Resident should now be allowed to re-request the document
        Livewire::test(BookAppointment::class)
            ->set('appointment_category', 'document')
            ->set('document_type', 'Barangay Clearance')
            ->set('purpose_details', 'Re-applying after fixing details')
            ->call('book')
            ->assertHasNoErrors();

        $this->assertEquals(1, Appointment::where('user_id', $resident->id)->where('status', 'pending')->count());
    }

    public function test_resident_can_delete_cancelled_document_request(): void
    {
        $resident = User::factory()->create(['role' => 'resident']);
        $this->actingAs($resident);

        $appointment = Appointment::create([
            'user_id' => $resident->id,
            'purpose' => 'Barangay Clearance',
            'status' => 'cancelled',
        ]);

        $transaction = Transaction::create([
            'appointment_id' => $appointment->id,
            'user_id' => $resident->id,
            'payer_name' => $resident->name,
            'service_type' => 'document',
            'item_name' => 'Barangay Clearance',
            'quantity' => 1,
            'unit_price' => 50.00,
            'total_amount' => 50.00,
            'payment_status' => 'pending',
        ]);

        // Verify delete button is visible on MyAppointments
        Livewire::test(MyAppointments::class)
            ->assertSee('Delete')
            ->assertSeeHtml('wire:click="deleteCancelled('.$appointment->id.')"');

        // Call deleteCancelled
        Livewire::test(MyAppointments::class)
            ->call('deleteCancelled', $appointment->id);

        $this->assertDatabaseMissing('appointments', ['id' => $appointment->id]);
        $this->assertDatabaseMissing('transactions', ['id' => $transaction->id]);
    }

    public function test_resident_cannot_delete_non_cancelled_request(): void
    {
        $resident = User::factory()->create(['role' => 'resident']);
        $this->actingAs($resident);

        $appointment = Appointment::create([
            'user_id' => $resident->id,
            'purpose' => 'Barangay Clearance',
            'status' => 'pending',
        ]);

        // Attempting to delete a pending request through deleteCancelled should fail with 404
        $this->expectException(\Illuminate\Database\Eloquent\ModelNotFoundException::class);

        Livewire::test(MyAppointments::class)
            ->call('deleteCancelled', $appointment->id);
    }

    public function test_admin_can_delete_cancelled_request(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $resident = User::factory()->create(['role' => 'resident']);
        $this->actingAs($admin);

        $appointment = Appointment::create([
            'user_id' => $resident->id,
            'purpose' => 'Certificate of Indigency',
            'status' => 'cancelled',
        ]);

        Livewire::test(ManageAppointments::class)
            ->call('delete', $appointment->id);

        $this->assertDatabaseMissing('appointments', ['id' => $appointment->id]);
    }
}
