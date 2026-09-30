<?php

namespace Tests\Feature;

use App\Livewire\Health\HealthDashboard;
use App\Models\Household;
use App\Models\Resident;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class HealthDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_health_officer_can_view_health_dashboard(): void
    {
        $healthAdmin = User::factory()->create(['role' => 'health_admin']);
        $this->actingAs($healthAdmin);

        $response = $this->get(route('health'));
        $response->assertOk();
        $response->assertSeeLivewire(HealthDashboard::class);
    }

    public function test_clicking_resident_name_opens_health_card_with_profile_and_vitals(): void
    {
        $healthAdmin = User::factory()->create(['role' => 'health_admin']);
        $this->actingAs($healthAdmin);

        $household = Household::create([
            'household_no' => 'HH-2026-999',
            'purok_no' => 4,
            'address' => 'Corella Highway',
        ]);

        $resident = Resident::create([
            'household_id' => $household->id,
            'first_name' => 'Maria',
            'last_name' => 'Santos',
            'age' => 45,
            'sex' => 'Female',
            'blood_type' => 'O+',
            'height' => '160',
            'weight' => '55',
            'health_condition' => 'Hypertension',
            'fully_vaccinated' => 'Y',
            'covid_brand' => 'Pfizer-BioNTech',
            'has_booster' => 'Y',
            'booster_brand' => 'Moderna',
            'has_philhealth' => 'Y',
            'philhealth_id' => '12-345678901-2',
            'registration_status' => 'approved',
        ]);

        Livewire::test(HealthDashboard::class)
            ->assertSee('Santos, Maria')
            ->call('openResidentHealthCard', $resident->id)
            ->assertSet('showHealthCardModal', true)
            ->assertSee('Maria Santos')
            ->assertSee('Hypertension')
            ->assertSee('Pfizer-BioNTech')
            ->assertSee('Moderna')
            ->assertSee('12-345678901-2')
            ->assertSee('BMI 21.5')
            ->call('closeResidentHealthCard')
            ->assertSet('showHealthCardModal', false);
    }
}
