@php
    $roleColor = 'emerald';
    $activeNavbarGlow = 'font-bold border-b-2 border-emerald-500 text-emerald-650 dark:text-emerald-400';
    $mobileActiveGlow = 'bg-emerald-500/10 text-emerald-600 dark:bg-emerald-500/15 dark:text-emerald-400 border-l-4 border-emerald-500 font-bold';
    $sidebarBg = 'border-e border-zinc-200/50 bg-white/80 backdrop-blur-glass dark:border-zinc-800/80 dark:bg-gradient-to-b dark:from-slate-950 dark:via-zinc-950 dark:to-slate-950';
    
    if (auth()->user()->isHealthAdmin()) {
        $roleColor = 'violet';
        $activeNavbarGlow = 'font-bold border-b-2 border-violet-500 text-violet-600 dark:text-violet-400';
        $mobileActiveGlow = 'bg-violet-500/10 text-violet-600 dark:bg-violet-500/15 dark:text-violet-400 border-l-4 border-violet-500 font-bold';
    } elseif (auth()->user()->isHouseholdHead()) {
        $roleColor = 'amber';
        $activeNavbarGlow = 'font-bold border-b-2 border-amber-500 text-amber-600 dark:text-amber-450';
        $mobileActiveGlow = 'bg-amber-500/10 text-amber-600 dark:bg-amber-500/15 dark:text-amber-400 border-l-4 border-amber-500 font-bold';
    } elseif (auth()->user()->isResident()) {
        $roleColor = 'sky';
        $activeNavbarGlow = 'font-bold border-b-2 border-sky-500 text-sky-600 dark:text-sky-400';
        $mobileActiveGlow = 'bg-sky-500/10 text-sky-600 dark:bg-sky-500/15 dark:text-sky-400 border-l-4 border-sky-500 font-bold';
    }
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
        <flux:header container class="border-b border-zinc-200/50 bg-white/80 backdrop-blur-glass dark:border-zinc-800/80 dark:bg-zinc-950/80 sticky top-0 z-50">
            <flux:sidebar.toggle class="lg:hidden mr-2" icon="bars-2" inset="left" />

            <x-app-logo href="{{ route('dashboard') }}" wire:navigate />

            <flux:navbar class="-mb-px max-lg:hidden">
                <flux:navbar.item icon="globe-alt" :href="route('home')">
                    {{ __('Public Homepage') }}
                </flux:navbar.item>

                <flux:navbar.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate class="{{ request()->routeIs('dashboard') ? $activeNavbarGlow : '' }}">
                    {{ __('Dashboard') }}
                </flux:navbar.item>

                @if(auth()->user()->isAdmin())
                    <flux:dropdown position="bottom" align="start">
                        <flux:navbar.item icon="briefcase" icon-trailing="chevron-down" :current="request()->routeIs('admin.services.*') || request()->routeIs('admin.sales') || request()->routeIs('appointments')" class="{{ (request()->routeIs('admin.services.*') || request()->routeIs('admin.sales') || request()->routeIs('appointments')) ? $activeNavbarGlow : '' }}">
                            {{ __('Manage Services') }}
                        </flux:navbar.item>
                        <flux:menu class="text-xs">
                            <flux:menu.item icon="document-text" :href="route('admin.services.documents')" wire:navigate class="text-xs!">{{ __('Document Requests Registry') }}</flux:menu.item>
                            <flux:menu.item icon="building-office" :href="route('admin.services.rentals')" wire:navigate class="text-xs!">{{ __('Utility & Rentals Registry') }}</flux:menu.item>
                            <flux:menu.item icon="banknotes" :href="route('admin.sales')" wire:navigate class="text-xs!">{{ __('Sales & Revenue Report') }}</flux:menu.item>
                        </flux:menu>
                    </flux:dropdown>

                    <flux:navbar.item icon="users" :href="route('rbi')" :current="request()->routeIs('rbi')" wire:navigate class="{{ request()->routeIs('rbi') ? $activeNavbarGlow : '' }}">
                        {{ __('Population') }}
                    </flux:navbar.item>
                    <flux:navbar.item icon="megaphone" :href="route('admin.announcements')" :current="request()->routeIs('admin.announcements')" wire:navigate class="{{ request()->routeIs('admin.announcements') ? $activeNavbarGlow : '' }}">
                        {{ __('Announcements') }}
                    </flux:navbar.item>
                @endif

                @if(auth()->user()->isHealthAdmin())
                    <flux:navbar.item icon="heart" :href="route('health')" :current="request()->routeIs('health')" wire:navigate class="{{ request()->routeIs('health') ? $activeNavbarGlow : '' }}">
                        {{ __('Health-based Data') }}
                    </flux:navbar.item>
                @endif

                @if(auth()->user()->isHouseholdHead())
                    <flux:navbar.item icon="users" :href="route('household')" :current="request()->routeIs('household')" wire:navigate class="{{ request()->routeIs('household') ? $activeNavbarGlow : '' }}">
                        {{ __('My Household') }}
                    </flux:navbar.item>
                @endif

                @if(auth()->user()->isHouseholdHead() || auth()->user()->isResident())
                    <flux:dropdown position="bottom" align="start">
                        <flux:navbar.item icon="briefcase" icon-trailing="chevron-down" :current="request()->routeIs('services.*')" class="{{ request()->routeIs('services.*') ? $activeNavbarGlow : '' }}">
                            {{ __('Barangay Services') }}
                        </flux:navbar.item>
                        <flux:menu class="text-xs">
                            <flux:menu.item icon="document-text" :href="route('services.documents')" wire:navigate class="text-xs!">{{ __('Request Documents') }}</flux:menu.item>
                            <flux:menu.item icon="building-office" :href="route('services.rentals')" wire:navigate class="text-xs!">{{ __('Book Utility Rentals') }}</flux:menu.item>
                        </flux:menu>
                    </flux:dropdown>
                @endif
            </flux:navbar>

            <flux:spacer />

            <flux:navbar class="me-1.5 space-x-0.5 rtl:space-x-reverse py-0!">
                <livewire:notifications-dropdown />
                <flux:tooltip :content="__('Search')" position="bottom">
                    <flux:navbar.item class="!h-10 [&>div>svg]:size-5" icon="magnifying-glass" href="#" :label="__('Search')" />
                </flux:tooltip>
            </flux:navbar>

            <x-desktop-user-menu />
        </flux:header>

        <!-- Mobile Menu -->
        <flux:sidebar collapsible="mobile" sticky class="lg:hidden {{ $sidebarBg }}">
            <flux:sidebar.header>
                <x-app-logo :sidebar="true" href="{{ route('dashboard') }}" wire:navigate />
                <flux:sidebar.collapse class="in-data-flux-sidebar-on-desktop:not-in-data-flux-sidebar-collapsed-desktop:-mr-2" />
            </flux:sidebar.header>

            <flux:sidebar.nav>
                <flux:sidebar.group :heading="__('Platform')">
                    <flux:sidebar.item icon="globe-alt" :href="route('home')">
                        {{ __('Public Homepage') }}
                    </flux:sidebar.item>

                    <flux:sidebar.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate class="{{ request()->routeIs('dashboard') ? $mobileActiveGlow : '' }}">
                        {{ __('Dashboard')  }}
                    </flux:sidebar.item>

                    @if(auth()->user()->isAdmin())
                        <flux:sidebar.group expandable icon="briefcase" :heading="__('Manage Services')" :expanded="request()->routeIs('admin.services.*') || request()->routeIs('admin.sales') || request()->routeIs('appointments')">
                            <flux:sidebar.item icon="document-text" :href="route('admin.services.documents')" :current="request()->routeIs('admin.services.documents') || request()->routeIs('appointments')" wire:navigate class="{{ (request()->routeIs('admin.services.documents') || request()->routeIs('appointments')) ? $mobileActiveGlow : '' }}">
                                {{ __('Document Requests') }}
                            </flux:sidebar.item>
                            <flux:sidebar.item icon="building-office" :href="route('admin.services.rentals')" :current="request()->routeIs('admin.services.rentals')" wire:navigate class="{{ request()->routeIs('admin.services.rentals') ? $mobileActiveGlow : '' }}">
                                {{ __('Utility & Rentals') }}
                            </flux:sidebar.item>
                            <flux:sidebar.item icon="banknotes" :href="route('admin.sales')" :current="request()->routeIs('admin.sales')" wire:navigate class="{{ request()->routeIs('admin.sales') ? $mobileActiveGlow : '' }}">
                                {{ __('Sales & Revenue') }}
                            </flux:sidebar.item>
                        </flux:sidebar.group>

                        <flux:sidebar.item icon="users" :href="route('rbi')" :current="request()->routeIs('rbi')" wire:navigate class="{{ request()->routeIs('rbi') ? $mobileActiveGlow : '' }}">
                            {{ __('Population Management') }}
                        </flux:sidebar.item>
                        <flux:sidebar.item icon="megaphone" :href="route('admin.announcements')" :current="request()->routeIs('admin.announcements')" wire:navigate class="{{ request()->routeIs('admin.announcements') ? $mobileActiveGlow : '' }}">
                            {{ __('Announcements & Events') }}
                        </flux:sidebar.item>
                    @endif

                    @if(auth()->user()->isHealthAdmin())
                        <flux:sidebar.item icon="heart" :href="route('health')" :current="request()->routeIs('health')" wire:navigate class="{{ request()->routeIs('health') ? $mobileActiveGlow : '' }}">
                            {{ __('Health-based Data') }}
                        </flux:sidebar.item>
                        <flux:sidebar.item icon="pencil-square" :href="route('health.edit')" :current="request()->routeIs('health.edit')" wire:navigate class="{{ request()->routeIs('health.edit') ? $mobileActiveGlow : '' }}">
                            {{ __('Update Health Records') }}
                        </flux:sidebar.item>
                    @endif

                    @if(auth()->user()->isHouseholdHead())
                        <flux:sidebar.item icon="users" :href="route('household')" :current="request()->routeIs('household')" wire:navigate class="{{ request()->routeIs('household') ? $mobileActiveGlow : '' }}">
                            {{ __('My Household') }}
                        </flux:sidebar.item>
                    @endif

                    @if(auth()->user()->isHouseholdHead() || auth()->user()->isResident())
                        <flux:sidebar.group expandable icon="briefcase" :heading="__('Barangay Services')" :expanded="request()->routeIs('services.*')">
                            <flux:sidebar.item icon="document-text" :href="route('services.documents')" :current="request()->routeIs('services.documents')" wire:navigate class="text-xs! {{ request()->routeIs('services.documents') ? $mobileActiveGlow : '' }}">
                                {{ __('Request Documents') }}
                            </flux:sidebar.item>
                            <flux:sidebar.item icon="building-office" :href="route('services.rentals')" :current="request()->routeIs('services.rentals')" wire:navigate class="text-xs! {{ request()->routeIs('services.rentals') ? $mobileActiveGlow : '' }}">
                                {{ __('Book Utility Rentals') }}
                            </flux:sidebar.item>
                        </flux:sidebar.group>
                    @endif
                </flux:sidebar.group>
            </flux:sidebar.nav>

            <flux:spacer />
        </flux:sidebar>

        {{ $slot }}

        @persist('toast')
            <flux:toast.group>
                <flux:toast />
            </flux:toast.group>
        @endpersist

        @fluxScripts
    </body>
</html>
