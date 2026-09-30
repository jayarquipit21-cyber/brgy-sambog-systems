@props([
    'sidebar' => false,
])

@php
    $appName = config('app.name', 'Brgy. Sambog');
@endphp

@if($sidebar)
    <flux:sidebar.brand :name="$appName" {{ $attributes }}>
        <x-slot name="logo" class="flex aspect-square size-8 items-center justify-center rounded-lg bg-gradient-to-br from-emerald-500 to-teal-600 text-white font-black text-xs shadow-sm font-outfit">
            <span class="tracking-tight font-extrabold text-white select-none">BS</span>
        </x-slot>
    </flux:sidebar.brand>
@else
    <flux:brand :name="$appName" {{ $attributes }}>
        <x-slot name="logo" class="flex aspect-square size-8 items-center justify-center rounded-lg bg-gradient-to-br from-emerald-500 to-teal-600 text-white font-black text-xs shadow-sm font-outfit">
            <span class="tracking-tight font-extrabold text-white select-none">BS</span>
        </x-slot>
    </flux:brand>
@endif

