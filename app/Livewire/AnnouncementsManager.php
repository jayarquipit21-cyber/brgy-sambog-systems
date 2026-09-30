<?php

namespace App\Livewire;

use App\Models\Announcement;
use App\Models\User;
use App\Notifications\SystemNotification;
use Flux\Flux;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Component;

class AnnouncementsManager extends Component
{
    public string $title = '';

    public string $body = '';

    public string $description = '';

    public string $type = 'general';

    public bool $is_event = false;

    public ?string $event_date = null;

    public ?string $event_end_date = null;

    public ?string $event_location = null;

    public ?string $start_date = null;

    public ?string $start_time = '08:00';

    public ?string $end_date = null;

    public ?string $end_time = null;

    public bool $has_end_time = false;

    public bool $is_multi_day = false;

    public bool $is_pinned = false;

    public bool $publish_now = true;

    public ?int $editingId = null;

    public string $search = '';

    public string $filterType = ''; // '', 'event', 'general'

    protected $messages = [
        'title.required' => 'No announcement title entered',
        'body.required' => 'No announcement content/body entered',
        'description.required' => 'No announcement content/body entered',
    ];

    protected function rules(): array
    {
        return [
            'title' => 'required|string|max:150',
            'body' => 'required|string|max:2000',
            'description' => 'required|string|max:2000',
            'is_event' => 'boolean',
            'type' => 'nullable|string|max:50',
            'event_date' => 'nullable|required_if:is_event,true|date',
            'event_end_date' => 'nullable|date|after_or_equal:event_date',
            'event_location' => 'nullable|string|max:255',
            'is_pinned' => 'boolean',
            'publish_now' => 'boolean',
        ];
    }

    protected function messages(): array
    {
        return [
            'title.required' => 'No announcement title entered',
            'body.required' => 'No announcement content/body entered',
            'description.required' => 'No announcement content/body entered',
        ];
    }

    public function updatedBody($value): void
    {
        $this->description = $value;
    }

    public function updatedDescription($value): void
    {
        $this->body = $value;
    }

    public function updatedIsEvent($value): void
    {
        if ($value) {
            if (! $this->start_date) {
                $this->start_date = now()->format('Y-m-d');
            }
            if (! $this->start_time) {
                $this->start_time = '08:00';
            }
            $this->syncToEventDates();
        }
    }

    public function updatedStartDate($value): void
    {
        if (! $this->is_multi_day) {
            $this->end_date = $value;
        } elseif ($this->end_date && $this->end_date < $value) {
            $this->end_date = $value;
        }
        $this->syncToEventDates();
    }

    public function updatedStartTime($value): void
    {
        if ($this->has_end_time && $this->end_time && ! $this->is_multi_day) {
            if ($this->end_time <= $value) {
                try {
                    $this->end_time = \Carbon\Carbon::parse($value)->addHours(2)->format('H:i');
                } catch (\Throwable $e) {}
            }
        }
        $this->syncToEventDates();
    }

    public function updatedEndDate(): void
    {
        $this->syncToEventDates();
    }

    public function updatedEndTime(): void
    {
        $this->syncToEventDates();
    }

    public function updatedHasEndTime($value): void
    {
        if ($value) {
            if (! $this->end_time) {
                try {
                    $this->end_time = \Carbon\Carbon::parse($this->start_time ?? '08:00')->addHours(2)->format('H:i');
                } catch (\Throwable $e) {
                    $this->end_time = '12:00';
                }
            }
            if (! $this->end_date) {
                $this->end_date = $this->start_date ?: now()->format('Y-m-d');
            }
        }
        $this->syncToEventDates();
    }

    public function updatedIsMultiDay($value): void
    {
        if (! $value) {
            $this->end_date = $this->start_date;
        } elseif (! $this->end_date || $this->end_date <= $this->start_date) {
            try {
                $this->end_date = \Carbon\Carbon::parse($this->start_date ?? now())->addDay()->format('Y-m-d');
            } catch (\Throwable $e) {
                $this->end_date = now()->addDay()->format('Y-m-d');
            }
        }
        $this->syncToEventDates();
    }

