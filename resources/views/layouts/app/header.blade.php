<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
        <flux:header container class="border-b border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.toggle class="lg:hidden mr-2" icon="bars-2" inset="left" />

            <x-app-logo href="{{ route('dashboard') }}" wire:navigate />

            <flux:navbar class="-mb-px max-lg:hidden">
                <flux:navbar.item icon="globe-alt" :href="route('home')">
                    {{ __('Public Homepage') }}
                </flux:navbar.item>

                <flux:navbar.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>
                    {{ __('Dashboard') }}
                </flux:navbar.item>

                @if(auth()->user()->isAdmin())
                    <flux:navbar.item icon="users" :href="route('rbi')" :current="request()->routeIs('rbi')" wire:navigate>
                        {{ __('Population Management') }}
                    </flux:navbar.item>
                    <flux:navbar.item icon="calendar" :href="route('appointments')" :current="request()->routeIs('appointments')" wire:navigate>
                        {{ __('Manage Appointments') }}
                    </flux:navbar.item>
                    <flux:navbar.item icon="megaphone" :href="route('admin.announcements')" :current="request()->routeIs('admin.announcements')" wire:navigate>
                        {{ __('Announcements & Events') }}
                    </flux:navbar.item>
                @endif

                @if(auth()->user()->isHealthAdmin())
                    <flux:navbar.item icon="heart" :href="route('health')" :current="request()->routeIs('health')" wire:navigate>
                        {{ __('Health Concerns') }}
                    </flux:navbar.item>
                @endif

                @if(auth()->user()->isHouseholdHead())
                    <flux:navbar.item icon="users" :href="route('household')" :current="request()->routeIs('household')" wire:navigate>
                        {{ __('My Household') }}
                    </flux:navbar.item>
                @endif

                @if(auth()->user()->isHouseholdHead() || auth()->user()->isResident())
                    <flux:navbar.item icon="calendar" :href="route('appointments')" :current="request()->routeIs('appointments')" wire:navigate>
                        {{ __('Book & Appointments') }}
                    </flux:navbar.item>
                @endif
            </flux:navbar>

            <flux:spacer />

            <flux:navbar class="me-1.5 space-x-0.5 rtl:space-x-reverse py-0!">
                <livewire:notifications-dropdown />
                <flux:tooltip :content="__('Search')" position="bottom">
                    <flux:navbar.item class="!h-10 [&>div>svg]:size-5" icon="magnifying-glass" href="#" :label="__('Search')" />
                </flux:tooltip>
                <flux:tooltip :content="__('Repository')" position="bottom">
                    <flux:navbar.item
                        class="h-10 max-lg:hidden [&>div>svg]:size-5"
                        icon="folder-open"
                        href="https://github.com/jayarquipit21-cyber/brgy-sambog-systems"
                        target="_blank"
                        :label="__('Repository')"
                    />
                </flux:tooltip>
                <flux:tooltip :content="__('Documentation')" position="bottom">
                    <flux:navbar.item
                        class="h-10 max-lg:hidden [&>div>svg]:size-5"
                        icon="book-open-text"
                        href="#"
                        :label="__('Documentation')"
                    />
                </flux:tooltip>
            </flux:navbar>

            <x-desktop-user-menu />
        </flux:header>

        <!-- Mobile Menu -->
        <flux:sidebar collapsible="mobile" sticky class="lg:hidden border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.header>
                <x-app-logo :sidebar="true" href="{{ route('dashboard') }}" wire:navigate />
                <flux:sidebar.collapse class="in-data-flux-sidebar-on-desktop:not-in-data-flux-sidebar-collapsed-desktop:-mr-2" />
            </flux:sidebar.header>

            <flux:sidebar.nav>
                <flux:sidebar.group :heading="__('Platform')">
                    <flux:sidebar.item icon="globe-alt" :href="route('home')">
                        {{ __('Public Homepage') }}
                    </flux:sidebar.item>

                    <flux:sidebar.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>
                        {{ __('Dashboard')  }}
                    </flux:sidebar.item>

                    @if(auth()->user()->isAdmin())
                        <flux:sidebar.item icon="users" :href="route('rbi')" :current="request()->routeIs('rbi')" wire:navigate>
                            {{ __('Population Management') }}
                        </flux:sidebar.item>
                        <flux:sidebar.item icon="calendar" :href="route('appointments')" :current="request()->routeIs('appointments')" wire:navigate>
                            {{ __('Manage Appointments') }}
                        </flux:sidebar.item>
                        <flux:sidebar.item icon="megaphone" :href="route('admin.announcements')" :current="request()->routeIs('admin.announcements')" wire:navigate>
                            {{ __('Announcements & Events') }}
                        </flux:sidebar.item>
                    @endif

                    @if(auth()->user()->isHealthAdmin())
                        <flux:sidebar.item icon="heart" :href="route('health')" :current="request()->routeIs('health')" wire:navigate>
                            {{ __('Health Concerns') }}
                        </flux:sidebar.item>
                    @endif

                    @if(auth()->user()->isHouseholdHead())
                        <flux:sidebar.item icon="users" :href="route('household')" :current="request()->routeIs('household')" wire:navigate>
                            {{ __('My Household') }}
                        </flux:sidebar.item>
                    @endif

                    @if(auth()->user()->isHouseholdHead() || auth()->user()->isResident())
                        <flux:sidebar.item icon="calendar" :href="route('appointments')" :current="request()->routeIs('appointments')" wire:navigate>
                            {{ __('Book & Appointments') }}
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
