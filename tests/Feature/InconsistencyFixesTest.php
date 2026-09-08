<?php

namespace Tests\Feature;

use App\Livewire\Admin\ManageAppointments;
use App\Livewire\Admin\ManageBlotters;
use App\Livewire\AnnouncementsManager;
use App\Livewire\BookAppointment;
use App\Models\Announcement;
use App\Models\Appointment;
use App\Models\Household;
use App\Models\Resident;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class InconsistencyFixesTest extends TestCase
{
    use RefreshDatabase;

    public function test_release_time_validation_rejects_past_time_on_same_day(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $resident = User::factory()->create(['role' => 'resident']);
        $this->actingAs($admin);

        // Freeze time at 11:30 AM today
        Carbon::setTestNow(Carbon::today()->setTime(11, 30, 0));

        $appointment = Appointment::create([
            'user_id' => $resident->id,
            'purpose' => 'Barangay Clearance',
            'status' => 'pending',
            'appointment_date' => Carbon::today(),
        ]);

        // Attempt to approve with slot starting at 09:00 AM (which is before 11:30 AM today)
        Livewire::test(ManageAppointments::class)
            ->call('startApprove', $appointment->id)
            ->set('redemptionDate', Carbon::today()->toDateString())
            ->set('redemptionTime', '09:00 AM - 10:00 AM')
            ->call('confirmApprove')
            ->assertHasErrors(['redemptionTime']);

        // Refresh appointment: should still be pending
        $appointment->refresh();
        $this->assertEquals('pending', $appointment->status);

        // Slot starting at 01:00 PM (13:00) is after 11:30 AM today, so it should succeed
        Livewire::test(ManageAppointments::class)
            ->call('startApprove', $appointment->id)
            ->set('redemptionDate', Carbon::today()->toDateString())
            ->set('redemptionTime', '01:00 PM - 02:00 PM')
            ->call('confirmApprove')
            ->assertHasNoErrors();

        $appointment->refresh();
        $this->assertEquals('approved', $appointment->status);

        Carbon::setTestNow(); // Clear frozen time
    }

    public function test_announcement_creation_without_tags_and_optional_event_end_date(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);

        $eventDate = Carbon::tomorrow()->setTime(8, 0)->format('Y-m-d\TH:i');

        // Create announcement with event toggle enabled, but NO end date
        Livewire::test(AnnouncementsManager::class)
            ->set('title', 'Community Clean-Up Drive')
            ->set('body', 'All residents are invited to join the coastal cleanup.')
            ->set('is_event', true)
            ->set('event_date', $eventDate)
            ->set('event_end_date', null)
            ->set('event_location', 'Sambog Barangay Plaza')
            ->call('createAnnouncement')
            ->assertHasNoErrors();

        $announcement = Announcement::where('title', 'Community Clean-Up Drive')->first();
        $this->assertNotNull($announcement);
        $this->assertEquals('event', $announcement->type);
        $this->assertNotNull($announcement->event_date);
        $this->assertNull($announcement->event_end_date);
        $this->assertEquals('Sambog Barangay Plaza', $announcement->event_location);

        // Non-event announcement does not require event dates
        Livewire::test(AnnouncementsManager::class)
            ->set('title', 'Water Interruption Notice')
            ->set('body', 'Maintenance on main water pipeline on Friday.')
            ->set('is_event', false)
            ->set('event_date', null)
            ->set('event_end_date', null)
            ->call('createAnnouncement')
            ->assertHasNoErrors();

        $generalAnn = Announcement::where('title', 'Water Interruption Notice')->first();
        $this->assertNotNull($generalAnn);
        $this->assertEquals('general', $generalAnn->type);
        $this->assertNull($generalAnn->event_date);
    }

    public function test_blotter_complainant_suggests_names_from_rbi(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);

        $household = Household::create([
            'household_no' => 'HH-2026-001',
            'purok_no' => 'Purok 3',
            'address' => 'Upper Sambog Highway',
        ]);

        $resident = Resident::create([
            'household_id' => $household->id,
            'first_name' => 'Crisostomo',
            'last_name' => 'Ibarra',
            'relationship_to_head' => 'Head',
            'birthdate' => '1990-05-15',
            'sex' => 'Male',
            'civil_status' => 'Single',
        ]);

        // Test typing in complainant name triggers suggestions
        $component = Livewire::test(ManageBlotters::class)
            ->call('create')
            ->set('complainant_name', 'Crisos')
            ->assertSet('showComplainantSuggestions', true);

        $suggestions = $component->get('complainantSuggestions');
        $this->assertCount(1, $suggestions);
        $this->assertEquals('Crisostomo Ibarra', $suggestions->first()->full_name);

        // Selecting the complainant populates name and location
        $component->call('selectComplainant', $resident->id)
            ->assertSet('complainant_name', 'Crisostomo Ibarra')
            ->assertSet('incident_location', 'Upper Sambog Highway')
            ->assertSet('showComplainantSuggestions', false);
    }

    public function test_rental_utility_booking_with_quantity_calculates_total_price(): void
    {
        $this->seed(\Database\Seeders\ServiceFeeSeeder::class);

        $resident = User::factory()->create(['role' => 'resident']);
        $this->actingAs($resident);

        $rentalDate = Carbon::tomorrow()->toDateString();
        $quantity = 25; // 25 chairs

        Livewire::test(BookAppointment::class)
            ->set('appointment_category', 'rental')
            ->set('document_type', 'Plastic Monoblock Chairs Rental')
            ->set('rental_quantity', $quantity)
            ->set('rental_date', $rentalDate)
            ->set('purpose_details', 'Barangay assembly meeting seats')
            ->call('book')
            ->assertHasNoErrors();

        $appointment = Appointment::where('user_id', $resident->id)->first();
        $this->assertNotNull($appointment);
        $this->assertStringContainsString('(Qty: 25)', $appointment->purpose);

        // Verify transaction total amount = 25 chairs * ₱5.00/chair = ₱125.00
        $transaction = Transaction::where('appointment_id', $appointment->id)->first();
        $this->assertNotNull($transaction);
        $this->assertEquals(25, $transaction->quantity);
        $this->assertEquals(125.00, (float)$transaction->total_amount);

        // Verify duplicate pending request prevention
        Livewire::test(BookAppointment::class)
            ->set('appointment_category', 'rental')
            ->set('document_type', 'Plastic Monoblock Chairs Rental')
            ->set('rental_quantity', 10)
            ->call('book')
            ->assertHasErrors(['document_type']);
    }

    public function test_admin_receives_warning_when_completing_unpaid_document_claim(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $resident = User::factory()->create(['role' => 'resident']);
        $this->actingAs($admin);

        $appointment = Appointment::create([
            'user_id' => $resident->id,
            'purpose' => 'Barangay Clearance',
            'status' => 'approved',
            'appointment_date' => Carbon::today(),
            'appointment_time' => '09:00 AM - 10:00 AM',
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
            'amount_paid' => 0.00,
            'payment_status' => 'pending',
            'payment_method' => 'cash',
        ]);

        // Attempting to complete the unpaid document throws a warning and opens warning modal
        $component = Livewire::test(ManageAppointments::class)
            ->call('complete', $appointment->id)
            ->assertSet('showUnpaidWarningModal', true)
            ->assertSet('pendingCompleteId', $appointment->id);

        // Appointment status should still be approved (NOT completed)
        $appointment->refresh();
        $this->assertEquals('approved', $appointment->status);

        // Admin confirms completion via modal action
        $component->call('confirmComplete')
            ->assertSet('showUnpaidWarningModal', false);

        $appointment->refresh();
        $this->assertEquals('completed', $appointment->status);
    }
}

