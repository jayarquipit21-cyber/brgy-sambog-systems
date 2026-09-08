<?php

namespace Tests\Feature;

use App\Livewire\Admin\ManageAppointments;
use App\Livewire\Admin\ManageBlotters;
use App\Livewire\Admin\ManageRbi;
use App\Livewire\Admin\RbiDataTable;
use App\Livewire\Admin\SalesReport;
use App\Livewire\AnnouncementsManager;
use App\Livewire\Health\EditHealthRecord;
use App\Livewire\Health\HealthDashboard;
use App\Livewire\MyAppointments;
use App\Livewire\TransactionHistory;
use App\Models\Announcement;
use App\Models\Appointment;
use App\Models\Blotter;
use App\Models\Household;
use App\Models\Resident;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class SearchQueryImprovementsTest extends TestCase
{
    use RefreshDatabase;

    public function test_manage_appointments_searches_purpose_and_transaction_details(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $resident = User::factory()->create(['name' => 'Alice Resident', 'role' => 'resident']);
        $this->actingAs($admin);

        $docApt = Appointment::create([
            'user_id' => $resident->id,
            'purpose' => 'Certificate of Indigency',
            'status' => 'pending',
            'appointment_date' => Carbon::tomorrow(),
        ]);

        $rentalApt = Appointment::create([
            'user_id' => $resident->id,
            'purpose' => '[Rental Service] Sound System Rental',
            'status' => 'approved',
            'appointment_date' => Carbon::tomorrow(),
        ]);

        Transaction::create([
            'transaction_code' => 'TXN-DOC-9988',
            'appointment_id' => $docApt->id,
            'user_id' => $resident->id,
            'payer_name' => 'Alice Resident',
            'service_type' => 'document',
            'item_name' => 'Certificate of Indigency',
            'quantity' => 1,
            'total_amount' => 50,
            'amount_paid' => 50,
            'payment_status' => 'paid',
            'official_receipt_number' => 'OR-998877',
        ]);

        // Search by purpose "Indigency"
        Livewire::test(ManageAppointments::class)
            ->set('search', 'Indigency')
            ->assertSee('Certificate of Indigency')
            ->assertDontSee('Sound System');

        // Search by transaction OR number "OR-998877"
        Livewire::test(ManageAppointments::class)
            ->set('search', 'OR-998877')
            ->assertSee('Certificate of Indigency');

        // Filter by typeFilter = 'rental'
        Livewire::test(ManageAppointments::class)
            ->set('typeFilter', 'rental')
            ->assertSee('Sound System')
            ->assertDontSee('Certificate of Indigency');
    }

    public function test_manage_blotters_searches_incident_type_location_and_narrative(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);

        Blotter::create([
            'complainant_name' => 'Juan Dela Cruz',
            'respondent_name' => 'Pedro Penduko',
            'incident_type' => 'Boundary Dispute',
            'incident_date' => Carbon::yesterday(),
            'incident_location' => 'Purok 4 Riverside',
            'narrative' => 'Fence encroaching neighbor lot during construction',
            'status' => 'Pending',
        ]);

        Blotter::create([
            'complainant_name' => 'Maria Santos',
            'respondent_name' => 'Jose Rizal',
            'incident_type' => 'Noise Barrage',
            'incident_date' => Carbon::yesterday(),
            'incident_location' => 'Purok 2 Highway',
            'narrative' => 'Loud videoke past curfew hours',
            'status' => 'Settled',
        ]);

        // Search by incident_type
        Livewire::test(ManageBlotters::class)
            ->set('search', 'Dispute')
            ->assertSee('Juan Dela Cruz')
            ->assertDontSee('Maria Santos');

        // Search by incident_location
        Livewire::test(ManageBlotters::class)
            ->set('search', 'Riverside')
            ->assertSee('Juan Dela Cruz')
            ->assertDontSee('Maria Santos');

        // Search by narrative
        Livewire::test(ManageBlotters::class)
            ->set('search', 'videoke')
            ->assertSee('Maria Santos')
            ->assertDontSee('Juan Dela Cruz');
    }

    public function test_manage_rbi_and_rbi_data_table_search_occupation_and_phone(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);

        $household = Household::create([
            'household_no' => 'HH-001',
            'purok_no' => 3,
            'address' => '123 Mango Street Sambog',
        ]);

        Resident::create([
            'household_id' => $household->id,
            'first_name' => 'Roberto',
            'last_name' => 'Gomez',
            'middle_name' => 'Santos',
            'relationship_to_head' => 'Household Head',
            'registration_status' => 'approved',
            'occupation' => 'Master Electrician',
            'mobile_number' => '09171234567',
            'philhealth_id' => 'PH-987654',
        ]);

        // ManageRbi search by full name
        Livewire::test(ManageRbi::class)
            ->set('search', 'Roberto Gomez')
            ->assertSee('Roberto')
            ->assertSee('Gomez');

        // ManageRbi search by reverse full name
        Livewire::test(ManageRbi::class)
            ->set('search', 'Gomez, Roberto')
            ->assertSee('Roberto')
            ->assertSee('Gomez');

        // ManageRbi search by occupation
        Livewire::test(ManageRbi::class)
            ->set('search', 'Electrician')
            ->assertSee('Roberto')
            ->assertSee('Gomez');

        // ManageRbi search by phone
        Livewire::test(ManageRbi::class)
            ->set('search', '09171234567')
            ->assertSee('Roberto');

        // ManageRbi search by PhilHealth
        Livewire::test(ManageRbi::class)
            ->set('search', 'PH-987654')
            ->assertSee('Roberto');

        // RbiDataTable search by full name
        Livewire::test(RbiDataTable::class)
            ->set('search', 'Roberto Gomez')
            ->assertSee('Roberto');

        // RbiDataTable search by address
        Livewire::test(RbiDataTable::class)
            ->set('search', 'Mango Street')
            ->assertSee('Roberto');

        // RbiDataTable search by phone
        Livewire::test(RbiDataTable::class)
            ->set('search', '09171234567')
            ->assertSee('Roberto');
    }

    public function test_health_components_search_vulnerable_sector_and_blood_type(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);

        $household = Household::create([
            'household_no' => 'HH-002',
            'purok_no' => 1,
            'address' => 'Barangay Sambog',
        ]);

        Resident::create([
            'household_id' => $household->id,
            'first_name' => 'Clara',
            'last_name' => 'Reyes',
            'middle_name' => 'B',
            'relationship_to_head' => 'Head',
            'registration_status' => 'approved',
            'blood_type' => 'AB+',
            'health_condition' => 'Hypertension',
            'vulnerable_sector' => 'PWD / Person with Disability',
            'nutritional_classification' => 'Normal',
            'philhealth_id' => 'PH-554433',
        ]);

        Resident::create([
            'household_id' => $household->id,
            'first_name' => 'Benito',
            'last_name' => 'Cruz',
            'middle_name' => 'C',
            'relationship_to_head' => 'Head',
            'registration_status' => 'approved',
            'blood_type' => 'O+',
            'health_condition' => null,
            'vulnerable_sector' => 'Senior Citizen',
            'nutritional_classification' => 'Normal',
        ]);

        // HealthDashboard search by full name
        Livewire::test(HealthDashboard::class)
            ->set('search', 'Clara Reyes')
            ->assertSee('Clara')
            ->assertSee('Reyes')
            ->assertDontSee('Benito');

        // HealthDashboard search by PhilHealth ID
        Livewire::test(HealthDashboard::class)
            ->set('search', 'PH-554433')
            ->assertSee('Clara')
            ->assertDontSee('Benito');

        // HealthDashboard search by sector
        Livewire::test(HealthDashboard::class)
            ->set('search', 'Disability')
            ->assertSee('Clara')
            ->assertSee('Reyes');

        // HealthDashboard filter by has_condition
        Livewire::test(HealthDashboard::class)
            ->set('healthFilter', 'has_condition')
            ->assertSee('Clara')
            ->assertDontSee('Benito');

        // HealthDashboard filter by none
        Livewire::test(HealthDashboard::class)
            ->set('healthFilter', 'none')
            ->assertSee('Benito')
            ->assertDontSee('Clara');

        // EditHealthRecord search by blood type
        Livewire::test(EditHealthRecord::class)
            ->set('search', 'AB+')
            ->assertSee('Clara')
            ->assertSee('Reyes');
    }

    public function test_sales_report_searches_address_notes_and_filters_payment_method(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);

        Transaction::create([
            'transaction_code' => 'TXN-SR-101',
            'payer_name' => 'Dante Alighieri',
            'payer_address' => 'Zone 5 Acacia Lane',
            'service_type' => 'document',
            'item_name' => 'Barangay Clearance',
            'quantity' => 1,
            'total_amount' => 100,
            'amount_paid' => 100,
            'payment_status' => 'paid',
            'payment_method' => 'gcash',
            'official_receipt_number' => 'OR-7711',
            'notes' => 'Special priority release',
            'paid_at' => now(),
        ]);

        Transaction::create([
            'transaction_code' => 'TXN-SR-102',
            'payer_name' => 'Beatrice Portinari',
            'payer_address' => 'Zone 2 Palm Avenue',
            'service_type' => 'rental',
            'item_name' => 'Chairs Rental',
            'quantity' => 10,
            'total_amount' => 200,
            'amount_paid' => 200,
            'payment_status' => 'paid',
            'payment_method' => 'cash',
            'official_receipt_number' => 'OR-7722',
            'paid_at' => now(),
        ]);

        // Search by address
        Livewire::test(SalesReport::class)
            ->set('search', 'Acacia Lane')
            ->assertSee('Dante Alighieri')
            ->assertDontSee('Beatrice Portinari');

        // Search by notes
        Livewire::test(SalesReport::class)
            ->set('search', 'priority')
            ->assertSee('Dante Alighieri')
            ->assertDontSee('Beatrice Portinari');

        // Filter by payment method
        Livewire::test(SalesReport::class)
            ->set('paymentMethodFilter', 'gcash')
            ->assertSee('Dante Alighieri')
            ->assertDontSee('Beatrice Portinari');
    }

    public function test_my_appointments_searches_and_filters_resident_bookings(): void
    {
        $resident = User::factory()->create(['role' => 'resident']);
        $this->actingAs($resident);

        Appointment::create([
            'user_id' => $resident->id,
            'purpose' => 'Barangay Clearance for Employment',
            'status' => 'completed',
            'appointment_date' => Carbon::yesterday(),
        ]);

        Appointment::create([
            'user_id' => $resident->id,
            'purpose' => 'Residency Certificate for Scholarship',
            'status' => 'pending',
            'appointment_date' => Carbon::tomorrow(),
        ]);

        // Search by purpose keyword
        Livewire::test(MyAppointments::class)
            ->set('search', 'Employment')
            ->assertSee('Barangay Clearance for Employment')
            ->assertDontSee('Residency Certificate');

        // Filter by status
        Livewire::test(MyAppointments::class)
            ->set('statusFilter', 'pending')
            ->assertSee('Residency Certificate for Scholarship')
            ->assertDontSee('Barangay Clearance for Employment');
    }

    public function test_announcements_manager_searches_and_filters(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);

        Announcement::create([
            'user_id' => $admin->id,
            'title' => 'Annual Barangay Sports Fest',
            'body' => 'Basketball and volleyball tournament kicks off this weekend',
            'type' => 'event',
            'event_date' => Carbon::tomorrow(),
            'event_location' => 'Barangay Sambog Covered Court',
            'published_at' => now(),
        ]);

        Announcement::create([
            'user_id' => $admin->id,
            'title' => 'Water Interruption Advisory',
            'body' => 'Scheduled maintenance by local water district on Tuesday',
            'type' => 'general',
            'published_at' => now(),
        ]);

        // Search by location
        Livewire::test(AnnouncementsManager::class)
            ->set('search', 'Covered Court')
            ->assertSee('Sports Fest')
            ->assertDontSee('Water Interruption');

        // Filter by event
        Livewire::test(AnnouncementsManager::class)
            ->set('filterType', 'event')
            ->assertSee('Sports Fest')
            ->assertDontSee('Water Interruption');

        // Filter by general announcement
        Livewire::test(AnnouncementsManager::class)
            ->set('filterType', 'general')
            ->assertSee('Water Interruption')
            ->assertDontSee('Sports Fest');
    }

    public function test_category_toggle_buttons_are_removed_from_user_booking_view(): void
    {
        $resident = User::factory()->create(['role' => 'resident']);
        $this->actingAs($resident);

        // In document window, Official Documents and Rental & Facilities buttons are removed
        Livewire::test(\App\Livewire\BookAppointment::class, ['appointment_category' => 'document'])
            ->assertDontSee('Official Documents')
            ->assertDontSee('Rental & Facilities')
            ->assertSee('Barangay Official Document Request');

        // In rental window, category switcher buttons are removed and rental form is shown
        Livewire::test(\App\Livewire\BookAppointment::class, ['appointment_category' => 'rental'])
            ->assertDontSee('Official Documents')
            ->assertSee('Barangay Rental', false);
    }
}
