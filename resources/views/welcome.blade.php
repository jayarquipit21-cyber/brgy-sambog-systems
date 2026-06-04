<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Brgy. Sambog, Corella, Bohol - Official Municipal Website</title>
        <link rel="icon" href="/favicon.ico" sizes="any">
        
        <!-- Theme Initialization script to prevent flash of wrong theme -->
        <script>
            (function() {
                const theme = localStorage.getItem('theme') || 'system';
                if (theme === 'dark' || (theme === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                    document.documentElement.classList.add('dark');
                } else {
                    document.documentElement.classList.remove('dark');
                }
            })();
        </script>
        
        <!-- Google Fonts: Inter & Outfit -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
        
        <!-- Tailwind CSS CDN -->
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                darkMode: 'class',
                theme: {
                    extend: {
                        fontFamily: {
                            sans: ['Inter', 'sans-serif'],
                            outfit: ['Outfit', 'sans-serif'],
                        }
                    }
                }
            }
        </script>
        
        @livewireStyles
        <style>
            body {
                font-family: 'Inter', sans-serif;
            }
            .font-outfit {
                font-family: 'Outfit', sans-serif;
            }
            /* Premium Emerald & Mint Color Theme */
            .text-brand {
                color: #10b981;
            }
            .bg-brand {
                background-color: #10b981;
            }
            .hover\:bg-brand-dark:hover {
                background-color: #059669;
            }
            .premium-gradient {
                background: linear-gradient(135deg, #34d399 0%, #2dd4bf 100%);
            }
            .premium-gradient-dark {
                background: linear-gradient(135deg, #18181b 0%, #09090b 100%);
            }
            .glassmorphism {
                background: rgba(255, 255, 255, 0.88);
                backdrop-filter: blur(16px);
                -webkit-backdrop-filter: blur(16px);
            }
            .dark .glassmorphism {
                background: rgba(9, 9, 11, 0.85);
                backdrop-filter: blur(16px);
                -webkit-backdrop-filter: blur(16px);
            }
            /* Subtle dot-grid mesh overlay */
            .bg-mesh {
                background-image: radial-gradient(circle, rgba(4,120,87,0.15) 1px, transparent 1px);
                background-size: 24px 24px;
            }
            .dark .bg-mesh {
                background-image: radial-gradient(circle, rgba(52,211,153,0.07) 1px, transparent 1px);
                background-size: 24px 24px;
            }
            /* Hero gradient text — adapts to light/dark mode */
            .hero-gradient-text {
                background: linear-gradient(135deg, #ffffff 0%, #a7f3d0 50%, #99f6e4 100%);
                -webkit-background-clip: text;
                background-clip: text;
                color: transparent;
            }
            .dark .hero-gradient-text {
                background: linear-gradient(135deg, #34d399 0%, #2dd4bf 100%);
                -webkit-background-clip: text;
                background-clip: text;
                color: transparent;
            }
        </style>
    </head>
    <body class="bg-gradient-to-br from-emerald-200 via-emerald-50 to-teal-100 dark:from-zinc-950 dark:via-emerald-950 dark:to-zinc-900 text-zinc-900 dark:text-zinc-100 min-h-screen flex flex-col transition-colors duration-300">
        
        <!-- Sticky Premium Header / Navigation Bar -->
        <header class="sticky top-0 z-50 glassmorphism border-b border-emerald-100 dark:border-emerald-900/40 transition-all duration-300">
                <div class="max-w-8xl mx-auto px-2 sm:px-4 lg:px-6 h-20 flex items-center justify-between">
                <!-- Municipal Branding -->
                <a href="#" class="flex items-center gap-3 group flex-shrink-0">
                    <div class="h-10 w-10 rounded-xl premium-gradient flex items-center justify-center text-white font-black text-lg shadow-md font-outfit transform group-hover:scale-105 transition duration-300">
                        BC
                    </div>
                    <div class="min-w-0">
                        <span class="text-lg sm:text-xl font-black tracking-tight text-zinc-950 dark:text-white font-outfit max-w-[220px] truncate block">Brgy. Sambog, Corella, Bohol</span>
                        <div class="text-[9px] text-zinc-500 dark:text-zinc-400 font-bold uppercase tracking-widest mt-0.5">Official Inhabitant Portal</div>
                    </div>
                </a>

                <!-- Navigation Links for a comprehensive website experience -->
                <nav class="hidden md:flex flex-1 items-center justify-center gap-3 text-sm font-semibold text-zinc-600 dark:text-zinc-300">
                    <a href="#about" class="px-2 py-2 rounded-md hover:bg-brand/10 hover:text-brand transition">About Us</a>
                    <a href="#services" class="px-2 py-2 rounded-md hover:bg-brand/10 hover:text-brand transition">Public Services</a>
                    <a href="#officials" class="px-2 py-2 rounded-md hover:bg-brand/10 hover:text-brand transition">Local Council</a>
                    <a href="#demographics" class="px-2 py-2 rounded-md hover:bg-brand/10 hover:text-brand transition">Statistics</a>
                    <a href="{{ route('home') }}#places" class="px-2 py-2 rounded-md hover:bg-brand/10 hover:text-brand transition">Places</a>
                    <a href="{{ route('home') }}#announcements" class="px-2 py-2 rounded-md hover:bg-brand/10 hover:text-brand transition">Announcements</a>
                    <a href="{{ route('home') }}#contacts" class="px-2 py-2 rounded-md hover:bg-brand/10 hover:text-brand transition">Contacts</a>
                </nav>

                <!-- Authentication Portal Access -->
                <div class="flex items-center gap-4">
                    <!-- Theme Switcher -->
                    <div x-data="{
                        theme: localStorage.getItem('theme') || 'system',
                        open: false,
                        applyTheme() {
                            if (this.theme === 'dark' || (this.theme === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                                document.documentElement.classList.add('dark');
                            } else {
                                document.documentElement.classList.remove('dark');
                            }
                            localStorage.setItem('theme', this.theme);
                        }
                    }"
                    x-init="
                        applyTheme();
                        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
                            if (theme === 'system') applyTheme();
                        });
                        $watch('theme', () => applyTheme());
                    "
                    class="relative"
                    >
                        <button @click="open = !open" type="button" class="flex items-center justify-center p-2 rounded-lg bg-zinc-100 hover:bg-zinc-200 dark:bg-zinc-900/50 dark:hover:bg-zinc-800 border border-zinc-200 dark:border-zinc-800 text-zinc-700 dark:text-zinc-300 transition cursor-pointer">
                            <span x-show="theme === 'light'">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m0-12.728l.707.707m12.728 12.728l.707.707M12 8a4 4 0 100 8 4 4 0 000-8z" />
                                </svg>
                            </span>
                            <span x-show="theme === 'dark'" x-cloak>
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                                </svg>
                            </span>
                            <span x-show="theme === 'system'" x-cloak>
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </span>
                        </button>

                        <div x-show="open" @click.away="open = false" x-cloak class="absolute right-0 mt-2 w-32 rounded-xl bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 shadow-lg py-1 z-50 text-xs">
                            <button @click="theme = 'light'; open = false" class="w-full text-left px-3 py-1.5 hover:bg-zinc-100 dark:hover:bg-zinc-800 flex items-center gap-2 text-zinc-700 dark:text-zinc-300">
                                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m0-12.728l.707.707m12.728 12.728l.707.707M12 8a4 4 0 100 8 4 4 0 000-8z" />
                                </svg>
                                Light
                            </button>
                            <button @click="theme = 'dark'; open = false" class="w-full text-left px-3 py-1.5 hover:bg-zinc-100 dark:hover:bg-zinc-800 flex items-center gap-2 text-zinc-700 dark:text-zinc-300">
                                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                                </svg>
                                Dark
                            </button>
                            <button @click="theme = 'system'; open = false" class="w-full text-left px-3 py-1.5 hover:bg-zinc-100 dark:hover:bg-zinc-800 flex items-center gap-2 text-zinc-700 dark:text-zinc-300">
                                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                System
                            </button>
                        </div>
                    </div>
                    @auth
                        <div class="flex items-center gap-3">
                            <span class="text-xs text-zinc-500 dark:text-zinc-400 hidden lg:inline-block font-semibold">Hello, {{ Auth::user()->name }}</span>
                            <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center px-4 py-2 text-xs font-bold text-white bg-brand hover:bg-brand-dark rounded-lg transition shadow-md shadow-emerald-500/10 font-outfit">
                                Go to Workspace
                            </a>
                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button type="submit" class="text-xs font-semibold text-zinc-500 hover:text-brand transition cursor-pointer">
                                    Log Out
                                </button>
                            </form>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-4 py-2 text-xs font-bold text-white bg-brand hover:bg-brand-dark rounded-lg transition shadow-md shadow-emerald-500/10 font-outfit">
                            Access Portal
                        </a>
                    @endauth
                </div>
            </div>
        </header>

        <!-- Main Content Area -->
        <main class="flex-grow bg-mesh">
            
            <!-- SECTION 1: Gorgeous Municipal Hero Banner -->
            <section class="relative overflow-hidden py-16 sm:py-24 bg-gradient-to-br from-emerald-400 via-emerald-500 to-teal-500 dark:from-zinc-950 dark:via-emerald-950 dark:to-zinc-900 text-white">
                <!-- Radial overlay for depth -->
                <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top,_var(--tw-gradient-stops))] from-white/10 via-transparent to-transparent dark:from-emerald-900/30 dark:via-zinc-950 dark:to-zinc-950 z-0"></div>
                <!-- Glow orbs -->
                <div class="absolute -right-20 -bottom-20 h-96 w-96 rounded-full bg-emerald-400/30 dark:bg-emerald-500/25 blur-3xl z-0"></div>
                <div class="absolute -left-20 -top-20 h-96 w-96 rounded-full bg-teal-300/25 dark:bg-teal-400/20 blur-3xl z-0"></div>
                <!-- Top shimmer line -->
                <div class="absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-white/40 dark:via-emerald-400/50 to-transparent z-10"></div>

                <div class="relative z-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-8">
                    <span class="inline-flex items-center gap-1.5 px-3.5 py-1 bg-white/20 border border-white/40 text-white dark:bg-emerald-500/15 dark:border-emerald-400/40 dark:text-emerald-300 rounded-full text-xs font-bold tracking-wider uppercase">
                        <span class="h-1.5 w-1.5 rounded-full bg-white dark:bg-emerald-400 animate-pulse"></span>
                        Official Barangay Domain
                    </span>

                    <h1 class="text-5xl sm:text-8xl font-black font-outfit tracking-tight leading-none text-white max-w-5xl mx-auto drop-shadow-sm">
                        Empowering Citizens, Shaping <span class="hero-gradient-text">Brgy. Sambog, Corella, Bohol</span>
                    </h1>

                    <p class="text-lg sm:text-2xl text-white/85 dark:text-zinc-200 max-w-3xl mx-auto leading-relaxed font-light">
                        Welcome to our official barangay website. Stay connected with community stats, schedule secure clearance pick-ups, and get in touch with local council updates effortlessly.
                    </p>

                    <!-- Hero CTAs removed; primary access available in header -->
                </div>
            </section>

            <!-- SECTION 2: (moved) Dynamic Live Stats Grid will appear later -->

            <!-- SECTION 3: About Barangay Corella -->
            <section id="about" class="py-16 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                <div class="space-y-6">
                    <span class="text-brand text-xs font-bold uppercase tracking-widest font-outfit">Local Heritage</span>
                    <h2 class="text-4xl sm:text-5xl font-extrabold tracking-tight font-outfit text-zinc-950 dark:text-white">
                        Serving Our Community with Innovation & Transparency
                    </h2>
                    <p class="text-zinc-600 dark:text-zinc-400 leading-relaxed font-light text-base sm:text-lg">
                        Brgy. Sambog, Corella, Bohol is dedicated to implementing progressive municipal policies that empower every household unit. By structuring our official registries dynamically, we ensure absolute transparency, quick clearances scheduling, and high-security standards for local health datasets.
                    </p>
                    <p class="text-zinc-600 dark:text-zinc-400 leading-relaxed font-light text-base sm:text-lg">
                        Our neighborhood consists of dynamic Purok zones, each monitored closely to provide equal support to vulnerable sectors, pediatric nutritional coverages, and senior citizen wellness programs.
                    </p>
                </div>
                    <div class="relative overflow-hidden rounded-3xl bg-zinc-900 border border-zinc-800 p-8 shadow-xl space-y-6">
                    <div class="absolute -right-10 -bottom-10 h-32 w-32 rounded-full bg-brand/5 blur-xl"></div>
                    <h4 class="text-lg font-bold text-white font-outfit">Brgy. Sambog Local Dev Sandbox</h4>
                    <p class="text-sm text-zinc-400 leading-relaxed">
                        Testing role authorization, RBAC parameters, or database layer query limits? Access these pre-seeded sandbox accounts using password: <code class="text-brand font-mono font-bold bg-brand/10 px-1 py-0.5 rounded">password</code>
                    </p>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                        <div class="bg-zinc-950 p-3.5 rounded-xl border border-zinc-800">
                            <div class="font-bold text-white">Barangay Admin</div>
                            <div class="font-mono text-zinc-400 mt-1 select-all">admin@barangay.gov</div>
                        </div>
                        <div class="bg-zinc-950 p-3.5 rounded-xl border border-zinc-800">
                            <div class="font-bold text-white">Health Admin</div>
                            <div class="font-mono text-zinc-400 mt-1 select-all">health@barangay.gov</div>
                        </div>
                        <div class="bg-zinc-950 p-3.5 rounded-xl border border-zinc-800">
                            <div class="font-bold text-white">Household Head</div>
                            <div class="font-mono text-zinc-400 mt-1 select-all">head@barangay.gov</div>
                        </div>
                        <div class="bg-zinc-950 p-3.5 rounded-xl border border-zinc-800">
                            <div class="font-bold text-white">Resident Member</div>
                            <div class="font-mono text-zinc-400 mt-1 select-all">resident@barangay.gov</div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- SECTION 4: Public Services Offered -->
            <section id="services" class="py-16 bg-emerald-50/30 dark:bg-emerald-950/10 border-y border-zinc-200 dark:border-zinc-900">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
                    <div class="text-center max-w-2xl mx-auto space-y-3">
                        <span class="text-brand text-xs font-bold uppercase tracking-widest font-outfit">Citizen Welfare</span>
                        <h2 class="text-4xl sm:text-5xl font-extrabold tracking-tight font-outfit text-zinc-950 dark:text-white">Public Municipal Services</h2>
                        <p class="text-zinc-500 text-sm sm:text-base leading-relaxed font-light">
                            Explore dynamic public programs structured to deliver premium governance solutions directly to Brgy. Sambog, Corella, Bohol's inhabitants.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        
                        <div class="bg-white/60 dark:bg-zinc-900/60 backdrop-blur-md p-8 rounded-3xl shadow-sm border border-zinc-200/50 dark:border-zinc-800/80 hover:shadow-md transition duration-300">
                            <div class="p-3 bg-emerald-500/10 text-brand rounded-2xl w-fit mb-6">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <h3 class="font-bold text-xl font-outfit mb-3 text-zinc-950 dark:text-white">Barangay Clearances</h3>
                            <p class="text-zinc-500 text-sm leading-relaxed font-light">
                                Schedule personal pick-up slots at the Barangay Hall to pick up processed official clearances, indigency certifications, and administrative paperworks safely.
                            </p>
                        </div>

                        <div class="bg-white/60 dark:bg-zinc-900/60 backdrop-blur-md p-8 rounded-3xl shadow-sm border border-zinc-200/50 dark:border-zinc-800/80 hover:shadow-md transition duration-300">
                            <div class="p-3 bg-emerald-500/10 text-emerald-500 rounded-2xl w-fit mb-6">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <h3 class="font-bold text-xl font-outfit mb-3 text-zinc-950 dark:text-white">Household Registry</h3>
                            <p class="text-zinc-500 text-sm leading-relaxed font-light">
                                Verified household heads can instantly review registered residents inside their family units, directly sync demographic statuses, and manage appointment requests.
                            </p>
                        </div>

                        <div class="bg-white/60 dark:bg-zinc-900/60 backdrop-blur-md p-8 rounded-3xl shadow-sm border border-zinc-200/50 dark:border-zinc-800/80 hover:shadow-md transition duration-300">
                            <div class="p-3 bg-blue-500/10 text-blue-500 rounded-2xl w-fit mb-6">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                            </div>
                            <h3 class="font-bold text-xl font-outfit mb-3 text-zinc-950 dark:text-white">Vulnerable Health Support</h3>
                            <p class="text-zinc-500 text-sm leading-relaxed font-light">
                                Directing health administration officers with age-dynamic indicators to filter chronic adult conditions or track stunting metrics for pediatric age brackets.
                            </p>
                        </div>

                    </div>
                </div>
            </section>

            <!-- SECTION 5: Local Council / Officials Showcase -->
            <section id="officials" class="py-16 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
                <div class="text-center max-w-2xl mx-auto space-y-3">
                    <span class="text-brand text-xs font-bold uppercase tracking-widest font-outfit">Barangay Leadership</span>
                    <h2 class="text-4xl sm:text-5xl font-extrabold tracking-tight font-outfit text-zinc-950 dark:text-white">Local Barangay Council</h2>
                    <p class="text-zinc-500 text-sm leading-relaxed font-light">
                        Meet the dedicated leaders coordinating the development and administrative operations of Brgy. Sambog, Corella, Bohol.
                    </p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                    <!-- Captain -->
                    <div class="bg-white/60 dark:bg-zinc-900/60 backdrop-blur-md rounded-3xl border border-zinc-200 dark:border-zinc-800/80 p-6 flex flex-col items-center text-center shadow-sm">
                        <div class="h-20 w-20 rounded-full premium-gradient flex items-center justify-center text-white text-xl font-bold font-outfit shadow-md">
                            RA
                        </div>
                        <h4 class="font-bold text-lg text-zinc-950 dark:text-white mt-4 font-outfit">Hon. Rey Anthony N. Rebuta</h4>
                        <span class="text-xs text-brand uppercase font-extrabold tracking-wider mt-1">Barangay Captain</span>
                        <p class="text-sm text-zinc-500 mt-2 font-light">Overseeing overall community administration and development.</p>
                    </div>

                    <!-- Councilor 1 -->
                    <div class="bg-white/60 dark:bg-zinc-900/60 backdrop-blur-md rounded-3xl border border-zinc-200 dark:border-zinc-800/80 p-6 flex flex-col items-center text-center shadow-sm">
                        <div class="h-20 w-20 rounded-full bg-zinc-800 flex items-center justify-center text-zinc-300 text-xl font-bold font-outfit">
                            AS
                        </div>
                        <h4 class="font-bold text-lg text-zinc-950 dark:text-white mt-4 font-outfit">Hon. Alice Smith</h4>
                        <span class="text-xs text-zinc-500 uppercase font-extrabold tracking-wider mt-1">Committee on Health</span>
                        <p class="text-sm text-zinc-500 mt-2 font-light">Coordinating public health drives and vaccination metrics monitoring.</p>
                    </div>

                    <!-- Councilor 2 -->
                    <div class="bg-white/60 dark:bg-zinc-900/60 backdrop-blur-md rounded-3xl border border-zinc-200 dark:border-zinc-800/80 p-6 flex flex-col items-center text-center shadow-sm">
                        <div class="h-20 w-20 rounded-full bg-zinc-800 flex items-center justify-center text-zinc-300 text-xl font-bold font-outfit">
                            AR
                        </div>
                        <h4 class="font-bold text-lg text-zinc-950 dark:text-white mt-4 font-outfit">Arnel T. Itong</h4>
                        <span class="text-xs text-zinc-500 uppercase font-extrabold tracking-wider mt-1">Barangay Treasurer</span>
                        <p class="text-sm text-zinc-500 mt-2 font-light">Handling budgetary resources and community development allocations.</p>
                    </div>

                    <!-- Secretary -->
                    <div class="bg-white/60 dark:bg-zinc-900/60 backdrop-blur-md rounded-3xl border border-zinc-200 dark:border-zinc-800/80 p-6 flex flex-col items-center text-center shadow-sm">
                        <div class="h-20 w-20 rounded-full bg-zinc-800 flex items-center justify-center text-zinc-300 text-xl font-bold font-outfit">
                            CE
                        </div>
                        <h4 class="font-bold text-lg text-zinc-950 dark:text-white mt-4 font-outfit">Cecilia S. Daquio</h4>
                        <span class="text-xs text-zinc-500 uppercase font-extrabold tracking-wider mt-1">Barangay Secretary</span>
                        <p class="text-sm text-zinc-500 mt-2 font-light">Managing document issuance, clearances database, and slot scheduling.</p>
                    </div>
                </div>
            </section>

            <!-- SECTION 6: Demographics (styled like other sections) -->
            <section id="demographics" class="py-16 bg-emerald-50/30 dark:bg-emerald-950/10 border-y border-zinc-200 dark:border-zinc-900">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
                    <div class="text-center max-w-2xl mx-auto space-y-3">
                        <span class="text-brand text-xs font-bold uppercase tracking-widest font-outfit">Inhabitants</span>
                        <h2 class="text-4xl sm:text-5xl font-extrabold tracking-tight font-outfit text-zinc-950 dark:text-white">Community Statistics</h2>
                        <p class="text-zinc-500 text-sm leading-relaxed font-light">A quick snapshot of our registered population, households, senior citizens, and immunization coverage — updated from our household registry.</p>
                    </div>

                    <div class="bg-white/60 dark:bg-zinc-900/60 backdrop-blur-md border border-zinc-200 dark:border-zinc-800 rounded-3xl p-8 sm:p-10 shadow-2xl grid grid-cols-2 lg:grid-cols-4 gap-8 divide-y lg:divide-y-0 lg:divide-x divide-zinc-200 dark:divide-zinc-800">
                        <div class="flex flex-col items-center text-center p-4">
                            <span class="text-sm uppercase font-extrabold tracking-wider text-zinc-400">Total Population</span>
                                <span class="text-5xl sm:text-6xl font-black text-brand font-outfit mt-2">{{ number_format($totalResidents) }}</span>
                                <span class="text-sm text-zinc-500 mt-1 font-semibold">Registered Inhabitants</span>
                        </div>

                        <div class="flex flex-col items-center text-center p-4">
                            <span class="text-sm uppercase font-extrabold tracking-wider text-zinc-400">Total Households</span>
                                <span class="text-5xl sm:text-6xl font-black text-zinc-900 dark:text-white font-outfit mt-2">{{ number_format($totalHouseholds) }}</span>
                                <span class="text-sm text-zinc-500 mt-1 font-semibold">Active Family Units</span>
                        </div>

                        <div class="flex flex-col items-center text-center p-4">
                            <span class="text-sm uppercase font-extrabold tracking-wider text-zinc-400">Senior Citizens</span>
                                <span class="text-5xl sm:text-6xl font-black text-zinc-900 dark:text-white font-outfit mt-2">{{ number_format($seniorCitizens) }}</span>
                                <span class="text-sm text-zinc-500 mt-1 font-semibold">Supported Seniors (60+)</span>
                        </div>

                        <div class="flex flex-col items-center text-center p-4">
                            <span class="text-sm uppercase font-extrabold tracking-wider text-zinc-400">Immunization Rate</span>
                                <span class="text-5xl sm:text-6xl font-black text-emerald-500 font-outfit mt-2">{{ $totalResidents > 0 ? number_format(($vaccinatedCount / $totalResidents) * 100, 1) : 0 }}%</span>
                                <span class="text-sm text-zinc-500 mt-1 font-semibold">Vaccinated Inhabitants</span>
                        </div>
                    </div>
                </div>
            </section>

            <!-- SECTION 7: Recommended Places -->
            <section id="places" class="py-8 bg-transparent">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <livewire:recommended-places />
                </div>
            </section>

            <!-- SECTION 8: Premium Announcements Feed (Livewire) -->
            <section id="announcements" class="py-16 bg-emerald-50/30 dark:bg-emerald-950/10 border-t border-zinc-200 dark:border-zinc-900">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <livewire:announcements />
                </div>
            </section>

            <!-- SECTION 9: Contact Numbers -->
            <section id="contacts" class="py-8 bg-transparent border-t border-zinc-200 dark:border-zinc-800">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="text-center max-w-2xl mx-auto space-y-3 mb-6">
                        <span class="text-brand text-xs font-bold uppercase tracking-widest font-outfit">Get In Touch</span>
                        <h2 class="text-2xl sm:text-3xl font-extrabold tracking-tight font-outfit text-zinc-950 dark:text-white">Important Contact Numbers</h2>
                        <p class="text-zinc-500 text-sm leading-relaxed">Phone numbers for quick access to barangay services and emergency hotlines.</p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                        <div class="bg-white/60 dark:bg-zinc-900/60 backdrop-blur-md p-6 rounded-2xl border border-zinc-200 dark:border-zinc-800 shadow-sm text-center">
                            <div class="font-bold text-zinc-900 dark:text-white">Barangay Office</div>
                            <div class="text-brand font-mono mt-2">(038) 123-4567</div>
                            <div class="text-xs text-zinc-500 mt-1">Office Hours: 8am–5pm</div>
                        </div>

                        <div class="bg-white/60 dark:bg-zinc-900/60 backdrop-blur-md p-6 rounded-2xl border border-zinc-200 dark:border-zinc-800 shadow-sm text-center">
                            <div class="font-bold text-zinc-900 dark:text-white">Health Hotline</div>
                            <div class="text-brand font-mono mt-2">+63 917 000 1111</div>
                            <div class="text-xs text-zinc-500 mt-1">For health concerns & immunization</div>
                        </div>

                        <div class="bg-white/60 dark:bg-zinc-900/60 backdrop-blur-md p-6 rounded-2xl border border-zinc-200 dark:border-zinc-800 shadow-sm text-center">
                            <div class="font-bold text-zinc-900 dark:text-white">Police / Emergency</div>
                            <div class="text-brand font-mono mt-2">911 / (038) 765-4321</div>
                            <div class="text-xs text-zinc-500 mt-1">Immediate assistance</div>
                        </div>

                        <div class="bg-white/60 dark:bg-zinc-900/60 backdrop-blur-md p-6 rounded-2xl border border-zinc-200 dark:border-zinc-800 shadow-sm text-center">
                            <div class="font-bold text-zinc-900 dark:text-white">Fire Department</div>
                            <div class="text-brand font-mono mt-2">+63 927 222 3333</div>
                            <div class="text-xs text-zinc-500 mt-1">Fire & Rescue</div>
                        </div>
                    </div>
                </div>
            </section>

        </main>

        <!-- FOOTER: Standard Premium Municipal Footer Layout -->
        <footer class="bg-zinc-100 dark:bg-zinc-950 text-zinc-500 dark:text-zinc-400 py-16 border-t border-zinc-200 dark:border-zinc-800/50 transition-colors duration-300">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-4 gap-12 text-sm font-light">
                
                <!-- Brand Unit -->
                <div class="space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="h-9 w-9 rounded-lg premium-gradient flex items-center justify-center text-white font-black text-lg font-outfit">
                            BC
                        </div>
                        <span class="text-lg font-bold tracking-tight text-zinc-900 dark:text-white font-outfit">Brgy. Sambog, Corella, Bohol</span>
                    </div>
                    <p class="text-xs text-zinc-500 dark:text-zinc-500 leading-relaxed font-light">
                        Official inhabitant demographic registry and secure pick-up scheduling workspace portal domain.
                    </p>
                </div>

                <!-- Quick Navigation Links -->
                <div class="space-y-4">
                    <h5 class="text-zinc-900 dark:text-white font-bold font-outfit text-xs uppercase tracking-wider">Site Map</h5>
                    <ul class="space-y-2 text-xs">
                        <li><a href="#about" class="hover:text-zinc-900 dark:hover:text-white transition">About Us</a></li>
                        <li><a href="#services" class="hover:text-zinc-900 dark:hover:text-white transition">Public Services</a></li>
                        <li><a href="#demographics" class="hover:text-zinc-900 dark:hover:text-white transition">Inhabitants Statistics</a></li>
                        <li><a href="#officials" class="hover:text-zinc-900 dark:hover:text-white transition">Barangay Council</a></li>
                        <li><a href="{{ route('holidays') }}" class="hover:text-zinc-900 dark:hover:text-white transition">National Holidays</a></li>
                    </ul>
                </div>

                <!-- Operating Hours -->
                <div class="space-y-4">
                    <h5 class="text-zinc-900 dark:text-white font-bold font-outfit text-xs uppercase tracking-wider">Barangay Office Hours</h5>
                    <ul class="space-y-2 text-xs text-zinc-500">
                        <li>Monday - Friday: <span class="text-zinc-700 dark:text-zinc-300 font-medium">8:00 AM - 5:00 PM</span></li>
                        <li>Saturday - Sunday: <span class="text-zinc-700 dark:text-zinc-300 font-medium">Closed</span></li>
                        <li>National Holidays: <span class="text-zinc-700 dark:text-zinc-300 font-medium">Closed</span></li>
                    </ul>
                </div>

                <!-- Contacts -->
                <div class="space-y-4">
                    <h5 class="text-zinc-900 dark:text-white font-bold font-outfit text-xs uppercase tracking-wider">Contact Details</h5>
                    <ul class="space-y-2 text-xs text-zinc-500">
                        <li>Email: <span class="text-zinc-700 dark:text-zinc-300 font-medium">support@corella.gov</span></li>
                        <li>Hotline: <span class="text-zinc-700 dark:text-zinc-300 font-medium">+63 912 345 6789</span></li>
                        <li>Address: <span class="text-zinc-700 dark:text-zinc-300 font-medium">Brgy. Sambog, Corella, Bohol</span></li>
                    </ul>
                </div>

            </div>

            <!-- Legals -->
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 border-t border-zinc-200 dark:border-zinc-900 mt-12 pt-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-zinc-400 dark:text-zinc-600">
                <div>
                    &copy; {{ date('Y') }} Brgy. Sambog, Corella, Bohol Municipal Government. All rights reserved.
                </div>
                <div class="flex gap-6">
                    <a href="#" class="hover:text-zinc-700 dark:hover:text-zinc-400 transition">Privacy Policy</a>
                    <a href="#" class="hover:text-zinc-700 dark:hover:text-zinc-400 transition">Terms of Governance</a>
                </div>
            </div>
        </footer>

        @livewireScripts
    </body>
</html>
