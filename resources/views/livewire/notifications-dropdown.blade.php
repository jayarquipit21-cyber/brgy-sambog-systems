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

        <flux:menu class="w-80 sm:w-96 p-0! overflow-hidden">
            <div class="px-4 py-3 border-b border-zinc-200 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800 flex justify-between items-center">
                <flux:heading class="font-bold">Notifications</flux:heading>
                @if($unreadCount > 0)
                    <button wire:click="markAllAsRead" class="text-xs text-emerald-600 dark:text-emerald-400 hover:underline">
                        Mark all as read
                    </button>
                @endif
            </div>

            <div class="max-h-96 overflow-y-auto">
                @forelse($notifications as $notification)
                    <div class="flex gap-3 px-4 py-3 border-b border-zinc-100 dark:border-zinc-700/50 hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition relative {{ is_null($notification->read_at) ? 'bg-zinc-50/50 dark:bg-zinc-800/30' : '' }}">
                        @if(is_null($notification->read_at))
                            <div class="absolute left-0 top-0 bottom-0 w-0.5 bg-emerald-500"></div>
                        @endif

                        <div class="flex-shrink-0 mt-1">
                            <div class="p-2 bg-emerald-100 dark:bg-emerald-500/20 text-emerald-600 dark:text-emerald-400 rounded-full">
                                <flux:icon name="{{ $notification->data['icon'] ?? 'bell' }}" class="size-4" />
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
                                <a href="{{ $notification->data['url'] }}" class="text-[11px] font-bold text-emerald-600 dark:text-emerald-400 mt-1.5 inline-block hover:underline">
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
        console.log('NotificationsDropdown: Starting Echo listener setup for user', userId);

        function setupEchoListener() {
            if (typeof window.Echo === 'undefined') {
                console.log('NotificationsDropdown: window.Echo is not ready yet, retrying in 300ms...');
                setTimeout(setupEchoListener, 300);
                return;
            }

            console.log('NotificationsDropdown: window.Echo is ready! Subscribing to private channel: App.Models.User.' + userId);
            window.Echo
                .private('App.Models.User.' + userId)
                .error(function(error) {
                    console.error('NotificationsDropdown: Echo subscription error:', error);
                })
                .subscribed(function() {
                    console.log('NotificationsDropdown: Successfully subscribed to channel!');
                })
                .notification(function (notification) {
                    console.log('NotificationsDropdown: Received real-time notification!', notification);
                    $wire.loadNotifications();
                })
                .listen('.App\\Events\\TestPusherEvent', function(e) {
                    console.log('NotificationsDropdown: TestPusherEvent received!', e);
                });

            window.Echo.connector.pusher.bind_global(function(eventName, data) {
                console.log('--- GLOBAL PUSHER EVENT ---', eventName, data);
            });
        }

        setupEchoListener();
    })();
</script>
@endscript
</div>
