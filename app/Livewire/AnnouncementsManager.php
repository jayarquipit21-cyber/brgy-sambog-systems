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

    public bool $is_event = false;

    public ?string $event_date = null;

    public ?string $event_end_date = null;

    public ?string $event_location = null;

    public bool $is_pinned = false;

    public bool $publish_now = true;

    public ?int $editingId = null;

    public string $search = '';

    public string $filterType = ''; // '', 'event', 'general'

    protected function rules(): array
    {
        return [
            'title' => 'required|string|max:150',
            'body' => 'required|string|max:2000',
            'is_event' => 'boolean',
            'type' => 'nullable|string|max:50',
            'event_date' => 'nullable|required_if:is_event,true|date',
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

        $announcement = Announcement::create([
            'user_id' => Auth::id(),
            'title' => $this->title,
            'body' => $this->body,
            'type' => $this->is_event ? 'event' : 'general',
            'event_date' => $this->is_event ? $this->event_date : null,
            'event_end_date' => $this->is_event ? $this->event_end_date : null,
            'event_location' => $this->is_event ? $this->event_location : null,
            'is_pinned' => $this->is_pinned,
            'published_at' => $this->publish_now ? now() : null,
        ]);

        // Notify before reset so $this->publish_now still holds the user's input
        if ($this->publish_now) {
            $this->notifyAllUsers($announcement);
        }

        $this->reset(['title', 'body', 'type', 'is_event', 'event_date', 'event_end_date', 'event_location', 'is_pinned', 'publish_now']);

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
        $this->is_event = ($a->type === 'event' || ! empty($a->event_date));
        $this->type = $a->type ?? 'general';
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
            'type' => $this->is_event ? 'event' : 'general',
            'event_date' => $this->is_event ? $this->event_date : null,
            'event_end_date' => $this->is_event ? $this->event_end_date : null,
            'event_location' => $this->is_event ? $this->event_location : null,
            'is_pinned' => $this->is_pinned,
            'published_at' => $this->publish_now ? now() : null,
        ]);
        $this->cancelEdit();
        Flux::toast(variant: 'success', text: __('Announcement updated.'));
    }

    public function cancelEdit()
    {
        $this->editingId = null;
        $this->reset(['title', 'body', 'type', 'is_event', 'event_date', 'event_end_date', 'event_location', 'is_pinned', 'publish_now']);
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

    /**
     * Send a notification to all users about a published announcement.
     */
    private function notifyAllUsers(Announcement $announcement): void
    {
        $users = User::where('id', '!=', Auth::id())->get();
        foreach ($users as $user) {
            $user->notify(new SystemNotification(
                'New Announcement',
                $announcement->title,
                'megaphone',
                route('dashboard')
            ));
        }
    }

    public function render()
    {
        $query = Announcement::orderByDesc('is_pinned')->orderByDesc('published_at');

        if ($this->search) {
            $s = '%'.$this->search.'%';
            $query->where(function ($q) use ($s) {
                $q->where('title', 'like', $s)
                    ->orWhere('body', 'like', $s)
                    ->orWhere('event_location', 'like', $s);
            });
        }

        if ($this->filterType === 'event') {
            $query->where(function ($q) {
                $q->where('type', 'event')->orWhereNotNull('event_date');
            });
        } elseif ($this->filterType === 'general') {
            $query->where(function ($q) {
                $q->where('type', '!=', 'event')->orWhereNull('type');
            })->whereNull('event_date');
        }

        return view('livewire.announcements-manager', ['announcements' => $query->get()]);
    }
}
