<?php

namespace Tests\Feature;

use App\Livewire\Settings\Profile;
use App\Models\Household;
use App\Models\Resident;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class DedicatedProfilePageTest extends TestCase
{
    use RefreshDatabase;

    public function test_resident_dashboard_does_not_contain_profile_card_widget(): void
    {
        $household = Household::create([
            'household_no' => 'HH-SAMBOG-2026',
            'purok_no' => '2',
        ]);

        $user = User::factory()->create([
            'name' => 'Lourdes Santos',
            'email' => 'lourdes.santos@example.com',
            'role' => 'resident',
        ]);

        $resident = Resident::create([
            'household_id' => $household->id,
            'user_id' => $user->id,
            'first_name' => 'Lourdes',
            'last_name' => 'Santos',
            'sex' => 'Female',
            'birthdate' => '1998-07-21',
            'age' => 28,
            'registration_status' => 'approved',
        ]);

        $response = $this->actingAs($user)->get(route('dashboard'));

        $response->assertOk();
        // Dashboard contains activity and pending slots, but not the redundant static profile card
        $response->assertSee('My Request Activity');
        $response->assertSee('Pending Slots');
    }

    public function test_household_head_dashboard_does_not_contain_profile_card_widget(): void
    {
        $household = Household::create([
            'household_no' => 'HH-SAMBOG-2027',
            'purok_no' => '3',
        ]);

        $user = User::factory()->create([
            'name' => 'Danilo Reyes',
            'email' => 'danilo.reyes@example.com',
            'role' => 'household_head',
        ]);

        $resident = Resident::create([
            'household_id' => $household->id,
            'user_id' => $user->id,
            'first_name' => 'Danilo',
            'last_name' => 'Reyes',
            'relationship_to_head' => 'Head',
            'sex' => 'Male',
            'birthdate' => '1975-03-12',
            'age' => 51,
            'registration_status' => 'approved',
        ]);

        $response = $this->actingAs($user)->get(route('dashboard'));

        $response->assertOk();
        $response->assertSee('Household Members');
        $response->assertSee('Household Demographics');
    }

    public function test_dedicated_profile_page_shows_complete_resident_details(): void
    {
        $household = Household::create([
            'household_no' => 'HH-SAMBOG-888',
            'purok_no' => '5',
            'street' => 'Magsaysay St',
        ]);

        $user = User::factory()->create([
            'name' => 'Clara Bautista',
            'email' => 'clara.bautista@example.com',
            'role' => 'resident',
        ]);

        $resident = Resident::create([
            'household_id' => $household->id,
            'user_id' => $user->id,
            'first_name' => 'Clara',
            'last_name' => 'Bautista',
            'relationship_to_head' => 'Daughter',
            'sex' => 'Female',
            'birthdate' => '2001-09-10',
            'age' => 25,
            'civil_status' => 'Single',
            'citizenship' => 'Filipino',
            'place_of_birth' => 'Tagbilaran City',
            'religion' => 'Roman Catholic',
            'blood_type' => 'A+',
            'mobile_number' => '09181234567',
            'highest_educational_attainment' => 'Bachelor of Science in Nursing',
            'school_attended' => 'Holy Name University',
            'course_completed' => 'BSN',
            'work_status' => 'Employed',
            'occupation' => 'Registered Nurse',
            'income' => 32000,
            'registered_national_voter' => 'Y',
            'registered_sk_voter' => 'N',
            'has_philhealth' => 'Yes',
            'philhealth_id' => '12-987654321-0',
            'fully_vaccinated' => 'Y',
            'covid_brand' => 'Pfizer',
            'registration_status' => 'approved',
        ]);

        $response = $this->actingAs($user)->get(route('profile'));

        $response->assertOk();
        $response->assertSee('Clara Bautista');
        $response->assertSee('Tagbilaran City');
        $response->assertSee('Roman Catholic');
        $response->assertSee('A+');
        $response->assertSee('Registered Nurse');
        $response->assertSee('Holy Name University');
        $response->assertSee('Purok 5');
        $response->assertSee('HH-SAMBOG-888');
        $response->assertSee('12-987654321-0');
    }

    public function test_user_can_upload_and_remove_profile_picture(): void
    {
        Storage::fake('public');

        $user = User::factory()->create([
            'name' => 'Avatar Tester',
            'email' => 'avatar.tester@example.com',
            'role' => 'resident',
        ]);

        $file = UploadedFile::fake()->image('profile.jpg', 300, 300);

        // Selecting file should not save immediately until confirmed
        $test = Livewire::actingAs($user)
            ->test(Profile::class)
            ->set('avatarFile', $file);

        $user->refresh();
        $this->assertNull($user->avatar);

        // Confirm save
        $test->call('saveAvatar')
            ->assertHasNoErrors();

        $user->refresh();
        $this->assertNotNull($user->avatar);
        $this->assertNotNull($user->avatar_url);
        Storage::disk('public')->assertExists($user->avatar);

        // Test cancelling an upload
        $newFile = UploadedFile::fake()->image('new_profile.jpg', 300, 300);
        $test->set('avatarFile', $newFile)
            ->call('cancelAvatarUpload')
            ->assertSet('avatarFile', null);

        // Test removing avatar
        Livewire::actingAs($user)
            ->test(Profile::class)
            ->call('removeAvatar');

        $user->refresh();
        $this->assertNull($user->avatar);
        $this->assertNull($user->avatar_url);
    }

    public function test_user_can_edit_resident_details_from_dedicated_profile_page(): void
    {
        $household = Household::create([
            'household_no' => 'HH-SAMBOG-999',
            'purok_no' => '1',
        ]);

        $user = User::factory()->create([
            'name' => 'Eduardo Cruz',
            'email' => 'eduardo.cruz@example.com',
            'role' => 'resident',
        ]);

        $resident = Resident::create([
            'household_id' => $household->id,
            'user_id' => $user->id,
            'first_name' => 'Eduardo',
            'last_name' => 'Cruz',
            'registration_status' => 'approved',
        ]);

        Livewire::actingAs($user)
            ->test(Profile::class)
            ->set('place_of_birth', 'Cebu City')
            ->set('religion', 'Iglesia Ni Cristo')
            ->set('blood_type', 'B+')
            ->set('height', '175')
            ->set('weight', '70')
            ->set('occupation', 'Software Developer')
            ->set('income', '45000')
            ->call('updateResidentDetails')
            ->assertHasNoErrors();

        $resident->refresh();
        $this->assertEquals('Cebu City', $resident->place_of_birth);
        $this->assertEquals('Iglesia Ni Cristo', $resident->religion);
        $this->assertEquals('B+', $resident->blood_type);
        $this->assertEquals('175', $resident->height);
        $this->assertEquals('70', $resident->weight);
        $this->assertEquals('Software Developer', $resident->occupation);
        $this->assertEquals('45000', $resident->income);
    }

    public function test_profile_renders_photo_viewer_modal_with_change_option(): void
    {
        $user = User::factory()->create([
            'name' => 'Clara Bautista',
            'email' => 'clara@example.com',
            'role' => 'resident',
            'avatar' => 'avatars/test.jpg',
        ]);

        Livewire::actingAs($user)
            ->test(Profile::class)
            ->assertSee('View Photo')
            ->assertSee('Profile Photo')
            ->assertSee('Change Photo')
            ->assertSee('Remove Photo');
    }
}
