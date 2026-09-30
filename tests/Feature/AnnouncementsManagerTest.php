<?php

namespace Tests\Feature;

use App\Livewire\AnnouncementsManager;
use App\Models\Announcement;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class AnnouncementsManagerTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_and_publish_announcement_with_bulk_notifications(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $users = User::factory()->count(25)->create();

        $this->actingAs($admin);

        Livewire::test(AnnouncementsManager::class)
            ->set('title', 'Barangay Clean-up Drive')
            ->set('body', 'Join us this Saturday for a community cleanup.')
            ->set('is_event', true)
            ->set('event_date', now()->addDays(2)->format('Y-m-d\TH:i'))
            ->set('event_location', 'Barangay Plaza')
            ->set('publish_now', true)
            ->call('createAnnouncement')
            ->assertHasNoErrors();

        $this->assertDatabaseHas('announcements', [
            'title' => 'Barangay Clean-up Drive',
            'type' => 'event',
            'event_location' => 'Barangay Plaza',
        ]);

        // Each of the 25 users should have a notification
        $this->assertDatabaseCount('notifications', 25);
    }

    public function test_unpublished_announcement_does_not_notify_until_published(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $users = User::factory()->count(10)->create();

        $this->actingAs($admin);

        Livewire::test(AnnouncementsManager::class)
            ->set('title', 'Draft Announcement')
            ->set('body', 'Draft content.')
            ->set('publish_now', false)
            ->call('createAnnouncement')
            ->assertHasNoErrors();

        $this->assertDatabaseCount('notifications', 0);

        $announcement = Announcement::where('title', 'Draft Announcement')->firstOrFail();
        $this->assertNull($announcement->published_at);

        // Now publish it
        Livewire::test(AnnouncementsManager::class)
            ->call('publishAnnouncement', $announcement->id)
            ->assertHasNoErrors();

        $this->assertDatabaseCount('notifications', 10);
    }
}