    public function updatedEventDate($value): void
    {
        $this->syncFromEventDates();
    }

    public function updatedEventEndDate($value): void
    {
        $this->syncFromEventDates();
    }

    public function applyTimePreset(string $preset): void
    {
        match ($preset) {
            'morning' => [
                $this->start_time = '08:00',
                $this->end_time = '12:00',
                $this->has_end_time = true,
            ],
            'afternoon' => [
                $this->start_time = '13:00',
                $this->end_time = '17:00',
                $this->has_end_time = true,
            ],
            'whole_day' => [
                $this->start_time = '08:00',
                $this->end_time = '17:00',
                $this->has_end_time = true,
            ],
            'evening' => [
                $this->start_time = '18:00',
                $this->end_time = '21:00',
                $this->has_end_time = true,
            ],
            default => null,
        };
        $this->syncToEventDates();
    }

    public function applyDuration(int $hours): void
    {
        $base = $this->start_time ?: '08:00';
        try {
            $start = \Carbon\Carbon::parse($base);
            $this->end_time = $start->addHours($hours)->format('H:i');
            $this->has_end_time = true;
        } catch (\Throwable $e) {}
        $this->syncToEventDates();
    }

    public function setStartTimePreset(string $time): void
    {
        $this->start_time = $time;
        $this->updatedStartTime($time);
    }

    public function setEndTimePreset(string $time): void
    {
        $this->end_time = $time;
        $this->has_end_time = true;
        $this->syncToEventDates();
    }

    public function setLocationSuggestion(string $location): void
    {
        $this->event_location = $location;
    }

    public function syncToEventDates(): void
    {
        if (! $this->is_event) {
            $this->event_date = null;
            $this->event_end_date = null;
            return;
        }

        if ($this->start_date) {
            $time = $this->start_time ?: '08:00';
            $this->event_date = "{$this->start_date}T{$time}";
        }

        if ($this->has_end_time && $this->end_time) {
            $endDate = ($this->is_multi_day && $this->end_date) ? $this->end_date : $this->start_date;
            if ($endDate) {
                $this->event_end_date = "{$endDate}T{$this->end_time}";
            }
        } else {
            $this->event_end_date = null;
        }
    }

    public function syncFromEventDates(): void
    {
        if ($this->event_date) {
            try {
                $dt = \Carbon\Carbon::parse($this->event_date);
                $this->start_date = $dt->format('Y-m-d');
                $this->start_time = $dt->format('H:i');
            } catch (\Throwable $e) {}
        }

        if ($this->event_end_date) {
            try {
                $dt = \Carbon\Carbon::parse($this->event_end_date);
                $this->end_date = $dt->format('Y-m-d');
                $this->end_time = $dt->format('H:i');
                $this->has_end_time = true;
                $this->is_multi_day = ($this->start_date && $this->end_date !== $this->start_date);
            } catch (\Throwable $e) {}
        } else {
            $this->has_end_time = false;
            $this->end_date = $this->start_date;
        }
    }

    public function getTimeSlots(): array
    {
        $slots = [];
        $time = \Carbon\Carbon::createFromTime(6, 0);
        $end = \Carbon\Carbon::createFromTime(22, 0);

        while ($time->lte($end)) {
            $slots[$time->format('H:i')] = $time->format('g:i A');
            $time->addMinutes(30);
        }

        return $slots;
    }

