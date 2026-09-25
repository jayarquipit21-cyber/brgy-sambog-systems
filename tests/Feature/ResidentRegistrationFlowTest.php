<?php

namespace Tests\Feature;

use App\Livewire\CompleteProfile;
use App\Models\Household;
use App\Models\Resident;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Laravel\Fortify\Features;
use Livewire\Livewire;
use Tests\TestCase;

class ResidentRegistrationFlowTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->skipUnlessFortifyHas(Features::registration());
    }

    public function test_resident_registration_page_is_accessible_and_clean(): void
    {
        $response = $this->get(route('register'));

        $response->assertOk();
        $response->assertSee(__('Create an account'));
        $response->assertSee('Full name', false);
        $response->assertSee('email@example.com', false);
        $response->assertSee('Password', false);
        $response->assertSee('Confirm password', false);
        $response->assertSee(__('Already have an account?'));
    }

    public function test_resident_can_easily_register_with_minimal_required_information(): void
    {
        // Simple 4-field sign up form: name, email, password, password_confirmation
        $response = $this->post(route('register.store'), [
            'name' => 'Maria Santos',
            'email' => 'maria.santos@example.com',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
        ]);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('dashboard', absolute: false));

        $this->assertAuthenticated();

        $user = User::where('email', 'maria.santos@example.com')->first();
        $this->assertNotNull($user);
        $this->assertEquals('Maria Santos', $user->name);
        $this->assertEquals('resident', $user->role);
        $this->assertTrue($user->isResident());
    }

    public function test_registration_automatically_links_to_existing_rbi_record(): void
    {
        // Setup existing household & resident record in RBI registry
        $household = Household::create([
            'household_no' => 'HH-2026-001',
            'purok_no' => '3',
            'street' => 'Mabini St',
        ]);

        $resident = Resident::create([
            'household_id' => $household->id,
            'first_name' => 'Juan',
            'last_name' => 'Dela Cruz',
            'email_address' => 'juan.delacruz@example.com',
            'sex' => 'Male',
            'birthdate' => '1995-05-15',
            'civil_status' => 'Single',
            'registration_status' => 'approved',
            'user_id' => null,
        ]);

        // Juan registers an account using case-insensitive matching email
        $response = $this->post(route('register.store'), [
            'name' => 'Juan Dela Cruz',
            'email' => 'JUAN.DELACRUZ@EXAMPLE.COM',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
        ]);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('dashboard', absolute: false));

        $user = User::whereRaw('LOWER(email) = ?', ['juan.delacruz@example.com'])->first();
        $this->assertNotNull($user);

        // Verify RBI resident record was automatically linked to the user account
        $resident->refresh();
        $this->assertEquals($user->id, $resident->user_id);
        $this->assertEquals($resident->id, $user->resident->id);
    }

    public function test_registration_validation_catches_invalid_inputs_with_helpful_errors(): void
    {
        // 1. Empty submission
        $response = $this->post(route('register.store'), []);
        $response->assertSessionHasErrors(['name', 'email', 'password']);

        // 2. Invalid email format
        $response = $this->post(route('register.store'), [
            'name' => 'Test User',
            'email' => 'not-an-email',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
        ]);
        $response->assertSessionHasErrors(['email']);

        // 3. Password confirmation mismatch
        $response = $this->post(route('register.store'), [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'Password123!',
            'password_confirmation' => 'DifferentPassword123!',
        ]);
        $response->assertSessionHasErrors(['password']);

        // 4. Duplicate email prevention
        User::create([
            'name' => 'Existing Resident',
            'email' => 'existing@example.com',
            'password' => Hash::make('password123'),
            'role' => 'resident',
        ]);

        $response = $this->post(route('register.store'), [
            'name' => 'Another Person',
            'email' => 'existing@example.com',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
        ]);
        $response->assertSessionHasErrors(['email']);
    }

    public function test_newly_registered_resident_lands_on_functional_dashboard(): void
    {
        $user = User::factory()->create([
            'name' => 'Elena Gomez',
            'email' => 'elena.gomez@example.com',
            'role' => 'resident',
        ]);

        $response = $this->actingAs($user)->get(route('dashboard'));

        $response->assertOk();
        $response->assertViewIs('dashboard');
        $response->assertSee('My Request Activity');
        $response->assertSee('Pending Slots');
    }

    public function test_resident_can_access_services_and_profile_completion(): void
    {
        $household = Household::create([
            'household_no' => 'HH-2026-002',
            'purok_no' => '1',
        ]);

        $resident = Resident::create([
            'household_id' => $household->id,
            'first_name' => 'Elena',
            'last_name' => 'Gomez',
            'email_address' => 'elena.gomez@example.com',
            'sex' => 'Female',
            'registration_status' => 'approved',
        ]);

        $user = User::factory()->create([
            'name' => 'Elena Gomez',
            'email' => 'elena.gomez@example.com',
            'role' => 'resident',
        ]);

        $resident->update(['user_id' => $user->id]);

        // Resident can view services & profile completion
        $this->actingAs($user)->get(route('services.documents'))->assertOk();
        $this->actingAs($user)->get(route('services.rentals'))->assertOk();
        $this->actingAs($user)->get(route('profile.complete'))->assertOk();

        // Complete profile via Livewire
        Livewire::actingAs($user)
            ->test(CompleteProfile::class)
            ->set('place_of_birth', 'Tagbilaran City')
            ->set('religion', 'Roman Catholic')
            ->set('blood_type', 'O+')
            ->set('occupation', 'Teacher')
            ->call('save')
            ->assertHasNoErrors();

        $resident->refresh();
        $this->assertEquals('Tagbilaran City', $resident->place_of_birth);
        $this->assertEquals('Roman Catholic', $resident->religion);
        $this->assertEquals('O+', $resident->blood_type);
        $this->assertEquals('Teacher', $resident->occupation);
    }

    public function test_head_adds_resident_member_who_later_registers_their_own_account(): void
    {
        // 1. Setup household and household head
        $household = Household::create([
            'household_no' => 'HH-SAMBOG-101',
            'purok_no' => '4',
            'street' => 'Rizal Ave',
        ]);

        $headUser = User::factory()->create([
            'name' => 'Roberto Santos',
            'email' => 'roberto.head@example.com',
            'role' => 'household_head',
        ]);

        $headResident = Resident::create([
            'household_id' => $household->id,
            'user_id' => $headUser->id,
            'first_name' => 'Roberto',
            'last_name' => 'Santos',
            'relationship_to_head' => 'Head',
            'sex' => 'Male',
            'birthdate' => '1970-01-01',
            'age' => 56,
            'civil_status' => 'Married',
            'registration_status' => 'approved',
        ]);

        $headUser = User::find($headUser->id);

        // 2. Household Head adds a family member (daughter Pedro/Ana Santos) via MyHousehold component
        Livewire::actingAs($headUser)
            ->test(\App\Livewire\MyHousehold::class)
            ->set('first_name', 'Ana')
            ->set('last_name', 'Santos')
            ->set('relationship_to_head', 'Daughter')
            ->set('birthdate', '2004-03-20')
            ->set('sex', 'Female')
            ->set('civil_status', 'Single')
            ->set('citizenship', 'Filipino')
            ->set('mobile_number', '09171234567')
            ->set('email_address', 'ana.santos@example.com')
            ->set('registered_national_voter', 'Y')
            ->set('registered_sk_voter', 'Y')
            ->set('resident_voter', 'Y')
            ->set('fully_vaccinated', 'Y')
            ->set('has_philhealth', 'Y')
            ->set('health_condition', 'None')
            ->set('educational_status', 'College')
            ->set('work_status', 'Student')
            ->call('saveResident')
            ->assertHasNoErrors();

        $anaResident = Resident::where('email_address', 'ana.santos@example.com')->first();
        $this->assertNotNull($anaResident);
        $this->assertEquals($household->id, $anaResident->household_id);
        $this->assertNull($anaResident->user_id);
        $this->assertEquals('Daughter', $anaResident->relationship_to_head);

        // 3. Head logs out. Later, Ana visits /register as a guest to make her own resident account
        auth()->logout();

        $response = $this->post(route('register.store'), [
            'name' => 'Ana Santos',
            'email' => 'ana.santos@example.com',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
        ]);

        $response->assertSessionHasNoErrors()
            ->assertRedirect(route('dashboard', absolute: false));

        // 4. Ana is logged in and her user account is automatically bound to the resident record
        $this->assertAuthenticated();

        $anaUser = User::where('email', 'ana.santos@example.com')->first();
        $this->assertNotNull($anaUser);
        $this->assertEquals('resident', $anaUser->role);

        $anaResident->refresh();
        $this->assertEquals($anaUser->id, $anaResident->user_id);
        $this->assertEquals($anaResident->id, $anaUser->resident->id);

        // 5. Ana lands on resident dashboard and sees her linked info
        $dashboardResponse = $this->actingAs($anaUser)->get(route('dashboard'));
        $dashboardResponse->assertOk();
        $dashboardResponse->assertSee('Ana');
        $dashboardResponse->assertSee('Santos');
    }

    public function test_newly_registered_resident_cannot_access_unauthorized_admin_routes(): void
    {
        $user = User::factory()->create([
            'role' => 'resident',
        ]);

        // Attempting to visit RBI admin management
        $response = $this->actingAs($user)->get(route('rbi'));
        $response->assertForbidden();

        // Attempting to visit admin sales
        $response = $this->actingAs($user)->get(route('admin.sales'));
        $response->assertForbidden();

        // Attempting to visit health officer pages
        $response = $this->actingAs($user)->get(route('health'));
        $response->assertForbidden();
    }
}


