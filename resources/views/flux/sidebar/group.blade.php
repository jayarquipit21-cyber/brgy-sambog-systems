@blaze(fold: true, unsafe: ['icon:trailing', 'icon:variant'])

@php $iconTrailing ??= $attributes->pluck('icon:trailing'); @endphp
@php $iconVariant ??= $attributes->pluck('icon:variant'); @endphp

@props([
    'iconVariant' => 'outline',
    'iconTrailing' => null,
    'expandable' => false,
    'expanded' => true,
    'heading' => null,
    'icon' => null,
    'current' => false,
])

<?php if ($expandable && $heading): ?>
    <?php if ($icon): ?>
        <ui-disclosure {{ $attributes->class('group/disclosure in-data-flux-sidebar-collapsed-desktop:hidden') }} @if ($expanded === true) open @endif data-flux-sidebar-group>
            <button type="button" class="border border-transparent w-full h-10 in-data-flux-sidebar-on-mobile:h-10 flex items-center gap-3 px-3 py-2 my-1 rounded-xl transition-all duration-150 group/disclosure-button text-zinc-400 hover:text-white dark:text-white/80 dark:hover:text-white hover:bg-zinc-800/5 dark:hover:bg-white/[7%] @if($current) bg-white/5 dark:bg-white/[7%] text-white font-bold @endif">
                <div class="relative flex items-center justify-center shrink-0">
                    <?php if (is_string($icon) && $icon !== ''): ?>
                        <flux:icon :icon="$icon" :variant="$iconVariant" class="size-5 text-zinc-400 group-hover/disclosure-button:text-white" />
                    <?php else: ?>
                        {{ $icon }}
                    <?php endif; ?>
                </div>

                <span class="flex-1 text-left rtl:text-right text-sm font-semibold leading-none truncate">{{ $heading }}</span>

                <div class="ms-auto flex items-center text-zinc-400 group-hover/disclosure-button:text-white">
                    <flux:icon.chevron-down class="size-4 hidden group-data-open/disclosure-button:block" />
                    <flux:icon.chevron-right class="size-4 block group-data-open/disclosure-button:hidden rtl:rotate-180" />
                </div>
            </button>

            <div class="relative hidden data-open:block ps-6 my-1" @if ($expanded === true) data-open @endif>
                <div class="absolute inset-y-[3px] w-px bg-zinc-200 dark:bg-zinc-700/60 start-0 ms-4"></div>

                <div class="flex flex-col space-y-1">
                    {{ $slot }}
                </div>
            </div>
        </ui-disclosure>

        <flux:dropdown hover class="in-data-flux-sidebar-on-mobile:hidden not-in-data-flux-sidebar-collapsed-desktop:hidden" position="right" align="start" data-flux-sidebar-group-dropdown>
            <button type="button" class="border border-transparent w-full px-3 h-10 flex gap-3 items-center group/disclosure-button my-1 rounded-xl hover:bg-zinc-800/5 dark:hover:bg-white/[7%] text-zinc-400 dark:text-white/80">
                <?php if ($icon): ?>
                    <div class="relative flex items-center justify-center shrink-0">
                        <?php if (is_string($icon) && $icon !== ''): ?>
                            <flux:icon :icon="$icon" :variant="$iconVariant" class="size-5 text-zinc-400" />
                        <?php else: ?>
                            {{ $icon }}
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <span class="hidden in-data-flux-menu:block flex-1 text-start text-sm font-semibold leading-none text-zinc-800 dark:text-white">{{ $heading }}</span>

                <div class="hidden in-data-flux-menu:block">
                    <flux:icon.chevron-right :variant="$iconVariant" class="ms-auto size-4 text-zinc-400 rtl:hidden" />
                    <flux:icon.chevron-left :variant="$iconVariant" class="ms-auto size-4 text-zinc-400 hidden rtl:inline" />
                </div>
            </button>

            <flux:menu>
                <flux:menu.group :$heading>
                    {{ $slot }}
                </flux:menu.group>
            </flux:menu>
        </flux:dropdown>
    <?php else: ?>
        <ui-disclosure {{ $attributes->class('group/disclosure in-data-flux-sidebar-collapsed-desktop:hidden') }} @if ($expanded === true) open @endif data-flux-sidebar-group>
            <button type="button" class="border border-transparent w-full h-10 in-data-flux-sidebar-on-mobile:h-10 flex items-center gap-3 px-3 py-2 my-1 rounded-xl transition-all duration-150 group/disclosure-button text-zinc-400 hover:text-white dark:text-white/80 dark:hover:text-white hover:bg-zinc-800/5 dark:hover:bg-white/[7%] @if($current) bg-white/5 dark:bg-white/[7%] text-white font-bold @endif">
                <span class="flex-1 text-left rtl:text-right text-sm font-semibold leading-none truncate">{{ $heading }}</span>

                <div class="ms-auto flex items-center text-zinc-400 group-hover/disclosure-button:text-white">
                    <flux:icon.chevron-down class="size-4 hidden group-data-open/disclosure-button:block" />
                    <flux:icon.chevron-right class="size-4 block group-data-open/disclosure-button:hidden rtl:rotate-180" />
                </div>
            </button>

            <div class="relative hidden data-open:block ps-6 my-1" @if ($expanded === true) data-open @endif>
                <div class="absolute inset-y-[3px] w-px bg-zinc-200 dark:bg-zinc-700/60 start-0 ms-4"></div>

                <div class="flex flex-col space-y-1">
                    {{ $slot }}
                </div>
            </div>
        </ui-disclosure>
    <?php endif; ?>

<?php elseif ($heading): ?>
    <div {{ $attributes->class('flex flex-col in-data-flux-sidebar-collapsed-desktop:hidden') }} data-flux-sidebar-group>
        <div class="px-3 py-2">
            <div class="text-xs text-zinc-400 font-bold uppercase tracking-wider leading-none">{{ $heading }}</div>
        </div>

        <div class="flex flex-col space-y-1">
            {{ $slot }}
        </div>
    </div>
<?php else: ?>
    <div {{ $attributes->class('flex flex-col in-data-flux-sidebar-collapsed-desktop:hidden') }} data-flux-sidebar-group>
        {{ $slot }}
    </div>
<?php endif; ?>