    public function getScheduleSummary(): ?string
    {
        if (! $this->is_event || ! $this->start_date) {
            return null;
        }

        try {
            $start = \Carbon\Carbon::parse("{$this->start_date} " . ($this->start_time ?: '08:00'));
            if ($this->has_end_time && $this->end_time) {
                $endDate = ($this->is_multi_day && $this->end_date) ? $this->end_date : $this->start_date;
                $end = \Carbon\Carbon::parse("{$endDate} {$this->end_time}");

                if ($start->isSameDay($end)) {
                    $duration = $start->diffInHours($end);
                    $durationText = $duration > 0 ? " ({$duration} " . ($duration == 1 ? 'hr' : 'hrs') . ')' : '';
                    return $start->format('l, F j, Y') . ' • ' . $start->format('g:i A') . ' – ' . $end->format('g:i A') . $durationText;
                } else {
                    return $start->format('M j, Y g:i A') . ' → ' . $end->format('M j, Y g:i A');
                }
            }

            return $start->format('l, F j, Y \a\t g:i A');
        } catch (\Throwable $e) {
            return null;
        }
    }

    public function publish()
    {
        return $this->createAnnouncement();
    }

    public function createAnnouncement()
    {
        if (! Auth::check() || ! Auth::user()->isAdmin()) {
            abort(403);
        }

        if (empty($this->body) && ! empty($this->description)) {
            $this->body = $this->description;
        } elseif (empty($this->description) && ! empty($this->body)) {
            $this->description = $this->body;
        }

        if ($this->is_event) {
            if ($this->start_date) {
                $this->syncToEventDates();
            } elseif ($this->event_date) {
                $this->syncFromEventDates();
            }
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

        $this->reset([
            'title', 'body', 'description', 'type', 'is_event', 'event_date', 'event_end_date', 'event_location', 'is_pinned', 'publish_now',
            'start_date', 'start_time', 'end_date', 'end_time', 'is_multi_day', 'has_end_time'
        ]);

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
        $this->description = $a->body;
        $this->is_event = ($a->type === 'event' || ! empty($a->event_date));
        $this->type = $a->type ?? 'general';
        $this->event_date = $a->event_date ? $a->event_date->format('Y-m-d\TH:i') : null;
        $this->event_end_date = $a->event_end_date ? $a->event_end_date->format('Y-m-d\TH:i') : null;
        $this->event_location = $a->event_location;
        $this->is_pinned = (bool) $a->is_pinned;
        $this->publish_now = (bool) $a->published_at;

        $this->syncFromEventDates();
    }

    public function updateAnnouncement()
    {
        if (! Auth::check() || ! Auth::user()->isAdmin()) {
            abort(403);
        }
        if (! $this->editingId) {
            return;
        }

        if (empty($this->body) && ! empty($this->description)) {
            $this->body = $this->description;
        } elseif (empty($this->description) && ! empty($this->body)) {
            $this->description = $this->body;
        }

        if ($this->is_event) {
            if ($this->start_date) {
                $this->syncToEventDates();
            } elseif ($this->event_date) {
                $this->syncFromEventDates();
            }
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
        $this->reset([
            'title', 'body', 'description', 'type', 'is_event', 'event_date', 'event_end_date', 'event_location', 'is_pinned', 'publish_now',
            'start_date', 'start_time', 'end_date', 'end_time', 'is_multi_day', 'has_end_time'
        ]);
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
        $userIds = User::where('id', '!=', Auth::id())->pluck('id');
        if ($userIds->isEmpty()) {
            return;
        }

        $now = now();
        $payload = json_encode([
            'title' => 'New Announcement',
            'message' => $announcement->title,
            'icon' => 'megaphone',
            'url' => route('dashboard'),
        ]);

        $records = [];
        foreach ($userIds as $userId) {
            $records[] = [
                'id' => (string) Str::uuid(),
                'type' => SystemNotification::class,
                'notifiable_type' => User::class,
                'notifiable_id' => $userId,
                'data' => $payload,
                'read_at' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        // Fast chunked bulk insert
        foreach (array_chunk($records, 200) as $chunk) {
            DB::table('notifications')->insert($chunk);
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
