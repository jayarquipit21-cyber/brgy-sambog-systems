@php
    $roleColor = 'emerald';
    $roleClass = 'stripe-left-admin card-glow-admin';
    $roleBadgeColor = 'emerald-500';
    $activeGlow = 'bg-emerald-500/10 text-emerald-600 dark:bg-emerald-500/15 dark:text-emerald-400 border-l-4 border-emerald-500 font-bold';
    $sidebarBg = 'border-e border-zinc-200/50 bg-white/80 backdrop-blur-glass dark:border-zinc-800/80 dark:bg-gradient-to-b dark:from-slate-950 dark:via-zinc-950 dark:to-slate-950';
    
    if (auth()->user()->isHealthAdmin()) {
        $roleColor = 'violet';
        $roleClass = 'stripe-left-health card-glow-health';
        $roleBadgeColor = 'violet-500';
        $activeGlow = 'bg-violet-500/10 text-violet-600 dark:bg-violet-500/15 dark:text-violet-400 border-l-4 border-violet-500 font-bold';
    } elseif (auth()->user()->isHouseholdHead()) {
        $roleColor = 'amber';
        $roleClass = 'stripe-left-household card-glow-household';
        $roleBadgeColor = 'amber-500';
        $activeGlow = 'bg-amber-500/10 text-amber-600 dark:bg-amber-500/15 dark:text-amber-400 border-l-4 border-amber-500 font-bold';
    } elseif (auth()->user()->isResident()) {
        $roleColor = 'sky';
        $roleClass = 'stripe-left-resident card-glow-resident';
        $roleBadgeColor = 'sky-500';
        $activeGlow = 'bg-sky-500/10 text-sky-600 dark:bg-sky-500/15 dark:text-sky-400 border-l-4 border-sky-500 font-bold';
    }
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
        <flux:sidebar sticky collapsible="mobile" class="{{ $sidebarBg }}">
            <flux:sidebar.header>
                <x-app-logo :sidebar="true" href="{{ route('dashboard') }}" wire:navigate />
                <flux:sidebar.collapse class="lg:hidden" />
            </flux:sidebar.header>

            <flux:sidebar.nav>
                <flux:sidebar.group :heading="__('Platform')" class="grid">
                    <flux:sidebar.item icon="globe-alt" :href="route('home')">
                        {{ __('Public Homepage') }}
                    </flux:sidebar.item>

                    <flux:sidebar.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate class="{{ request()->routeIs('dashboard') ? $activeGlow : '' }}">
                        {{ __('Dashboard') }}
                    </flux:sidebar.item>

                    @if(auth()->user()->isAdmin())
                        <flux:sidebar.item icon="users" :href="route('rbi')" :current="request()->routeIs('rbi')" wire:navigate class="{{ request()->routeIs('rbi') ? $activeGlow : '' }}">
                            {{ __('Population Management') }}
                        </flux:sidebar.item>
                        <flux:sidebar.item icon="table-cells" :href="route('rbi-data')" :current="request()->routeIs('rbi-data')" wire:navigate class="{{ request()->routeIs('rbi-data') ? $activeGlow : '' }}">
                            {{ __('RBI Data Table') }}
                        </flux:sidebar.item>
                        <flux:sidebar.item icon="calendar" :href="route('appointments')" :current="request()->routeIs('appointments')" wire:navigate class="{{ request()->routeIs('appointments') ? $activeGlow : '' }}">
                            {{ __('Appointments & Rentals') }}
                        </flux:sidebar.item>
                        <flux:sidebar.item icon="megaphone" :href="route('admin.announcements')" :current="request()->routeIs('admin.announcements')" wire:navigate class="{{ request()->routeIs('admin.announcements') ? $activeGlow : '' }}">
                            {{ __('Announcements & Events') }}
                        </flux:sidebar.item>
                        <flux:sidebar.item icon="shield-exclamation" :href="route('admin.blotters')" :current="request()->routeIs('admin.blotters')" wire:navigate class="{{ request()->routeIs('admin.blotters') ? $activeGlow : '' }}">
                            {{ __('Blotter & Lupon') }}
                        </flux:sidebar.item>
                    @endif

                    @if(auth()->user()->isHealthAdmin())
                        <flux:sidebar.item icon="heart" :href="route('health')" :current="request()->routeIs('health')" wire:navigate class="{{ request()->routeIs('health') ? $activeGlow : '' }}">
                            {{ __('Health Concerns') }}
                        </flux:sidebar.item>
                    @endif

                    @if(auth()->user()->isHouseholdHead())
                        <flux:sidebar.item icon="users" :href="route('household')" :current="request()->routeIs('household')" wire:navigate class="{{ request()->routeIs('household') ? $activeGlow : '' }}">
                            {{ __('My Household') }}
                        </flux:sidebar.item>
                    @endif

                    @if(auth()->user()->isHouseholdHead() || auth()->user()->isResident())
                        <flux:sidebar.item icon="calendar" :href="route('appointments')" :current="request()->routeIs('appointments')" wire:navigate class="{{ request()->routeIs('appointments') ? $activeGlow : '' }}">
                            {{ __('Bookings & Rentals') }}
                        </flux:sidebar.item>
                    @endif

                    @if(auth()->user()->isResident() || auth()->user()->isHouseholdHead())
                        <flux:sidebar.item icon="identification" :href="route('profile.complete')" :current="request()->routeIs('profile.complete')" wire:navigate class="{{ request()->routeIs('profile.complete') ? $activeGlow : '' }}">
                            {{ __('Complete My Profile') }}
                            @if(!auth()->user()->resident?->place_of_birth)
                                <span class="ml-auto inline-flex h-2 w-2 rounded-full bg-amber-400 animate-pulse"></span>
                            @endif
                        </flux:sidebar.item>
                    @endif
                </flux:sidebar.group>
            </flux:sidebar.nav>

            <flux:spacer />

            <flux:sidebar.nav>
                <flux:sidebar.item icon="folder-open" href="https://github.com/jayarquipit21-cyber/brgy-sambog-systems" target="_blank">
                    {{ __('Repository') }}
                </flux:sidebar.item>

                <flux:sidebar.item icon="book-open-text" href="#">
                    {{ __('Documentation') }}
                </flux:sidebar.item>
            </flux:sidebar.nav>

            <div class="hidden lg:flex items-center gap-2 mt-auto p-2.5 bg-zinc-50/50 border border-zinc-200/60 dark:bg-zinc-950/40 dark:border-zinc-800/80 rounded-2xl shadow-sm">
                <div class="flex-1 min-w-0">
                    <x-desktop-user-menu :name="auth()->user()->name" />
                </div>
                <livewire:notifications-dropdown />
            </div>
        </flux:sidebar>

        <!-- Mobile User Menu -->
        <flux:header class="lg:hidden">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

            <flux:spacer />

            <div class="flex items-center gap-1">
                <livewire:notifications-dropdown />
                
                <flux:dropdown position="top" align="end">
                    <flux:profile
                        :initials="auth()->user()->initials()"
                        icon-trailing="chevron-down"
                    />

                <flux:menu>
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <flux:avatar
                                    :name="auth()->user()->name"
                                    :initials="auth()->user()->initials()"
                                />

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <flux:heading class="truncate">{{ auth()->user()->name }}</flux:heading>
                                    <flux:text class="truncate">{{ auth()->user()->email }}</flux:text>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>
                            {{ __('Settings') }}
                        </flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item
                            as="button"
                            type="submit"
                            icon="arrow-right-start-on-rectangle"
                            class="w-full cursor-pointer"
                            data-test="logout-button"
                        >
                            {{ __('Log out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
            </div>
        </flux:header>

        {{ $slot }}

        @persist('toast')
            <flux:toast.group>
                <flux:toast />
            </flux:toast.group>
        @endpersist

        @fluxScripts
    </body>
</html>
