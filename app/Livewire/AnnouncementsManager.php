<?php

namespace App\Livewire;

use App\Models\Announcement;
use App\Models\User;
use App\Notifications\SystemNotification;
use Flux\Flux;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AnnouncementsManager extends Component
{
    public string $title = '';

    public string $body = '';

    public string $type = 'general';

    public ?string $event_date = null;

    public ?string $event_end_date = null;

    public ?string $event_location = null;

    public bool $is_pinned = false;

    public bool $publish_now = true;

    public ?int $editingId = null;

    protected function rules(): array
    {
        return [
            'title' => 'required|string|max:150',
            'body' => 'required|string|max:2000',
            'type' => 'nullable|string|max:50',
            'event_date' => 'nullable|date',
            'event_end_date' => 'nullable|date|after_or_equal:event_date',
            'event_location' => 'nullable|string|max:255',
            'is_pinned' => 'boolean',
            'publish_now' => 'boolean',
        ];
    }

    public function createAnnouncement()
    {
        if (! Auth::check() || ! Auth::user()->isAdmin()) {
            abort(403);
        }

        $this->validate();

        Announcement::create([
            'user_id' => Auth::id(),
            'title' => $this->title,
            'body' => $this->body,
            'type' => $this->type ?? 'general',
            'event_date' => $this->type === 'event' ? $this->event_date : null,
            'event_end_date' => $this->type === 'event' ? $this->event_end_date : null,
            'event_location' => $this->type === 'event' ? $this->event_location : null,
            'is_pinned' => $this->is_pinned,
            'published_at' => $this->publish_now ? now() : null,
        ]);

        $this->reset(['title', 'body', 'type', 'event_date', 'event_end_date', 'event_location', 'is_pinned', 'publish_now']);

        if ($this->publish_now) {
            $this->notifyAllUsers($announcement);
        }

        Flux::toast(variant: 'success', text: __('Announcement published.'));
    }

    public function editAnnouncement(int $id)
    {
        if (! Auth::check() || ! Auth::user()->isAdmin()) {
            abort(403);
        }
        $a = Announcement::find($id);
        if (! $a) {
            return;
        }
        $this->editingId = $a->id;
        $this->title = $a->title;
        $this->body = $a->body;
        $this->type = $a->type;
        $this->event_date = $a->event_date ? $a->event_date->format('Y-m-d\TH:i') : null;
        $this->event_end_date = $a->event_end_date ? $a->event_end_date->format('Y-m-d\TH:i') : null;
        $this->event_location = $a->event_location;
        $this->is_pinned = (bool) $a->is_pinned;
        $this->publish_now = (bool) $a->published_at;
    }

    public function updateAnnouncement()
    {
        if (! Auth::check() || ! Auth::user()->isAdmin()) {
            abort(403);
        }
        if (! $this->editingId) {
            return;
        }
        $this->validate();
        $a = Announcement::find($this->editingId);
        if (! $a) {
            return;
        }
        $a->update([
            'title' => $this->title,
            'body' => $this->body,
            'type' => $this->type ?? 'general',
            'event_date' => $this->type === 'event' ? $this->event_date : null,
            'event_end_date' => $this->type === 'event' ? $this->event_end_date : null,
            'event_location' => $this->type === 'event' ? $this->event_location : null,
            'is_pinned' => $this->is_pinned,
            'published_at' => $this->publish_now ? now() : null,
        ]);
        $this->cancelEdit();
        Flux::toast(variant: 'success', text: __('Announcement updated.'));
    }

    public function cancelEdit()
    {
        $this->editingId = null;
        $this->reset(['title', 'body', 'type', 'event_date', 'event_end_date', 'event_location', 'is_pinned', 'publish_now']);
    }

    public function deleteAnnouncement(int $id)
    {
        if (! Auth::check() || ! Auth::user()->isAdmin()) {
            abort(403);
        }

        $a = Announcement::find($id);
        if ($a) {
            $a->delete();
        }
        Flux::toast(variant: 'success', text: __('Announcement deleted.'));
    }

    public function publishAnnouncement(int $id)
    {
        if (! Auth::check() || ! Auth::user()->isAdmin()) {
            abort(403);
        }

        $a = Announcement::find($id);
        if ($a && ! $a->published_at) {
            $a->update(['published_at' => now()]);

            $this->notifyAllUsers($a);

            Flux::toast(variant: 'success', text: __('Announcement published.'));
        }
    }

    public function unpublishAnnouncement(int $id)
    {
        if (! Auth::check() || ! Auth::user()->isAdmin()) {
            abort(403);
        }

        $a = Announcement::find($id);
        if ($a && $a->published_at) {
            $a->update(['published_at' => null]);
            Flux::toast(variant: 'success', text: __('Announcement unpublished.'));
        }
    }

    public function render()
    {
        $announcements = Announcement::orderByDesc('is_pinned')->orderByDesc('published_at')->get();

        return view('livewire.announcements-manager', ['announcements' => $announcements]);
    }
}
