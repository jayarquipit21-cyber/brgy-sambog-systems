<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_are_redirected_to_the_home_page(): void
    {
        $response = $this->get(route('dashboard'));
        $response->assertRedirect(route('home'));
    }

    public function test_authenticated_users_can_visit_the_dashboard(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('dashboard'));
        $response->assertOk();
    }

    public function test_admin_dashboard_renders_all_graphs_with_data_attributes(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);

        $response = $this->get(route('dashboard'));
        $response->assertOk();
        $response->assertViewHasAll([
            'purokLabels',
            'purokValues',
            'genderLabels',
            'genderValues',
            'ageLabels',
            'ageValues',
        ]);
        $response->assertSee('id="purokChart"', false);
        $response->assertSee('id="genderChartAdmin"', false);
        $response->assertSee('id="ageChartAdmin"', false);
        $response->assertSee('data-navigate-eval', false);
    }

    public function test_health_admin_dashboard_renders_graphs_with_data_attributes(): void
    {
        $healthAdmin = User::factory()->create(['role' => 'health_admin']);
        $this->actingAs($healthAdmin);

        $response = $this->get(route('dashboard'));
        $response->assertOk();
        $response->assertViewHasAll([
            'genderLabels',
            'genderValues',
            'ageLabels',
            'ageValues',
        ]);
        $response->assertSee('id="genderChartHealth"', false);
        $response->assertSee('id="ageChartHealth"', false);
        $response->assertSee('data-navigate-eval', false);
    }

    public function test_household_head_dashboard_renders_family_demographics_graph(): void
    {
        $head = User::factory()->create(['role' => 'household_head']);
        $this->actingAs($head);

        $response = $this->get(route('dashboard'));
        $response->assertOk();
        $response->assertViewHasAll([
            'householdAgeLabels',
            'householdAgeValues',
            'householdGenderLabels',
            'householdGenderValues',
        ]);
        $response->assertSee('id="householdAgeChart"', false);
        $response->assertSee('data-chart-init="initHouseholdChart"', false);
        $response->assertSee('data-navigate-eval', false);
    }

    public function test_resident_dashboard_renders_activity_graph(): void
    {
        $resident = User::factory()->create(['role' => 'resident']);
        $this->actingAs($resident);

        $response = $this->get(route('dashboard'));
        $response->assertOk();
        $response->assertViewHasAll([
            'residentActivityLabels',
            'residentActivityValues',
            'totalAppointmentsCount',
        ]);
        $response->assertSee('id="residentActivityChart"', false);
        $response->assertSee('data-chart-init="initResidentChart"', false);
        $response->assertSee('data-navigate-eval', false);
    }
}
