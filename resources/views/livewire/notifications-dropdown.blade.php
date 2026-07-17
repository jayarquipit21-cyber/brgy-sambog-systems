<div>
    <flux:dropdown position="bottom" align="end">
        <flux:button variant="ghost" class="relative !px-2" icon="bell" aria-label="Notifications">
            @if($unreadCount > 0)
                <span class="absolute top-1.5 right-1.5 flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-red-500"></span>
                </span>
            @endif
        </flux:button>

        <flux:menu class="w-80 sm:w-96 p-0! overflow-hidden card-glow-admin">
            <div class="px-4 py-3 border-b border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800 flex justify-between items-center relative">
                <!-- Slim premium top border stripe -->
                <div class="absolute top-0 inset-x-0 h-1 bg-gradient-to-r from-emerald-500 via-teal-500 to-indigo-500"></div>
                <flux:heading class="font-bold font-outfit">Notifications</flux:heading>
                @if($unreadCount > 0)
                    <button wire:click="markAllAsRead" class="text-xs text-emerald-650 dark:text-emerald-450 hover:underline font-bold">
                        Mark all as read
                    </button>
                @endif
            </div>

            <div class="max-h-96 overflow-y-auto">
                @forelse($notifications as $notification)
                    @php
                        $notifBrand = 'bg-emerald-500';
                        $notifBadge = 'bg-emerald-100 dark:bg-emerald-500/20 text-emerald-600 dark:text-emerald-400';
                        $notifIcon = $notification->data['icon'] ?? 'bell';
                        
                        if ($notifIcon === 'heart') {
                            $notifBrand = 'bg-violet-500';
                            $notifBadge = 'bg-violet-100 dark:bg-violet-500/20 text-violet-600 dark:text-violet-400';
                        } elseif ($notifIcon === 'calendar') {
                            $notifBrand = 'bg-amber-500';
                            $notifBadge = 'bg-amber-100 dark:bg-amber-500/20 text-amber-600 dark:text-amber-400';
                        } elseif ($notifIcon === 'megaphone' || $notifIcon === 'bookmark') {
                            $notifBrand = 'bg-sky-500';
                            $notifBadge = 'bg-sky-100 dark:bg-sky-500/20 text-sky-605 dark:text-sky-400';
                        }
                    @endphp
                    <div class="flex gap-3 px-4 py-3 border-b border-zinc-100 dark:border-zinc-700/50 hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition relative {{ is_null($notification->read_at) ? 'bg-zinc-50/50 dark:bg-zinc-800/30' : '' }}">
                        @if(is_null($notification->read_at))
                            <div class="absolute left-0 top-0 bottom-0 w-0.5 {{ $notifBrand }}"></div>
                        @endif

                        <div class="flex-shrink-0 mt-1">
                            <div class="p-2 {{ $notifBadge }} rounded-full">
                                <flux:icon name="{{ $notifIcon }}" class="size-4" />
                            </div>
                        </div>

                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-zinc-900 dark:text-white truncate">
                                {{ $notification->data['title'] ?? 'Notification' }}
                            </p>
                            <p class="text-xs text-zinc-500 dark:text-zinc-400 line-clamp-2 mt-0.5">
                                {{ $notification->data['message'] ?? '' }}
                            </p>
                            <p class="text-[10px] text-zinc-400 dark:text-zinc-500 mt-1">
                                {{ $notification->created_at->diffForHumans() }}
                            </p>

                            @if(isset($notification->data['url']))
                                <a href="{{ $notification->data['url'] }}" class="text-[11px] font-bold text-emerald-650 dark:text-emerald-450 mt-1.5 inline-block hover:underline">
                                    View Details &rarr;
                                </a>
                            @endif
                        </div>

                        @if(is_null($notification->read_at))
                            <div class="flex-shrink-0 flex items-start">
                                <button wire:click.stop="markAsRead('{{ $notification->id }}')" class="text-zinc-400 hover:text-emerald-600 dark:hover:text-emerald-400" title="Mark as read">
                                    <flux:icon name="check-circle" class="size-4" />
                                </button>
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="px-4 py-8 text-center">
                        <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-zinc-100 dark:bg-zinc-800 text-zinc-400 mb-3">
                            <flux:icon name="bell-snooze" class="size-6" />
                        </div>
                        <p class="text-sm text-zinc-500 dark:text-zinc-400 font-medium">You're all caught up!</p>
                        <p class="text-xs text-zinc-400 dark:text-zinc-500 mt-1">No new notifications right now.</p>
                    </div>
                @endforelse
            </div>

            @if($notifications->count() > 0)
                <div class="p-2 bg-zinc-50 dark:bg-zinc-800 border-t border-zinc-200 dark:border-zinc-700 text-center">
                    <a href="#" class="text-xs font-semibold text-zinc-600 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-white transition">
                        View all notifications
                    </a>
                </div>
            @endif
        </flux:menu>
    </flux:dropdown>

@script
<script>
    (function () {
        const userId = {{ auth()->id() ?? 'null' }};
        if (!userId) return;

        function setupEchoListener() {
            if (typeof window.Echo === 'undefined') {
                setTimeout(setupEchoListener, 300);
                return;
            }

            window.Echo
                .private('App.Models.User.' + userId)
                .notification(function (notification) {
                    $wire.loadNotifications();
                });
        }

        setupEchoListener();
    })();
</script>
@endscript
</div>
