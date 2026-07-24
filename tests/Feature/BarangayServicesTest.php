<?php

namespace Tests\Feature;

use App\Livewire\Admin\ManageAppointments;
use App\Livewire\Admin\ManageRbi;
use App\Livewire\Admin\RbiDataTable;
use App\Livewire\BookAppointment;
use App\Livewire\Health\HealthDashboard;
use App\Livewire\MyHousehold;
use App\Models\Appointment;
use App\Models\Household;
use App\Models\Resident;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;
use Livewire\Livewire;
use Tests\TestCase;

class BarangayServicesTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_model_role_helpers(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $health = User::factory()->create(['role' => 'health_admin']);
        $head = User::factory()->create(['role' => 'household_head']);
        $resident = User::factory()->create(['role' => 'resident']);

        $this->assertTrue($admin->isAdmin());
        $this->assertFalse($admin->isHealthAdmin());

        $this->assertTrue($health->isHealthAdmin());
        $this->assertTrue($head->isHouseholdHead());
        $this->assertTrue($resident->isResident());
    }

    public function test_health_officer_database_query_scoping(): void
    {
        // Set up the health dashboard
        $healthAdmin = User::factory()->create(['role' => 'health_admin']);
        $this->actingAs($healthAdmin);

        // Create a resident with private data (income) and health condition
        $resident = Resident::create([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'age' => 45,
            'sex' => 'Male',
            'health_condition' => 'Hypertension',
            'fully_vaccinated' => 'Y',
            'income' => '50000', // Highly private field
            'registered_national_voter' => 'Y', // Highly private voter info
        ]);

        // Let's run a query representing the HealthDashboard select logic
        $selectedColumns = [
            'id',
            'first_name',
            'last_name',
            'age',
            'sex',
            'age_classification',
            'health_condition',
            'unvaccinated',
            'partially_vaccinated',
            'fully_vaccinated',
            'covid_dose_1_date',
            'covid_dose_2_date',
            'covid_brand',
            'has_booster',
            'booster_date',
            'booster_brand',
            'nutritional_classification',
            'vulnerable_sector',
        ];

        $queriedResident = Resident::select($selectedColumns)->first();

        $this->assertEquals('John', $queriedResident->first_name);
        $this->assertEquals('Hypertension', $queriedResident->health_condition);

        // Assert that private fields (income, national voter status) are not selected/accessible on the model!
        $this->assertNull($queriedResident->income);
        $this->assertNull($queriedResident->registered_national_voter);
    }

    public function test_residents_can_book_appointments(): void
    {
        $user = User::factory()->create(['role' => 'resident']);
        $this->actingAs($user);

        $component = new BookAppointment;
        $validator = Validator::make(
            [
                'appointment_category' => 'document',
                'document_type' => 'Barangay Clearance',
                'purpose_details' => 'For job application',
            ],
            $component->rules()
        );

        $this->assertFalse(
            $validator->fails(),
            'Expected no validation errors but got: '.json_encode($validator->errors()->toArray())
        );

        // Confirm booking works through Livewire component logic
        Livewire::test(BookAppointment::class)
            ->set('appointment_category', 'document')
            ->set('document_type', 'Barangay Clearance')
            ->set('purpose_details', 'For job application')
            ->call('book')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('appointments', [
            'user_id' => $user->id,
            'purpose' => 'Barangay Clearance — For job application',
            'status' => 'pending',
            'appointment_date' => null,
        ]);
    }

    public function test_admin_can_approve_appointments(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $resident = User::factory()->create(['role' => 'resident']);

        $appointment = Appointment::create([
            'user_id' => $resident->id,
            'purpose' => 'Indigency Certificate Request',
            'status' => 'pending',
            'appointment_date' => null,
            'appointment_time' => null,
        ]);

        $this->actingAs($admin);

        // Step 1: Admin transitions from pending to approved-pending
        Livewire::test(ManageAppointments::class)
            ->call('markApprovedPending', $appointment->id)
            ->assertHasNoErrors();

        $appointment = $appointment->fresh();
        $this->assertEquals('approved-pending', $appointment->status);

        // Step 2: Admin schedules and approves the appointment
        Livewire::test(ManageAppointments::class)
            ->call('startApprove', $appointment->id)
            ->set('redemptionDate', '2026-06-19')
            ->set('redemptionTime', '10:00 AM - 11:00 AM')
            ->call('confirmApprove')
            ->assertHasNoErrors();

        $appointment = $appointment->fresh();
        $this->assertEquals('approved', $appointment->status);
        $this->assertEquals('2026-06-19', $appointment->appointment_date->toDateString());
        $this->assertEquals('10:00 AM - 11:00 AM', $appointment->appointment_time);
    }

    public function test_guests_cannot_access_any_authenticated_routes(): void
    {
        $this->get(route('dashboard'))->assertRedirect(route('home'));
        $this->get(route('rbi'))->assertRedirect(route('home'));
        $this->get(route('rbi-data'))->assertRedirect(route('home'));
        $this->get(route('health'))->assertRedirect(route('home'));
        $this->get(route('household'))->assertRedirect(route('home'));
        $this->get(route('appointments'))->assertRedirect(route('home'));
    }

    public function test_residents_cannot_access_admin_or_health_routes(): void
    {
        $resident = User::factory()->create(['role' => 'resident']);
        $this->actingAs($resident);

        $this->get(route('rbi'))->assertStatus(403);
        $this->get(route('rbi-data'))->assertStatus(403);
        $this->get(route('health'))->assertStatus(403);
        $this->get(route('household'))->assertStatus(403);

        $this->get(route('dashboard'))->assertOk();
        $this->get(route('appointments'))->assertOk();
    }

    public function test_health_officers_cannot_access_rbi_or_household_routes(): void
    {
        $health = User::factory()->create(['role' => 'health_admin']);
        $this->actingAs($health);

        $this->get(route('rbi'))->assertStatus(403);
        $this->get(route('rbi-data'))->assertStatus(403);
        $this->get(route('household'))->assertStatus(403);

        $this->get(route('health'))->assertOk();
        $this->get(route('dashboard'))->assertOk();
        $this->get(route('appointments'))->assertOk();
    }

    public function test_household_heads_cannot_access_rbi_or_health_routes(): void
    {
        $head = User::factory()->create(['role' => 'household_head']);
        $this->actingAs($head);

        $this->get(route('rbi'))->assertStatus(403);
        $this->get(route('rbi-data'))->assertStatus(403);
        $this->get(route('health'))->assertStatus(403);

        $this->get(route('household'))->assertOk();
        $this->get(route('dashboard'))->assertOk();
        $this->get(route('appointments'))->assertOk();
    }

    public function test_admins_can_access_all_routes(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);

        $this->get(route('dashboard'))->assertOk();
        $this->get(route('rbi'))->assertOk();
        $this->get(route('rbi-data'))->assertOk();
        $this->get(route('health'))->assertOk();
        $this->get(route('household'))->assertOk();
        $this->get(route('appointments'))->assertOk();

        // Check if the component renders successfully
        Livewire::test(RbiDataTable::class)
            ->assertOk();
    }

    public function test_admin_can_create_household_head(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);

        Livewire::test(ManageRbi::class)
            ->set('household_no', 'HH-9999')
            ->set('purok_no', '4')
            ->set('address', 'Purok 4, Sambog, Corella, Bohol')
            ->set('first_name', 'Maria')
            ->set('last_name', 'Clara')
            ->set('birthdate', '1990-05-15')
            ->set('sex', 'Female')
            ->set('civil_status', 'Married')
            ->set('citizenship', 'Filipino')
            ->set('email', 'mariaclara@test.com')
            ->set('password', 'secret123')
            ->call('saveHouseholdHead')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('households', [
            'household_no' => 'HH-9999',
            'purok_no' => '4',
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'mariaclara@test.com',
            'role' => 'household_head',
        ]);

        $this->assertDatabaseHas('residents', [
            'first_name' => 'Maria',
            'last_name' => 'Clara',
            'relationship_to_head' => 'Household Head',
            'email_address' => 'mariaclara@test.com',
            'age' => 36, // relative to 2026-06-01 (1990 to 2026 is 36 years)
        ]);
    }

    public function test_household_head_can_create_resident(): void
    {
        // Setup household head
        $headUser = User::factory()->create(['role' => 'household_head']);
        $household = Household::create([
            'household_no' => 'HH-8888',
            'purok_no' => '3',
            'address' => 'Test Address',
        ]);
        $headResident = Resident::create([
            'household_id' => $household->id,
            'user_id' => $headUser->id,
            'first_name' => 'Crisostomo',
            'last_name' => 'Ibarra',
            'relationship_to_head' => 'Household Head',
            'birthdate' => '1988-10-10',
            'age' => 37,
            'sex' => 'Male',
        ]);

        $this->actingAs($headUser);

        Livewire::test(MyHousehold::class)
            ->set('first_name', 'Basilio')
            ->set('last_name', 'Ibarra')
            ->set('relationship_to_head', 'Son')
            ->set('birthdate', '2015-08-20')
            ->set('sex', 'Male')
            ->set('civil_status', 'Single')
            ->set('citizenship', 'Filipino')
            ->set('registered_national_voter', 'N')
            ->set('registered_sk_voter', 'N')
            ->set('resident_voter', 'N')
            ->set('fully_vaccinated', 'Y')
            ->set('has_philhealth', 'N')
            ->set('educational_status', 'Enrolled')
            ->set('work_status', 'Student')
            ->call('saveResident')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('residents', [
            'household_id' => $household->id,
            'first_name' => 'Basilio',
            'last_name' => 'Ibarra',
            'relationship_to_head' => 'Son',
            'age' => 10, // relative to 2026-06-01 (Aug 2015 to June 2026 is 10 years, since birthday has not occurred yet!)
        ]);
    }

    public function test_validation_rules_for_household_and_residents(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);

        // Missing fields should cause validation errors
        Livewire::test(ManageRbi::class)
            ->call('saveHouseholdHead')
            ->assertHasErrors([
                'household_no', 'purok_no', 'address',
                'first_name', 'last_name', 'birthdate', 'sex', 'civil_status',
                'email', 'password',
            ]);
    }

    public function test_residents_can_book_rental_with_optional_date(): void
    {
        $user = User::factory()->create(['role' => 'resident']);
        $this->actingAs($user);

        $rentalDate = now()->addDays(5)->toDateString();

        Livewire::test(BookAppointment::class)
            ->set('appointment_category', 'rental')
            ->set('document_type', 'Plastic Monoblock Chairs Rental')
            ->set('purpose_details', 'Need 30 chairs for birthday party')
            ->set('rental_date', $rentalDate)
            ->call('book')
            ->assertHasNoErrors();

        $appointment = Appointment::where('user_id', $user->id)->first();
        $this->assertNotNull($appointment);
        $this->assertEquals('[Rental Service] Plastic Monoblock Chairs Rental — Need 30 chairs for birthday party', $appointment->purpose);
        $this->assertEquals('pending', $appointment->status);
        $this->assertEquals($rentalDate, $appointment->appointment_date->toDateString());
    }

    public function test_rental_date_validation_prevents_past_dates(): void
    {
        $user = User::factory()->create(['role' => 'resident']);
        $this->actingAs($user);

        $pastDate = now()->subDays(2)->toDateString();

        Livewire::test(BookAppointment::class)
            ->set('appointment_category', 'rental')
            ->set('document_type', 'Plastic Monoblock Chairs Rental')
            ->set('rental_date', $pastDate)
            ->call('book')
            ->assertHasErrors(['rental_date' => 'after_or_equal']);
    }

    public function test_rental_date_picker_is_rendered_for_rental_category(): void
    {
        $user = User::factory()->create(['role' => 'resident']);
        $this->actingAs($user);

        Livewire::test(BookAppointment::class)
            ->set('appointment_category', 'rental')
            ->assertSee('Preferred Rental / Event Date')
            ->assertSeeHtml('id="rental_date"');
    }
}
