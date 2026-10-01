@props([
    'sidebar' => false,
])

@php
    $appName = config('app.name', 'Brgy. Sambog');
@endphp

@if($sidebar)
    <flux:sidebar.brand :name="$appName" {{ $attributes }}>
        <x-slot name="logo" class="flex aspect-square size-8 items-center justify-center">
            <img src="{{ asset('images/logo.png') }}" alt="{{ $appName }} Official Seal" class="size-8 object-contain rounded-full drop-shadow-xs" />
        </x-slot>
    </flux:sidebar.brand>
@else
    <flux:brand :name="$appName" {{ $attributes }}>
        <x-slot name="logo" class="flex aspect-square size-8 items-center justify-center">
            <img src="{{ asset('images/logo.png') }}" alt="{{ $appName }} Official Seal" class="size-8 object-contain rounded-full drop-shadow-xs" />
        </x-slot>
    </flux:brand>
@endif

