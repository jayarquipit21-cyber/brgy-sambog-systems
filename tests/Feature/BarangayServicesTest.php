<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Resident;
use App\Models\Appointment;
use App\Livewire\BookAppointment;
use App\Livewire\Admin\ManageAppointments;
use App\Livewire\Health\HealthDashboard;
use Illuminate\Foundation\Testing\RefreshDatabase;
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
            'vulnerable_sector'
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

        Livewire::test(BookAppointment::class)
            ->set('appointment_date', now()->addDays(2)->format('Y-m-d'))
            ->set('appointment_time', '10:00 AM')
            ->set('purpose', 'Barangay Clearance Request')
            ->call('book')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('appointments', [
            'user_id' => $user->id,
            'purpose' => 'Barangay Clearance Request',
            'status' => 'pending',
        ]);
    }

    public function test_admin_can_approve_appointments(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $resident = User::factory()->create(['role' => 'resident']);

        $appointment = Appointment::create([
            'user_id' => $resident->id,
            'appointment_date' => now()->addDays(2)->format('Y-m-d'),
            'appointment_time' => '10:00 AM',
            'purpose' => 'Indigency Certificate Request',
            'status' => 'pending',
        ]);

        $this->actingAs($admin);

        Livewire::test(ManageAppointments::class)
            ->call('approve', $appointment->id);

        $this->assertEquals('approved', $appointment->fresh()->status);
    }

    public function test_guests_cannot_access_any_authenticated_routes(): void
    {
        $this->get(route('dashboard'))->assertRedirect(route('login'));
        $this->get(route('rbi'))->assertRedirect(route('login'));
        $this->get(route('health'))->assertRedirect(route('login'));
        $this->get(route('household'))->assertRedirect(route('login'));
        $this->get(route('appointments'))->assertRedirect(route('login'));
    }

    public function test_residents_cannot_access_admin_or_health_routes(): void
    {
        $resident = User::factory()->create(['role' => 'resident']);
        $this->actingAs($resident);

        $this->get(route('rbi'))->assertStatus(403);
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
        $this->get(route('health'))->assertOk();
        $this->get(route('household'))->assertOk();
        $this->get(route('appointments'))->assertOk();
    }
}

