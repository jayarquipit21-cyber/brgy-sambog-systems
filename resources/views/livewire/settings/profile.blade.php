<div class="max-w-6xl mx-auto space-y-8 pb-16 font-sans">
    <!-- Top Hero / Profile Header Card -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-zinc-900 via-zinc-900 to-zinc-950 text-white p-6 sm:p-8 border border-zinc-800 shadow-2xl">
        <div class="absolute -right-16 -top-16 w-80 h-80 bg-sky-500/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -left-16 -bottom-16 w-80 h-80 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>

        <div x-data="{ 
                 localPreview: null,
                 showPhotoModal: false,
                 handleFileChange(e) {
                     const file = e.target.files[0];
                     if (file) {
                         this.localPreview = URL.createObjectURL(file);
                     }
                 },
                 clear() {
                     this.localPreview = null;
                     $wire.cancelAvatarUpload();
                 },
                 triggerFileInput() {
                     document.getElementById('avatar-file-input').click();
                 }
             }"
             x-on:avatar-saved.window="localPreview = null"
             class="relative flex flex-col sm:flex-row items-center sm:items-start gap-6 z-10">
            <!-- Avatar Area (Click to view full photo) -->
            <div class="relative group shrink-0 flex flex-col items-center">
                <button type="button" 
                        @click="showPhotoModal = true"
                        class="size-28 sm:size-32 rounded-3xl overflow-hidden ring-4 {{ $avatarFile ? 'ring-amber-400 ring-offset-2 ring-offset-zinc-900 shadow-amber-500/30' : 'ring-white/10 hover:ring-white/30' }} shadow-2xl bg-gradient-to-tr from-zinc-800 to-zinc-700 flex items-center justify-center relative transition-all duration-300 cursor-pointer group text-left"
                        title="Click to view photo">
                    <template x-if="localPreview">
                        <img :src="localPreview" alt="Profile Photo Preview" class="size-full object-cover">
                    </template>
                    
                    <div x-show="!localPreview" class="size-full">
                        @if($avatarFile && method_exists($avatarFile, 'temporaryUrl'))
                            <img src="{{ $avatarFile->temporaryUrl() }}" alt="Profile Photo Preview" class="size-full object-cover">
                        @elseif($user->avatar)
                            <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="size-full object-cover">
                        @else
                            <div class="size-full flex items-center justify-center">
                                <span class="text-3xl sm:text-4xl font-black font-outfit text-zinc-300">
                                    {{ $user->initials() }}
                                </span>
                            </div>
                        @endif
                    </div>

                    @if($avatarFile)
                        <!-- Pending Confirmation Badge -->
                        <div class="absolute bottom-1 inset-x-1 py-0.5 bg-amber-500/95 backdrop-blur-xs text-[10px] font-black tracking-wider text-zinc-950 uppercase rounded-lg text-center shadow pointer-events-none">
                            Preview
                        </div>
                    @endif

                    <!-- View Overlay on Hover -->
                    <div class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 flex flex-col items-center justify-center transition-all duration-200 text-white text-xs font-semibold gap-1 backdrop-blur-xs">
                        <flux:icon name="eye" class="size-6 text-white" />
                        <span>View Photo</span>
                    </div>
                </button>

                <input type="file" 
                       id="avatar-file-input" 
                       wire:model="avatarFile" 
                       x-on:change="handleFileChange($event)"
                       accept="image/png, image/jpeg, image/webp" 
                       class="sr-only">

                <!-- Loading spinner while uploading to temporary storage -->
                <div wire:loading wire:target="avatarFile" class="absolute inset-0 bg-black/75 rounded-3xl flex items-center justify-center text-white text-xs font-bold gap-2 z-20">
                    <flux:icon name="arrow-path" class="size-5 animate-spin" />
                    <span>Uploading...</span>
                </div>

                @error('avatarFile')
                    <span class="mt-1.5 text-[11px] text-red-400 font-medium text-center max-w-[130px]">{{ $message }}</span>
                @enderror

                @if(!$avatarFile && $user->avatar)
                    <button type="button" @click="showPhotoModal = true" class="mt-2 text-[11px] text-zinc-400 hover:text-zinc-200 block text-center w-full transition inline-flex items-center justify-center gap-1">
                        <flux:icon name="eye" class="size-3" />
                        View / Edit
                    </button>
                @endif
            </div>

            <!-- Full Photo Viewer & Change Photo Lightbox Modal -->
            <div x-show="showPhotoModal" 
                 x-cloak
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6 bg-black/85 backdrop-blur-md"
                 @keydown.escape.window="showPhotoModal = false"
                 role="dialog"
                 aria-modal="true">
                
                <div @click.away="showPhotoModal = false"
                     class="relative w-full max-w-md rounded-3xl bg-zinc-900 border border-zinc-800 shadow-2xl p-6 sm:p-7 text-white space-y-5 animate-in zoom-in-95 duration-200">
                    
                    <!-- Modal Header -->
                    <div class="flex items-center justify-between border-b border-zinc-800 pb-3">
                        <div class="flex items-center gap-2.5">
                            <div class="p-1.5 bg-sky-500/15 text-sky-400 rounded-lg">
                                <flux:icon name="user" class="size-4" />
                            </div>
                            <div>
                                <h3 class="text-base font-bold font-outfit text-white">Profile Photo</h3>
                                <p class="text-xs text-zinc-400">{{ $resident ? $resident->fullName : $user->name }}</p>
                            </div>
                        </div>
                        <button type="button" 
                                @click="showPhotoModal = false"
                                class="size-8 rounded-full bg-zinc-800 hover:bg-zinc-700 text-zinc-400 hover:text-white flex items-center justify-center transition cursor-pointer"
                                title="Close">
                            <flux:icon name="x-mark" class="size-4" />
                        </button>
                    </div>

                    <!-- Photo Display Canvas -->
                    <div class="relative w-full min-h-[260px] max-h-[50vh] rounded-2xl bg-zinc-950 flex items-center justify-center overflow-hidden border border-zinc-800/80 shadow-inner p-2">
                        <template x-if="localPreview">
                            <img :src="localPreview" alt="Selected Preview Photo" class="max-h-[46vh] w-auto max-w-full rounded-xl object-contain shadow-2xl">
                        </template>
                        
                        <div x-show="!localPreview" class="size-full flex items-center justify-center">
                            @if($avatarFile && method_exists($avatarFile, 'temporaryUrl'))
                                <img src="{{ $avatarFile->temporaryUrl() }}" alt="Preview Photo" class="max-h-[46vh] w-auto max-w-full rounded-xl object-contain shadow-2xl">
                            @elseif($user->avatar)
                                <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="max-h-[46vh] w-auto max-w-full rounded-xl object-contain shadow-2xl">
                            @else
                                <div class="py-10 flex flex-col items-center justify-center text-center text-zinc-400 gap-3">
                                    <div class="size-24 rounded-2xl bg-zinc-800 flex items-center justify-center text-3xl font-black font-outfit text-zinc-300">
                                        {{ $user->initials() }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-zinc-300">No profile photo uploaded yet</p>
                                        <p class="text-xs text-zinc-500">Click below to upload a portrait for your account.</p>
                                    </div>
                                </div>
                            @endif
                        </div>

                        @if($avatarFile)
                            <div class="absolute top-3 right-3 px-2.5 py-1 rounded-full text-[10px] font-black uppercase tracking-wider bg-amber-500 text-zinc-950 shadow">
                                Pending Save
                            </div>
                        @endif
                    </div>

                    <!-- Action Options inside the View Modal -->
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-3 pt-1">
                        <div>
                            @if(!$avatarFile && $user->avatar)
                                <button type="button" 
                                        wire:click="removeAvatar" 
                                        @click="showPhotoModal = false"
                                        wire:confirm="Are you sure you want to remove your profile photo?" 
                                        class="text-xs font-semibold text-red-400 hover:text-red-300 transition inline-flex items-center gap-1.5 cursor-pointer py-1.5 px-2.5 rounded-lg hover:bg-red-500/10">
                                    <flux:icon name="trash" class="size-3.5" />
                                    Remove Photo
                                </button>
                            @elseif($avatarFile)
                                <button type="button" 
                                        @click="clear(); showPhotoModal = false"
                                        class="text-xs font-semibold text-zinc-400 hover:text-zinc-200 transition inline-flex items-center gap-1.5 cursor-pointer py-1.5 px-2.5 rounded-lg hover:bg-zinc-800">
                                    <flux:icon name="x-mark" class="size-3.5" />
                                    Discard Changes
                                </button>
                            @endif
                        </div>

                        <div class="flex items-center gap-2.5 w-full sm:w-auto justify-end">
                            <button type="button" 
                                    @click="triggerFileInput()"
                                    class="px-4 py-2 bg-emerald-600 hover:bg-emerald-500 text-white font-semibold text-xs rounded-xl shadow transition flex items-center gap-2 cursor-pointer">
                                <flux:icon name="camera" class="size-4" />
                                <span>{{ ($user->avatar || $avatarFile) ? 'Change Photo' : 'Upload Photo' }}</span>
                            </button>
                            
                            <button type="button" 
                                    @click="showPhotoModal = false"
                                    class="px-4 py-2 bg-zinc-800 hover:bg-zinc-700 text-zinc-300 hover:text-white font-semibold text-xs rounded-xl transition cursor-pointer">
                                Close
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Profile Overview Info -->
            <div class="flex-1 text-center sm:text-left space-y-2">
                <div class="flex flex-wrap items-center justify-center sm:justify-start gap-2.5">
                    <h1 class="text-2xl sm:text-3xl font-black font-outfit text-white tracking-tight">
                        {{ $resident ? $resident->fullName : $user->name }}
                    </h1>

                    <!-- Role Badge -->
                    <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider
                        @if($user->isAdmin()) bg-emerald-500/20 text-emerald-300 border border-emerald-500/30
                        @elseif($user->isHealthAdmin()) bg-violet-500/20 text-violet-300 border border-violet-500/30
                        @elseif($user->isHouseholdHead()) bg-amber-500/20 text-amber-300 border border-amber-500/30
                        @else bg-sky-500/20 text-sky-300 border border-sky-500/30 @endif">
                        {{ str_replace('_', ' ', $user->role) }}
                    </span>

                    @if($resident && $resident->registration_status === 'approved')
                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">
                            <flux:icon name="check-badge" class="size-3.5" />
                            Verified Resident
                        </span>
                    @endif
                </div>

                <div class="text-sm text-zinc-400 flex flex-wrap items-center justify-center sm:justify-start gap-x-4 gap-y-1">
                    <span class="inline-flex items-center gap-1.5">
                        <flux:icon name="envelope" class="size-4 text-zinc-500" />
                        {{ $user->email }}
                    </span>
                    @if($resident?->mobile_number)
                        <span class="inline-flex items-center gap-1.5">
                            <flux:icon name="phone" class="size-4 text-zinc-500" />
                            {{ $resident->mobile_number }}
                        </span>
                    @endif
                    @if($household)
                        <span class="inline-flex items-center gap-1.5">
                            <flux:icon name="home" class="size-4 text-zinc-500" />
                            Household: {{ $household->household_no }} (Purok {{ $household->purok_no ?? '—' }})
                        </span>
                    @endif
                </div>

                <div class="pt-2 flex flex-wrap items-center justify-center sm:justify-start gap-2">
                    @if($resident?->relationship_to_head)
                        <span class="text-xs bg-zinc-800 text-zinc-300 px-3 py-1 rounded-xl border border-zinc-700">
                            Role in Family: <strong class="text-white">{{ $resident->relationship_to_head }}</strong>
                        </span>
                    @endif
                    @if($resident?->age)
                        <span class="text-xs bg-zinc-800 text-zinc-300 px-3 py-1 rounded-xl border border-zinc-700">
                            Age: <strong class="text-white">{{ $resident->age }} yrs old</strong>
                        </span>
                    @endif
                    @if($resident?->civil_status)
                        <span class="text-xs bg-zinc-800 text-zinc-300 px-3 py-1 rounded-xl border border-zinc-700">
                            Civil Status: <strong class="text-white">{{ $resident->civil_status }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <!-- Quick Action / Tab Switchers -->
            <div class="flex sm:flex-col gap-2 w-full sm:w-auto shrink-0 justify-center">
                <button type="button" wire:click="$set('activeTab', 'overview')" class="px-4 py-2 text-xs font-bold rounded-xl transition duration-200 flex items-center justify-center gap-2 {{ $activeTab === 'overview' ? 'bg-white text-zinc-900 shadow-md' : 'bg-zinc-800/80 hover:bg-zinc-700 text-zinc-300' }}">
                    <flux:icon name="identification" class="size-4" />
                    Complete Details
                </button>
                <button type="button" wire:click="$set('activeTab', 'edit')" class="px-4 py-2 text-xs font-bold rounded-xl transition duration-200 flex items-center justify-center gap-2 {{ $activeTab === 'edit' ? 'bg-sky-500 text-white shadow-md' : 'bg-zinc-800/80 hover:bg-zinc-700 text-zinc-300' }}">
                    <flux:icon name="pencil-square" class="size-4" />
                    Edit Profile
                </button>
                <button type="button" wire:click="$set('activeTab', 'account')" class="px-4 py-2 text-xs font-bold rounded-xl transition duration-200 flex items-center justify-center gap-2 {{ $activeTab === 'account' ? 'bg-zinc-700 text-white shadow-md' : 'bg-zinc-800/80 hover:bg-zinc-700 text-zinc-300' }}">
                    <flux:icon name="cog" class="size-4" />
                    Account Settings
                </button>
            </div>
        </div>

        @if($avatarFile)
            <!-- Sign / Banner to Confirm Saving New Profile Photo -->
            <div class="relative z-10 mt-6 pt-5 border-t border-zinc-800 flex flex-col sm:flex-row items-center justify-between gap-4 p-4 rounded-2xl bg-gradient-to-r from-amber-500/15 via-emerald-500/10 to-sky-500/10 border border-amber-400/30 shadow-lg animate-in fade-in duration-300">
                <div class="flex items-center gap-3 text-center sm:text-left">
                    <div class="p-2.5 bg-amber-500/20 border border-amber-400/30 text-amber-300 rounded-2xl shrink-0">
                        <flux:icon name="photo" class="size-6" />
                    </div>
                    <div>
                        <div class="flex items-center gap-2 justify-center sm:justify-start">
                            <h4 class="text-sm font-black font-outfit text-white tracking-wide">Confirm New Profile Photo</h4>
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-extrabold uppercase tracking-wider bg-amber-400/20 text-amber-300 border border-amber-400/30">
                                Confirmation Required
                            </span>
                        </div>
                        <p class="text-xs text-zinc-300 mt-0.5">
                            You've selected a new photo. Please confirm to apply and save this photo to your official profile.
                        </p>
                    </div>
                </div>

                <div class="flex items-center gap-2 shrink-0 w-full sm:w-auto justify-end">
                    <button type="button" 
                            x-on:click="clear()"
                            wire:click="cancelAvatarUpload" 
                            class="flex-1 sm:flex-initial px-3.5 py-2 text-xs font-bold rounded-xl bg-zinc-800 hover:bg-zinc-700 text-zinc-300 transition">
                        Cancel
                    </button>
                    <button type="button" 
                            wire:click="saveAvatar" 
                            wire:loading.attr="disabled"
                            wire:target="saveAvatar"
                            class="flex-1 sm:flex-initial px-4 py-2 text-xs font-black rounded-xl bg-emerald-500 hover:bg-emerald-400 active:bg-emerald-600 text-zinc-950 shadow-lg shadow-emerald-500/20 transition flex items-center justify-center gap-1.5 cursor-pointer">
                        <flux:icon name="check" class="size-4" wire:loading.remove wire:target="saveAvatar" />
                        <flux:icon name="arrow-path" class="size-4 animate-spin" wire:loading wire:target="saveAvatar" />
                        <span wire:loading.remove wire:target="saveAvatar">Confirm & Save Photo</span>
                        <span wire:loading wire:target="saveAvatar">Saving...</span>
                    </button>
                </div>
            </div>
        @endif
    </div>

    <!-- TAB 1: COMPLETE DETAILS OVERVIEW -->
    @if($activeTab === 'overview')
        <div class="space-y-6">
            @if(!$resident)
                <div class="p-6 rounded-2xl bg-amber-50 dark:bg-amber-950/30 border border-amber-200 dark:border-amber-800/50 flex items-center gap-4">
                    <div class="p-3 bg-amber-500/20 text-amber-600 dark:text-amber-400 rounded-xl">
                        <flux:icon name="information-circle" class="size-6" />
                    </div>
                    <div class="flex-1">
                        <h4 class="text-sm font-bold text-amber-900 dark:text-amber-300">No Resident Profile Linked</h4>
                        <p class="text-xs text-amber-800/80 dark:text-amber-400/80 mt-0.5">Your user account is not yet connected to a Barangay Sambog Registry record. Please contact the Barangay Admin or Household Head.</p>
                    </div>
                </div>
            @endif

            <!-- 1. Personal & Basic Info -->
            <div class="bg-white dark:bg-zinc-900/60 border border-zinc-200 dark:border-zinc-800/80 rounded-3xl p-6 sm:p-8 shadow-sm">
                <div class="flex items-center justify-between border-b border-zinc-100 dark:border-zinc-800 pb-4 mb-6">
                    <div class="flex items-center gap-3">
                        <div class="p-2.5 bg-sky-500/10 text-sky-600 dark:text-sky-400 rounded-2xl">
                            <flux:icon name="user" class="size-6" />
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-zinc-900 dark:text-white font-outfit">Personal & Demographic Information</h3>
                            <p class="text-xs text-zinc-500">Official resident identity records</p>
                        </div>
                    </div>
                    <button type="button" wire:click="$set('activeTab', 'edit')" class="text-xs font-bold text-sky-600 dark:text-sky-400 hover:underline flex items-center gap-1">
                        <flux:icon name="pencil" class="size-3.5" />
                        Edit
                    </button>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    <div class="p-3.5 rounded-2xl bg-zinc-50/70 dark:bg-zinc-800/40 border border-zinc-100 dark:border-zinc-800">
                        <span class="text-[10px] uppercase tracking-wider text-zinc-400 font-bold block">Full Legal Name</span>
                        <span class="text-sm font-bold text-zinc-900 dark:text-white">{{ $resident?->fullName ?? $user->name }}</span>
                    </div>

                    <div class="p-3.5 rounded-2xl bg-zinc-50/70 dark:bg-zinc-800/40 border border-zinc-100 dark:border-zinc-800">
                        <span class="text-[10px] uppercase tracking-wider text-zinc-400 font-bold block">Sex / Gender</span>
                        <span class="text-sm font-bold text-zinc-900 dark:text-white">{{ $resident?->sex ?? '—' }}</span>
                    </div>

                    <div class="p-3.5 rounded-2xl bg-zinc-50/70 dark:bg-zinc-800/40 border border-zinc-100 dark:border-zinc-800">
                        <span class="text-[10px] uppercase tracking-wider text-zinc-400 font-bold block">Birthdate & Age</span>
                        <span class="text-sm font-bold text-zinc-900 dark:text-white">
                            {{ $resident?->birthdate ? date('F d, Y', strtotime($resident->birthdate)) : '—' }}
                            @if($resident?->age) ({{ $resident->age }} yrs old) @endif
                        </span>
                    </div>

                    <div class="p-3.5 rounded-2xl bg-zinc-50/70 dark:bg-zinc-800/40 border border-zinc-100 dark:border-zinc-800">
                        <span class="text-[10px] uppercase tracking-wider text-zinc-400 font-bold block">Place of Birth</span>
                        <span class="text-sm font-bold text-zinc-900 dark:text-white">{{ $resident?->place_of_birth ?? '—' }}</span>
                    </div>

                    <div class="p-3.5 rounded-2xl bg-zinc-50/70 dark:bg-zinc-800/40 border border-zinc-100 dark:border-zinc-800">
                        <span class="text-[10px] uppercase tracking-wider text-zinc-400 font-bold block">Civil Status & Citizenship</span>
                        <span class="text-sm font-bold text-zinc-900 dark:text-white">{{ $resident?->civil_status ?? '—' }} ({{ $resident?->citizenship ?? 'Filipino' }})</span>
                    </div>

                    <div class="p-3.5 rounded-2xl bg-zinc-50/70 dark:bg-zinc-800/40 border border-zinc-100 dark:border-zinc-800">
                        <span class="text-[10px] uppercase tracking-wider text-zinc-400 font-bold block">Religion & Blood Type</span>
                        <span class="text-sm font-bold text-zinc-900 dark:text-white">{{ $resident?->religion ?? '—' }} | Blood Type: {{ $resident?->blood_type ?? '—' }}</span>
                    </div>

                    <div class="p-3.5 rounded-2xl bg-zinc-50/70 dark:bg-zinc-800/40 border border-zinc-100 dark:border-zinc-800">
                        <span class="text-[10px] uppercase tracking-wider text-zinc-400 font-bold block">Height & Weight</span>
                        <span class="text-sm font-bold text-zinc-900 dark:text-white">{{ $resident?->height ? $resident->height . ' cm' : '—' }} / {{ $resident?->weight ? $resident->weight . ' kg' : '—' }}</span>
                    </div>

                    <div class="p-3.5 rounded-2xl bg-zinc-50/70 dark:bg-zinc-800/40 border border-zinc-100 dark:border-zinc-800">
                        <span class="text-[10px] uppercase tracking-wider text-zinc-400 font-bold block">Mobile Phone</span>
                        <span class="text-sm font-bold text-zinc-900 dark:text-white">{{ $resident?->mobile_number ?? '—' }}</span>
                    </div>

                    <div class="p-3.5 rounded-2xl bg-zinc-50/70 dark:bg-zinc-800/40 border border-zinc-100 dark:border-zinc-800">
                        <span class="text-[10px] uppercase tracking-wider text-zinc-400 font-bold block">Account Email</span>
                        <span class="text-sm font-bold text-zinc-900 dark:text-white truncate">{{ $user->email }}</span>
                    </div>
                </div>
            </div>

            <!-- 2. Household & Address -->
            <div class="bg-white dark:bg-zinc-900/60 border border-zinc-200 dark:border-zinc-800/80 rounded-3xl p-6 sm:p-8 shadow-sm">
                <div class="flex items-center gap-3 border-b border-zinc-100 dark:border-zinc-800 pb-4 mb-6">
                    <div class="p-2.5 bg-amber-500/10 text-amber-600 dark:text-amber-400 rounded-2xl">
                        <flux:icon name="home" class="size-6" />
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-zinc-900 dark:text-white font-outfit">Household & Residence Details</h3>
                        <p class="text-xs text-zinc-500">Registry address and housing amenities</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    <div class="p-3.5 rounded-2xl bg-zinc-50/70 dark:bg-zinc-800/40 border border-zinc-100 dark:border-zinc-800">
                        <span class="text-[10px] uppercase tracking-wider text-zinc-400 font-bold block">Household Number</span>
                        <span class="text-sm font-bold text-zinc-900 dark:text-white">{{ $household?->household_no ?? '—' }}</span>
                    </div>

                    <div class="p-3.5 rounded-2xl bg-zinc-50/70 dark:bg-zinc-800/40 border border-zinc-100 dark:border-zinc-800">
                        <span class="text-[10px] uppercase tracking-wider text-zinc-400 font-bold block">Purok & Street</span>
                        <span class="text-sm font-bold text-zinc-900 dark:text-white">Purok {{ $household?->purok_no ?? '—' }}, {{ $household?->street ?? 'Barangay Sambog' }}</span>
                    </div>

                    <div class="p-3.5 rounded-2xl bg-zinc-50/70 dark:bg-zinc-800/40 border border-zinc-100 dark:border-zinc-800">
                        <span class="text-[10px] uppercase tracking-wider text-zinc-400 font-bold block">Role in Household</span>
                        <span class="text-sm font-bold text-zinc-900 dark:text-white">{{ $resident?->relationship_to_head ?? '—' }}</span>
                    </div>

                    <div class="p-3.5 rounded-2xl bg-zinc-50/70 dark:bg-zinc-800/40 border border-zinc-100 dark:border-zinc-800">
                        <span class="text-[10px] uppercase tracking-wider text-zinc-400 font-bold block">Housing Ownership</span>
                        <span class="text-sm font-bold text-zinc-900 dark:text-white">
                            @if($resident?->is_house_owner === 'Y') House Owner
                            @elseif($resident?->is_renter === 'Y') Renter ({{ $resident?->renter_months ?? 0 }} mos)
                            @else — @endif
                        </span>
                    </div>

                    <div class="p-3.5 rounded-2xl bg-zinc-50/70 dark:bg-zinc-800/40 border border-zinc-100 dark:border-zinc-800">
                        <span class="text-[10px] uppercase tracking-wider text-zinc-400 font-bold block">Water Source</span>
                        <span class="text-sm font-bold text-zinc-900 dark:text-white">{{ $resident?->water_source ?? '—' }}</span>
                    </div>

                    <div class="p-3.5 rounded-2xl bg-zinc-50/70 dark:bg-zinc-800/40 border border-zinc-100 dark:border-zinc-800">
                        <span class="text-[10px] uppercase tracking-wider text-zinc-400 font-bold block">Sanitary Toilet / Drainage</span>
                        <span class="text-sm font-bold text-zinc-900 dark:text-white">{{ $resident?->sanitary_toilet ?? '—' }}</span>
                    </div>
                </div>
            </div>

            <!-- 3. Education & Employment -->
            <div class="bg-white dark:bg-zinc-900/60 border border-zinc-200 dark:border-zinc-800/80 rounded-3xl p-6 sm:p-8 shadow-sm">
                <div class="flex items-center gap-3 border-b border-zinc-100 dark:border-zinc-800 pb-4 mb-6">
                    <div class="p-2.5 bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 rounded-2xl">
                        <flux:icon name="academic-cap" class="size-6" />
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-zinc-900 dark:text-white font-outfit">Education, Skills & Employment</h3>
                        <p class="text-xs text-zinc-500">Qualifications and occupational profile</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    <div class="p-3.5 rounded-2xl bg-zinc-50/70 dark:bg-zinc-800/40 border border-zinc-100 dark:border-zinc-800">
                        <span class="text-[10px] uppercase tracking-wider text-zinc-400 font-bold block">Educational Attainment</span>
                        <span class="text-sm font-bold text-zinc-900 dark:text-white">{{ $resident?->highest_educational_attainment ?? '—' }}</span>
                    </div>

                    <div class="p-3.5 rounded-2xl bg-zinc-50/70 dark:bg-zinc-800/40 border border-zinc-100 dark:border-zinc-800">
                        <span class="text-[10px] uppercase tracking-wider text-zinc-400 font-bold block">School Attended / Course</span>
                        <span class="text-sm font-bold text-zinc-900 dark:text-white">{{ $resident?->school_attended ?? '—' }} {{ $resident?->course_completed ? "({$resident->course_completed})" : '' }}</span>
                    </div>

                    <div class="p-3.5 rounded-2xl bg-zinc-50/70 dark:bg-zinc-800/40 border border-zinc-100 dark:border-zinc-800">
                        <span class="text-[10px] uppercase tracking-wider text-zinc-400 font-bold block">Civil Service / Eligibility</span>
                        <span class="text-sm font-bold text-zinc-900 dark:text-white">{{ $resident?->eligibility ?? '—' }}</span>
                    </div>

                    <div class="p-3.5 rounded-2xl bg-zinc-50/70 dark:bg-zinc-800/40 border border-zinc-100 dark:border-zinc-800">
                        <span class="text-[10px] uppercase tracking-wider text-zinc-400 font-bold block">Work Status</span>
                        <span class="text-sm font-bold text-zinc-900 dark:text-white">{{ $resident?->work_status ?? '—' }}</span>
                    </div>

                    <div class="p-3.5 rounded-2xl bg-zinc-50/70 dark:bg-zinc-800/40 border border-zinc-100 dark:border-zinc-800">
                        <span class="text-[10px] uppercase tracking-wider text-zinc-400 font-bold block">Occupation & Income</span>
                        <span class="text-sm font-bold text-zinc-900 dark:text-white">{{ $resident?->occupation ?? '—' }} {{ $resident?->income ? "(PHP " . number_format((float)$resident->income, 2) . "/mo)" : '' }}</span>
                    </div>

                    <div class="p-3.5 rounded-2xl bg-zinc-50/70 dark:bg-zinc-800/40 border border-zinc-100 dark:border-zinc-800">
                        <span class="text-[10px] uppercase tracking-wider text-zinc-400 font-bold block">Primary & Secondary Skills</span>
                        <span class="text-sm font-bold text-zinc-900 dark:text-white">{{ $resident?->primary_skills ?? '—' }} {{ $resident?->secondary_skills ? "/ {$resident->secondary_skills}" : '' }}</span>
                    </div>
                </div>
            </div>

            <!-- 4. Health, Welfare & Voter Record -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Health & Welfare -->
                <div class="bg-white dark:bg-zinc-900/60 border border-zinc-200 dark:border-zinc-800/80 rounded-3xl p-6 sm:p-8 shadow-sm space-y-4">
                    <div class="flex items-center gap-3 border-b border-zinc-100 dark:border-zinc-800 pb-4">
                        <div class="p-2.5 bg-rose-500/10 text-rose-600 dark:text-rose-400 rounded-2xl">
                            <flux:icon name="heart" class="size-6" />
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-zinc-900 dark:text-white font-outfit">Health & Immunization</h3>
                            <p class="text-xs text-zinc-500">Medical profile & PhilHealth</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div class="p-3 rounded-2xl bg-zinc-50/70 dark:bg-zinc-800/40 border border-zinc-100 dark:border-zinc-800">
                            <span class="text-[10px] uppercase tracking-wider text-zinc-400 font-bold block">COVID-19 Status</span>
                            <span class="text-xs font-bold text-zinc-900 dark:text-white">
                                @if($resident?->fully_vaccinated === 'Y') <span class="text-emerald-500">Fully Vaccinated</span> ({{ $resident->covid_brand ?? 'Vaccine' }})
                                @elseif($resident?->partially_vaccinated === 'Y') <span class="text-amber-500">Partially Vaccinated</span>
                                @else <span class="text-zinc-400">Unvaccinated / Not recorded</span> @endif
                            </span>
                        </div>

                        <div class="p-3 rounded-2xl bg-zinc-50/70 dark:bg-zinc-800/40 border border-zinc-100 dark:border-zinc-800">
                            <span class="text-[10px] uppercase tracking-wider text-zinc-400 font-bold block">PhilHealth Membership</span>
                            <span class="text-xs font-bold text-zinc-900 dark:text-white">{{ $resident?->philhealth_id ? "ID: {$resident->philhealth_id}" : ($resident?->has_philhealth === 'Yes' ? 'Enrolled' : 'None') }}</span>
                        </div>

                        <div class="p-3 rounded-2xl bg-zinc-50/70 dark:bg-zinc-800/40 border border-zinc-100 dark:border-zinc-800">
                            <span class="text-[10px] uppercase tracking-wider text-zinc-400 font-bold block">Chronic Conditions</span>
                            <span class="text-xs font-bold text-zinc-900 dark:text-white">{{ ($resident?->health_condition && $resident?->health_condition !== 'None') ? $resident->health_condition : 'None reported' }}</span>
                        </div>

                        <div class="p-3 rounded-2xl bg-zinc-50/70 dark:bg-zinc-800/40 border border-zinc-100 dark:border-zinc-800">
                            <span class="text-[10px] uppercase tracking-wider text-zinc-400 font-bold block">Vulnerable Sector</span>
                            <span class="text-xs font-bold text-zinc-900 dark:text-white">{{ $resident?->vulnerable_sector ?? 'None' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Voter & Civic -->
                <div class="bg-white dark:bg-zinc-900/60 border border-zinc-200 dark:border-zinc-800/80 rounded-3xl p-6 sm:p-8 shadow-sm space-y-4">
                    <div class="flex items-center gap-3 border-b border-zinc-100 dark:border-zinc-800 pb-4">
                        <div class="p-2.5 bg-violet-500/10 text-violet-600 dark:text-violet-400 rounded-2xl">
                            <flux:icon name="check-badge" class="size-6" />
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-zinc-900 dark:text-white font-outfit">Voter & Civic Participation</h3>
                            <p class="text-xs text-zinc-500">COMELEC & Katipunan ng Kabataan (KK)</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div class="p-3 rounded-2xl bg-zinc-50/70 dark:bg-zinc-800/40 border border-zinc-100 dark:border-zinc-800">
                            <span class="text-[10px] uppercase tracking-wider text-zinc-400 font-bold block">National Voter</span>
                            <span class="text-xs font-bold text-zinc-900 dark:text-white">{{ $resident?->registered_national_voter === 'Y' ? 'Registered' : 'Not Registered' }}</span>
                        </div>

                        <div class="p-3 rounded-2xl bg-zinc-50/70 dark:bg-zinc-800/40 border border-zinc-100 dark:border-zinc-800">
                            <span class="text-[10px] uppercase tracking-wider text-zinc-400 font-bold block">SK Voter</span>
                            <span class="text-xs font-bold text-zinc-900 dark:text-white">{{ $resident?->registered_sk_voter === 'Y' ? 'Registered SK' : 'Not SK' }}</span>
                        </div>

                        <div class="p-3 rounded-2xl bg-zinc-50/70 dark:bg-zinc-800/40 border border-zinc-100 dark:border-zinc-800">
                            <span class="text-[10px] uppercase tracking-wider text-zinc-400 font-bold block">Last Voted Year</span>
                            <span class="text-xs font-bold text-zinc-900 dark:text-white">{{ $resident?->last_voted_year ?? '—' }}</span>
                        </div>

                        <div class="p-3 rounded-2xl bg-zinc-50/70 dark:bg-zinc-800/40 border border-zinc-100 dark:border-zinc-800">
                            <span class="text-[10px] uppercase tracking-wider text-zinc-400 font-bold block">KK Assembly</span>
                            <span class="text-xs font-bold text-zinc-900 dark:text-white">{{ $resident?->attended_kk_assembly === 'Y' ? 'Attended' : 'No' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- TAB 2: EDIT PROFILE & EXTENDED RESIDENT DETAILS -->
    @if($activeTab === 'edit')
        <div class="bg-white dark:bg-zinc-900/60 border border-zinc-200 dark:border-zinc-800/80 rounded-3xl p-6 sm:p-8 shadow-sm">
            <div class="border-b border-zinc-100 dark:border-zinc-800 pb-4 mb-6 flex items-center justify-between">
                <div>
                    <h3 class="text-xl font-black font-outfit text-zinc-900 dark:text-white">Edit Profile Details</h3>
                    <p class="text-xs text-zinc-500">Update your information for Barangay records</p>
                </div>
                <flux:button variant="primary" type="button" wire:click="updateResidentDetails">
                    Save Changes
                </flux:button>
            </div>

            <form wire:submit="updateResidentDetails" class="space-y-8">
                <!-- Personal Info Section -->
                <div>
                    <h4 class="text-sm font-bold uppercase tracking-wider text-sky-600 dark:text-sky-400 mb-4">1. Personal & Demographics</h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        <flux:input wire:model="place_of_birth" label="Place of Birth" placeholder="e.g. Tagbilaran City, Bohol" />
                        <flux:input wire:model="religion" label="Religion" placeholder="e.g. Roman Catholic, Christian" />
                        <flux:input wire:model="blood_type" label="Blood Type" placeholder="e.g. O+, A+, B+, AB+" />
                        <flux:input wire:model="height" label="Height (cm)" placeholder="e.g. 165" />
                        <flux:input wire:model="weight" label="Weight (kg)" placeholder="e.g. 60" />
                        <flux:input wire:model="mobile_number" label="Mobile Number" placeholder="e.g. 09171234567" />
                        <flux:select wire:model="civil_status" label="Civil Status">
                            <option value="">Select Status</option>
                            <option value="Single">Single</option>
                            <option value="Married">Married</option>
                            <option value="Widowed">Widowed</option>
                            <option value="Separated">Separated</option>
                            <option value="Live-in">Live-in</option>
                        </flux:select>
                        <flux:input wire:model="citizenship" label="Citizenship" placeholder="Filipino" />
                    </div>
                </div>

                <!-- Education & Employment -->
                <div class="border-t border-zinc-100 dark:border-zinc-800 pt-6">
                    <h4 class="text-sm font-bold uppercase tracking-wider text-emerald-600 dark:text-emerald-400 mb-4">2. Education & Employment</h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        <flux:input wire:model="highest_educational_attainment" label="Highest Educational Attainment" placeholder="e.g. College Graduate" />
                        <flux:input wire:model="school_attended" label="School Attended" placeholder="e.g. Bohol Island State University" />
                        <flux:input wire:model="course_completed" label="Course / Degree" placeholder="e.g. BS Information Technology" />
                        <flux:input wire:model="eligibility" label="Eligibility / Licenses" placeholder="e.g. Civil Service Professional, PRC" />
                        <flux:input wire:model="primary_skills" label="Primary Skills" placeholder="e.g. Computer Literacy, Carpentry" />
                        <flux:input wire:model="secondary_skills" label="Secondary Skills" placeholder="e.g. Driving, Cooking" />
                        <flux:select wire:model="work_status" label="Work Status">
                            <option value="">Select Work Status</option>
                            <option value="Employed">Employed</option>
                            <option value="Self-Employed">Self-Employed</option>
                            <option value="Unemployed">Unemployed</option>
                            <option value="Student">Student</option>
                            <option value="Retired">Retired</option>
                        </flux:select>
                        <flux:input wire:model="occupation" label="Occupation / Job Title" placeholder="e.g. Teacher, Engineer, Driver" />
                        <flux:input wire:model="income" label="Monthly Income (PHP)" type="number" step="0.01" placeholder="e.g. 25000" />
                        <flux:input wire:model="days_work_per_week" label="Days Work Per Week" type="number" min="0" max="7" placeholder="e.g. 5" />
                    </div>
                </div>

                <!-- Health & PhilHealth -->
                <div class="border-t border-zinc-100 dark:border-zinc-800 pt-6">
                    <h4 class="text-sm font-bold uppercase tracking-wider text-rose-600 dark:text-rose-400 mb-4">3. Health & Welfare</h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        <flux:input wire:model="philhealth_id" label="PhilHealth ID No." placeholder="e.g. 12-345678901-2" />
                        <flux:select wire:model="has_philhealth" label="Has PhilHealth?">
                            <option value="">Select Option</option>
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                        </flux:select>
                        <flux:input wire:model="health_condition" label="Chronic Health Conditions" placeholder="e.g. Hypertension, Asthma, None" />
                        <flux:input wire:model="vulnerable_sector" label="Vulnerable Sector" placeholder="e.g. Senior Citizen, PWD, Solo Parent" />
                        <flux:input wire:model="covid_brand" label="COVID Vaccine Brand" placeholder="e.g. Pfizer, Moderna, Sinovac" />
                        <flux:select wire:model="has_booster" label="Has Booster Dose?">
                            <option value="">Select Option</option>
                            <option value="Y">Yes</option>
                            <option value="N">No</option>
                        </flux:select>
                    </div>
                </div>

                @if(auth()->user()->isHouseholdHead())
                    <!-- Household Head specific fields -->
                    <div class="border-t border-zinc-100 dark:border-zinc-800 pt-6">
                        <h4 class="text-sm font-bold uppercase tracking-wider text-amber-600 dark:text-amber-400 mb-4">4. Household Head Level Housing Data</h4>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                            <flux:select wire:model="is_house_owner" label="House Ownership">
                                <option value="">Select</option>
                                <option value="Y">Owned</option>
                                <option value="N">Not Owned</option>
                            </flux:select>
                            <flux:select wire:model="is_renter" label="Renting?">
                                <option value="">Select</option>
                                <option value="Y">Yes (Renting)</option>
                                <option value="N">No</option>
                            </flux:select>
                            <flux:input wire:model="renter_months" label="Renter Months (if applicable)" type="number" placeholder="e.g. 12" />
                            <flux:input wire:model="water_source" label="Primary Water Source" placeholder="e.g. Level III Waterworks, Deep Well" />
                            <flux:input wire:model="sanitary_toilet" label="Sanitary Toilet Facility" placeholder="e.g. Water-sealed Flush" />
                            <flux:input wire:model="waste_management" label="Waste Management" placeholder="e.g. Municipal Collection, Compost" />
                        </div>
                    </div>
                @endif

                <div class="flex justify-end gap-3 pt-6 border-t border-zinc-100 dark:border-zinc-800">
                    <button type="button" wire:click="$set('activeTab', 'overview')" class="px-5 py-2.5 rounded-xl border border-zinc-200 dark:border-zinc-700 text-xs font-bold text-zinc-600 dark:text-zinc-300 hover:bg-zinc-50 dark:hover:bg-zinc-800 transition">
                        Cancel
                    </button>
                    <flux:button variant="primary" type="submit">
                        Save Profile Details
                    </flux:button>
                </div>
            </form>
        </div>
    @endif

    <!-- TAB 3: ACCOUNT SETTINGS & SECURITY -->
    @if($activeTab === 'account')
        <div class="space-y-6">
            <div class="bg-white dark:bg-zinc-900/60 border border-zinc-200 dark:border-zinc-800/80 rounded-3xl p-6 sm:p-8 shadow-sm">
                <h3 class="text-xl font-black font-outfit text-zinc-900 dark:text-white mb-1">Account Credentials</h3>
                <p class="text-xs text-zinc-500 mb-6">Update your login name and email address</p>

                <form wire:submit="updateAccountInformation" class="space-y-5 max-w-xl">
                    <flux:input wire:model="name" :label="__('Display Name')" type="text" required autocomplete="name" />
                    <div>
                        <flux:input wire:model="email" :label="__('Email Address')" type="email" required autocomplete="email" />

                        @if ($this->hasUnverifiedEmail)
                            <div class="mt-2 text-xs text-amber-600 dark:text-amber-400">
                                {{ __('Your email address is unverified.') }}
                                <flux:link class="cursor-pointer font-bold ml-1" wire:click.prevent="resendVerificationNotification">
                                    {{ __('Re-send verification email') }}
                                </flux:link>
                            </div>
                        @endif
                    </div>

                    <flux:button variant="primary" type="submit">{{ __('Save Account Settings') }}</flux:button>
                </form>
            </div>

            <div class="bg-white dark:bg-zinc-900/60 border border-zinc-200 dark:border-zinc-800/80 rounded-3xl p-6 sm:p-8 shadow-sm">
                <h3 class="text-lg font-bold text-zinc-900 dark:text-white mb-1">Quick Links</h3>
                <p class="text-xs text-zinc-500 mb-4">Manage password and appearance</p>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('security.edit') }}" wire:navigate class="px-4 py-2 bg-zinc-100 hover:bg-zinc-200 dark:bg-zinc-800 dark:hover:bg-zinc-700 text-xs font-bold text-zinc-800 dark:text-zinc-200 rounded-xl transition inline-flex items-center gap-2">
                        <flux:icon name="shield-check" class="size-4" />
                        Password & 2FA Security
                    </a>
                    <a href="{{ route('appearance.edit') }}" wire:navigate class="px-4 py-2 bg-zinc-100 hover:bg-zinc-200 dark:bg-zinc-800 dark:hover:bg-zinc-700 text-xs font-bold text-zinc-800 dark:text-zinc-200 rounded-xl transition inline-flex items-center gap-2">
                        <flux:icon name="paint-brush" class="size-4" />
                        Theme & Appearance
                    </a>
                </div>
            </div>

            @if ($this->showDeleteUser)
                <div class="bg-red-50/50 dark:bg-red-950/20 border border-red-200 dark:border-red-900/40 rounded-3xl p-6 sm:p-8 shadow-sm">
                    <livewire:settings.delete-user-form />
                </div>
            @endif
        </div>
    @endif
</div>
