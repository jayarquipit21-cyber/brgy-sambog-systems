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
                const theme = localStorage.getItem('flux.appearance') || localStorage.getItem('theme') || 'system';
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
        
        <!-- SEO Meta Tags & Open Graph Description -->
        <meta name="description" content="Official website of Barangay Sambog, Corella, Bohol. Schedule secure clearance pick-ups, review community stats, and get local council updates.">
        <meta name="keywords" content="Sambog, Corella, Bohol, Barangay Sambog, Official Website, Barangay Clearance, Household Registry">
        <meta property="og:title" content="Barangay Sambog, Corella, Bohol - Official Municipal Website">
        <meta property="og:description" content="Stay connected with community stats, schedule secure clearance pick-ups, and get in touch with local council updates effortlessly.">
        <meta property="og:type" content="website">
        <meta property="og:url" content="{{ url()->current() }}">
        <meta property="og:site_name" content="Barangay Sambog">
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="Barangay Sambog, Corella, Bohol">
        <meta name="twitter:description" content="Official inhabitant demographic registry and secure pick-up scheduling workspace portal.">

        
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
                        },
                        colors: {
                            brand: {
                                DEFAULT: '#059669',
                                dark: '#047857',
                            }
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
                color: #059669;
            }
            .bg-brand {
                background-color: #059669;
            }
            .hover\:bg-brand-dark:hover {
                background-color: #047857;
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

            /* ===== PREMIUM ANIMATED GRID BACKGROUND ===== */
            .bg-mesh {
                position: relative;
            }
            .bg-mesh::before {
                content: '';
                position: fixed;
                inset: 0;
                z-index: 0;
                pointer-events: none;
                background-image:
                    linear-gradient(rgba(5, 150, 105, 0.06) 1px, transparent 1px),
                    linear-gradient(90deg, rgba(5, 150, 105, 0.06) 1px, transparent 1px);
                background-size: 60px 60px;
                mask-image: radial-gradient(ellipse 80% 60% at 50% 40%, black 30%, transparent 100%);
                -webkit-mask-image: radial-gradient(ellipse 80% 60% at 50% 40%, black 30%, transparent 100%);
                animation: grid-pulse 8s ease-in-out infinite;
            }
            .dark .bg-mesh::before {
                background-image:
                    linear-gradient(rgba(52, 211, 153, 0.04) 1px, transparent 1px),
                    linear-gradient(90deg, rgba(52, 211, 153, 0.04) 1px, transparent 1px);
            }
            @keyframes grid-pulse {
                0%, 100% { opacity: 0.5; }
                50% { opacity: 1; }
            }

            /* ===== FILM GRAIN / NOISE TEXTURE ===== */
            .bg-noise::after {
                content: '';
                position: fixed;
                inset: 0;
                z-index: 1;
                pointer-events: none;
                opacity: 0.025;
                background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.85' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)'/%3E%3C/svg%3E");
                background-repeat: repeat;
                background-size: 256px 256px;
            }
            .dark .bg-noise::after {
                opacity: 0.04;
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

            /* ===== AMBIENT BACKGROUND ANIMATIONS ===== */
            @keyframes float-slow {
                0%, 100% { transform: translate(0, 0) scale(1); }
                33% { transform: translate(30px, -25px) scale(1.05); }
                66% { transform: translate(-20px, 15px) scale(0.97); }
            }
            @keyframes float-reverse {
                0%, 100% { transform: translate(0, 0) scale(1.02); }
                33% { transform: translate(-25px, 20px) scale(1); }
                66% { transform: translate(15px, -30px) scale(1.06); }
            }
            @keyframes float-diagonal {
                0%, 100% { transform: translate(0, 0) rotate(0deg) scale(1); }
                25% { transform: translate(40px, -20px) rotate(2deg) scale(1.03); }
                50% { transform: translate(20px, -40px) rotate(-1deg) scale(0.98); }
                75% { transform: translate(-15px, -15px) rotate(1deg) scale(1.05); }
            }
            @keyframes float-orbit {
                0%, 100% { transform: translate(0, 0) scale(1); }
                25% { transform: translate(-30px, -30px) scale(1.08); }
                50% { transform: translate(0, -50px) scale(1); }
                75% { transform: translate(30px, -25px) scale(0.95); }
            }
            @keyframes shimmer-line {
                0% { transform: translateX(-100%); }
                100% { transform: translateX(100%); }
            }
            @keyframes color-shift {
                0%, 100% { filter: hue-rotate(0deg); }
                50% { filter: hue-rotate(20deg); }
            }
            .animate-float {
                animation: float-slow 20s ease-in-out infinite;
            }
            .animate-float-reverse {
                animation: float-reverse 25s ease-in-out infinite;
            }
            .animate-float-diagonal {
                animation: float-diagonal 30s ease-in-out infinite;
            }
            .animate-float-orbit {
                animation: float-orbit 22s ease-in-out infinite;
            }
            .animate-color-shift {
                animation: color-shift 15s ease-in-out infinite;
            }

            /* ===== WAVE DIVIDER ===== */
            .wave-divider {
                position: relative;
                overflow: hidden;
            }
            .wave-divider::after {
                content: '';
                position: absolute;
                bottom: -2px;
                left: 0;
                right: 0;
                height: 80px;
                background: transparent;
                pointer-events: none;
            }
            .wave-svg {
                display: block;
                width: 100%;
                height: auto;
                position: relative;
                z-index: 5;
                margin-top: -1px;
            }

            /* ===== AURORA STREAK ===== */
            .aurora-streak {
                position: absolute;
                width: 200%;
                height: 2px;
                background: linear-gradient(90deg, transparent, rgba(52,211,153,0.3), rgba(45,212,191,0.2), transparent);
                animation: shimmer-line 6s ease-in-out infinite;
            }
            .dark .aurora-streak {
                background: linear-gradient(90deg, transparent, rgba(52,211,153,0.15), rgba(45,212,191,0.1), transparent);
            }
        </style>
    </head>
    <body class="bg-gradient-to-br from-emerald-100 via-white to-teal-50 dark:from-zinc-950 dark:via-zinc-900 dark:to-emerald-950 text-zinc-900 dark:text-zinc-100 min-h-screen flex flex-col transition-colors duration-300 relative overflow-x-hidden">
        
        <!-- ===== PREMIUM AMBIENT BACKGROUND SYSTEM ===== -->
        <div class="fixed inset-0 overflow-hidden pointer-events-none z-0 animate-color-shift">

            <!-- === LIGHT MODE: Multi-layered aurora orbs === -->
            <!-- Primary emerald glow — top-left -->
            <div class="absolute top-[-15%] left-[-15%] w-[70vw] h-[70vw] sm:w-[700px] sm:h-[700px] rounded-full bg-emerald-300/25 blur-[140px] dark:hidden animate-float"></div>
            <!-- Secondary teal glow — mid-right -->
            <div class="absolute top-[25%] right-[-8%] w-[55vw] h-[55vw] sm:w-[550px] sm:h-[550px] rounded-full bg-teal-200/30 blur-[120px] dark:hidden animate-float-reverse"></div>
            <!-- Tertiary mint glow — bottom-left -->
            <div class="absolute bottom-[10%] left-[-12%] w-[65vw] h-[65vw] sm:w-[600px] sm:h-[600px] rounded-full bg-emerald-100/35 blur-[150px] dark:hidden animate-float-diagonal"></div>
            <!-- Accent cyan glow — center top -->
            <div class="absolute top-[5%] left-[40%] w-[40vw] h-[40vw] sm:w-[400px] sm:h-[400px] rounded-full bg-cyan-100/20 blur-[100px] dark:hidden animate-float-orbit"></div>
            <!-- Subtle warm accent — bottom-right -->
            <div class="absolute bottom-[5%] right-[-5%] w-[45vw] h-[45vw] sm:w-[450px] sm:h-[450px] rounded-full bg-lime-100/15 blur-[110px] dark:hidden animate-float-reverse" style="animation-delay: -5s;"></div>

            <!-- === DARK MODE: Deep aurora glow system === -->
            <!-- Primary deep emerald — top-left -->
            <div class="absolute top-[-12%] left-[-18%] w-[80vw] h-[80vw] sm:w-[750px] sm:h-[750px] rounded-full bg-emerald-900/15 blur-[160px] hidden dark:block animate-float"></div>
            <!-- Secondary teal glow — mid-right -->
            <div class="absolute top-[30%] right-[-12%] w-[60vw] h-[60vw] sm:w-[600px] sm:h-[600px] rounded-full bg-teal-900/12 blur-[140px] hidden dark:block animate-float-reverse"></div>
            <!-- Tertiary emerald — bottom -->
            <div class="absolute bottom-[8%] left-[-10%] w-[75vw] h-[75vw] sm:w-[700px] sm:h-[700px] rounded-full bg-emerald-800/8 blur-[170px] hidden dark:block animate-float-diagonal"></div>
            <!-- Accent cyan — center -->
            <div class="absolute top-[15%] left-[35%] w-[45vw] h-[45vw] sm:w-[500px] sm:h-[500px] rounded-full bg-cyan-900/8 blur-[130px] hidden dark:block animate-float-orbit"></div>
            <!-- Subtle warm dark accent -->
            <div class="absolute bottom-[15%] right-[10%] w-[35vw] h-[35vw] sm:w-[400px] sm:h-[400px] rounded-full bg-green-900/6 blur-[120px] hidden dark:block animate-float" style="animation-delay: -8s;"></div>
        </div>
        
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
                <nav class="hidden md:flex flex-1 items-center justify-center gap-4 text-lg font-semibold text-zinc-600 dark:text-zinc-300">
                    <a href="#about" class="px-3 py-2 rounded-md hover:bg-brand/10 hover:text-brand transition">About Us</a>
                    <a href="#services" class="px-3 py-2 rounded-md hover:bg-brand/10 hover:text-brand transition">Public Services</a>
                    <a href="#officials" class="px-3 py-2 rounded-md hover:bg-brand/10 hover:text-brand transition">Local Council</a>
                    <a href="#demographics" class="px-3 py-2 rounded-md hover:bg-brand/10 hover:text-brand transition">Statistics</a>
                    <a href="{{ route('home') }}#places" class="px-3 py-2 rounded-md hover:bg-brand/10 hover:text-brand transition">Places</a>
                    <a href="{{ route('home') }}#announcements" class="px-3 py-2 rounded-md hover:bg-brand/10 hover:text-brand transition">Announcements</a>
                    <a href="{{ route('home') }}#contacts" class="px-3 py-2 rounded-md hover:bg-brand/10 hover:text-brand transition">Contacts</a>
                </nav>

                <!-- Authentication Portal Access -->
                <div class="flex items-center gap-4">
                    <!-- Theme Switcher -->
                    <div x-data="{
                        theme: localStorage.getItem('flux.appearance') || localStorage.getItem('theme') || 'system',
                        open: false,
                        applyTheme() {
                            if (this.theme === 'dark' || (this.theme === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                                document.documentElement.classList.add('dark');
                            } else {
                                document.documentElement.classList.remove('dark');
                            }
                            localStorage.setItem('theme', this.theme);
                            localStorage.setItem('flux.appearance', this.theme);
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
                        <div class="flex items-center gap-4">
                            <span class="text-sm text-zinc-500 dark:text-zinc-400 hidden lg:inline-block font-semibold">Hello, {{ Auth::user()->name }}</span>
                            <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center px-5 py-2.5 text-sm font-bold text-white bg-brand hover:bg-brand-dark rounded-lg transition shadow-md shadow-emerald-500/10 font-outfit">
                                Go to Workspace
                            </a>
                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button type="submit" class="text-sm font-semibold text-zinc-500 hover:text-brand transition cursor-pointer">
                                    Log Out
                                </button>
                            </form>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-5 py-2.5 text-sm font-bold text-white bg-brand hover:bg-brand-dark rounded-lg transition shadow-md shadow-emerald-500/10 font-outfit">
                            Access Portal
                        </a>
                    @endauth
                </div>
            </div>
        </header>

        <!-- Main Content Area -->
        <main class="flex-grow bg-mesh bg-noise overflow-x-hidden relative z-10">
            
            <!-- SECTION 1: Gorgeous Municipal Hero Banner -->
            <section class="relative overflow-hidden py-16 sm:py-24 bg-gradient-to-br from-emerald-400 via-emerald-500 to-teal-500 dark:from-zinc-950 dark:via-emerald-950 dark:to-zinc-900 text-white wave-divider">
                <!-- Radial overlay for depth -->
                <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top,_var(--tw-gradient-stops))] from-white/10 via-transparent to-transparent dark:from-emerald-900/30 dark:via-zinc-950 dark:to-zinc-950 z-0"></div>
                <!-- Glow orbs -->
                <div class="absolute -right-20 -bottom-20 h-96 w-96 rounded-full bg-emerald-400/30 dark:bg-emerald-500/25 blur-3xl z-0 animate-float"></div>
                <div class="absolute -left-20 -top-20 h-96 w-96 rounded-full bg-teal-300/25 dark:bg-teal-400/20 blur-3xl z-0 animate-float-reverse"></div>
                <!-- Additional hero orbs for depth -->
                <div class="absolute top-1/2 left-1/3 h-64 w-64 rounded-full bg-cyan-300/15 dark:bg-cyan-500/10 blur-3xl z-0 animate-float-diagonal"></div>
                <!-- Top shimmer line -->
                <div class="absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-white/40 dark:via-emerald-400/50 to-transparent z-10"></div>
                <!-- Aurora streaks -->
                <div class="aurora-streak top-[30%]" style="animation-delay: -2s;"></div>
                <div class="aurora-streak top-[60%]" style="animation-delay: -4s;"></div>

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

            <!-- Wave SVG Divider: Hero → Content -->
            <div class="relative z-10 -mt-1 bg-transparent">
                <svg class="wave-svg" viewBox="0 0 1440 100" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
                    <path d="M0,40 C240,100 480,0 720,50 C960,100 1200,10 1440,60 L1440,0 L0,0 Z" class="fill-emerald-500 dark:fill-zinc-950" />
                    <path d="M0,50 C300,90 600,10 900,55 C1100,85 1300,20 1440,45 L1440,0 L0,0 Z" class="fill-emerald-400/50 dark:fill-emerald-950/30" />
                </svg>
            </div>

            <!-- SECTION 2: About Barangay Sambog -->
            <section id="about" class="scroll-mt-24 py-16 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                <div class="space-y-6">
                    <span class="text-brand text-lg font-bold uppercase tracking-wider font-outfit">Local Heritage</span>
                    <h2 class="text-5xl font-extrabold tracking-tight font-outfit text-zinc-950 dark:text-white">
                        Serving Our Community with Innovation & Transparency
                    </h2>
                    <p class="text-zinc-600 dark:text-zinc-400 leading-relaxed font-light text-base sm:text-lg">
                        Brgy. Sambog, Corella, Bohol is dedicated to implementing progressive municipal policies that empower every household unit. By structuring our official registries dynamically, we ensure absolute transparency, quick clearances scheduling, and high-security standards for local health datasets.
                    </p>
                    <p class="text-zinc-600 dark:text-zinc-400 leading-relaxed font-light text-base sm:text-lg">
                        Our neighborhood consists of dynamic Purok zones, each monitored closely to provide equal support to vulnerable sectors, pediatric nutritional coverages, and senior citizen wellness programs.
                    </p>
                </div>
                <div class="relative overflow-hidden rounded-3xl bg-white/60 dark:bg-zinc-900/60 backdrop-blur-md border border-emerald-100 dark:border-zinc-800/80 p-8 shadow-xl space-y-6 transition duration-300">
                    <div class="absolute -right-10 -bottom-10 h-32 w-32 rounded-full bg-brand/5 blur-xl"></div>
                    <h4 class="text-lg font-bold text-zinc-950 dark:text-white font-outfit">Brgy. Sambog Local Dev Sandbox</h4>
                    <p class="text-sm text-zinc-600 dark:text-zinc-400 leading-relaxed">
                        Testing role authorization, RBAC parameters, or database layer query limits? Access these pre-seeded sandbox accounts using password: <code class="text-brand font-mono font-bold bg-brand/10 px-1.5 py-0.5 rounded">password</code>
                    </p>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                        <div class="bg-white dark:bg-zinc-950/80 p-3.5 rounded-xl border border-emerald-200 dark:border-zinc-800/80 shadow-sm hover:shadow-md transition-shadow">
                            <div class="font-bold text-zinc-900 dark:text-white">Barangay Admin</div>
                            <div class="font-mono text-zinc-600 dark:text-zinc-400 mt-1 select-all">admin@barangay.gov</div>
                        </div>
                        <div class="bg-white dark:bg-zinc-950/80 p-3.5 rounded-xl border border-emerald-200 dark:border-zinc-800/80 shadow-sm hover:shadow-md transition-shadow">
                            <div class="font-bold text-zinc-900 dark:text-white">Health Admin</div>
                            <div class="font-mono text-zinc-600 dark:text-zinc-400 mt-1 select-all">health@barangay.gov</div>
                        </div>
                        <div class="bg-white dark:bg-zinc-950/80 p-3.5 rounded-xl border border-emerald-200 dark:border-zinc-800/80 shadow-sm hover:shadow-md transition-shadow">
                            <div class="font-bold text-zinc-900 dark:text-white">Household Head</div>
                            <div class="font-mono text-zinc-600 dark:text-zinc-400 mt-1 select-all">head@barangay.gov</div>
                        </div>
                        <div class="bg-white dark:bg-zinc-950/80 p-3.5 rounded-xl border border-emerald-200 dark:border-zinc-800/80 shadow-sm hover:shadow-md transition-shadow">
                            <div class="font-bold text-zinc-900 dark:text-white">Resident Member</div>
                            <div class="font-mono text-zinc-600 dark:text-zinc-400 mt-1 select-all">resident@barangay.gov</div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Wave Divider: About → Services -->
            <div class="relative z-10 bg-transparent">
                <svg class="wave-svg" viewBox="0 0 1440 80" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
                    <path d="M0,60 C360,10 720,80 1080,30 C1260,5 1380,40 1440,20 L1440,80 L0,80 Z" class="fill-emerald-100/60 dark:fill-emerald-900/40" />
                </svg>
            </div>

            <!-- SECTION 3: Public Municipal Services -->
            <section id="services" class="scroll-mt-24 py-16 bg-emerald-100/60 dark:bg-emerald-900/40">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
                    <div class="text-center max-w-2xl mx-auto space-y-3">
                        <span class="text-brand text-lg font-bold uppercase tracking-wider font-outfit">Citizen Welfare</span>
                        <h2 class="text-5xl font-extrabold tracking-tight font-outfit text-zinc-950 dark:text-white">Public Municipal Services</h2>
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
                            <h3 class="font-bold text-xl font-outfit mb-3 text-zinc-950 dark:text-white">Barangay Documents</h3>
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

            <!-- Wave Divider: Services → Officials -->
            <div class="relative z-10 bg-transparent">
                <svg class="wave-svg" viewBox="0 0 1440 80" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
                    <path d="M0,20 C200,70 500,0 800,50 C1100,80 1300,15 1440,40 L1440,0 L0,0 Z" class="fill-emerald-100/60 dark:fill-emerald-900/40" />
                </svg>
            </div>

            <!-- SECTION 4: Local Barangay Council -->
            <section id="officials" class="scroll-mt-24 py-16 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
                <div class="text-center max-w-2xl mx-auto space-y-3">
                    <span class="text-brand text-lg font-bold uppercase tracking-wider font-outfit">Barangay Leadership</span>
                    <h2 class="text-5xl font-extrabold tracking-tight font-outfit text-zinc-950 dark:text-white">Local Barangay Council</h2>
                    <p class="text-zinc-500 text-sm leading-relaxed font-light">
                        Meet the dedicated leaders coordinating the development and administrative operations of Brgy. Sambog, Corella, Bohol.
                    </p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                    <!-- Captain -->
                    <div class="bg-white/60 dark:bg-zinc-900/60 backdrop-blur-md rounded-3xl border border-zinc-200 dark:border-zinc-800/80 p-6 flex flex-col items-center text-center shadow-sm hover:shadow-lg hover:scale-[1.02] transition duration-300">
                        <div class="h-20 w-20 rounded-full premium-gradient flex items-center justify-center text-white text-xl font-bold font-outfit shadow-md ring-4 ring-emerald-400/20">
                            RA
                        </div>
                        <h4 class="font-bold text-lg text-zinc-950 dark:text-white mt-4 font-outfit">Hon. Rey Anthony N. Rebuta</h4>
                        <span class="text-xs text-brand uppercase font-extrabold tracking-wider mt-1">Barangay Captain</span>
                        <p class="text-sm text-zinc-500 mt-2 font-light">Overseeing overall community administration and development.</p>
                    </div>

                    <!-- Councilor 1 -->
                    <div class="bg-white/60 dark:bg-zinc-900/60 backdrop-blur-md rounded-3xl border border-zinc-200 dark:border-zinc-800/80 p-6 flex flex-col items-center text-center shadow-sm hover:shadow-lg hover:scale-[1.02] transition duration-300">
                        <div class="h-20 w-20 rounded-full bg-gradient-to-tr from-teal-500 to-emerald-400 flex items-center justify-center text-white text-xl font-bold font-outfit shadow-md ring-4 ring-teal-400/20">
                            AS
                        </div>
                        <h4 class="font-bold text-lg text-zinc-950 dark:text-white mt-4 font-outfit">Hon. Alice Smith</h4>
                        <span class="text-xs text-brand uppercase font-extrabold tracking-wider mt-1">Committee on Health</span>
                        <p class="text-sm text-zinc-500 mt-2 font-light">Coordinating public health drives and vaccination metrics monitoring.</p>
                    </div>

                    <!-- Councilor 2 -->
                    <div class="bg-white/60 dark:bg-zinc-900/60 backdrop-blur-md rounded-3xl border border-zinc-200 dark:border-zinc-800/80 p-6 flex flex-col items-center text-center shadow-sm hover:shadow-lg hover:scale-[1.02] transition duration-300">
                        <div class="h-20 w-20 rounded-full bg-gradient-to-tr from-sky-500 to-teal-400 flex items-center justify-center text-white text-xl font-bold font-outfit shadow-md ring-4 ring-sky-400/20">
                            AR
                        </div>
                        <h4 class="font-bold text-lg text-zinc-950 dark:text-white mt-4 font-outfit">Arnel T. Itong</h4>
                        <span class="text-xs text-brand uppercase font-extrabold tracking-wider mt-1">Barangay Treasurer</span>
                        <p class="text-sm text-zinc-500 mt-2 font-light">Handling budgetary resources and community development allocations.</p>
                    </div>

                    <!-- Secretary -->
                    <div class="bg-white/60 dark:bg-zinc-900/60 backdrop-blur-md rounded-3xl border border-zinc-200 dark:border-zinc-800/80 p-6 flex flex-col items-center text-center shadow-sm hover:shadow-lg hover:scale-[1.02] transition duration-300">
                        <div class="h-20 w-20 rounded-full bg-gradient-to-tr from-indigo-500 to-purple-400 flex items-center justify-center text-white text-xl font-bold font-outfit shadow-md ring-4 ring-indigo-400/20">
                            CE
                        </div>
                        <h4 class="font-bold text-lg text-zinc-950 dark:text-white mt-4 font-outfit">Cecilia S. Daquio</h4>
                        <span class="text-xs text-brand uppercase font-extrabold tracking-wider mt-1">Barangay Secretary</span>
                        <p class="text-sm text-zinc-500 mt-2 font-light">Managing document issuance, clearances database, and slot scheduling.</p>
                    </div>
                </div>
            </section>

            <!-- Wave Divider: Officials → Demographics -->
            <div class="relative z-10 bg-transparent">
                <svg class="wave-svg" viewBox="0 0 1440 80" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
                    <path d="M0,50 C180,80 420,10 720,60 C960,90 1200,20 1440,50 L1440,80 L0,80 Z" class="fill-emerald-100/60 dark:fill-emerald-900/40" />
                </svg>
            </div>

            <!-- SECTION 5: Community Statistics -->
            <section id="demographics" class="scroll-mt-24 py-16 bg-emerald-100/60 dark:bg-emerald-900/40">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
                    <div class="text-center max-w-2xl mx-auto space-y-3">
                        <span class="text-brand text-lg font-bold uppercase tracking-wider font-outfit">Inhabitants</span>
                        <h2 class="text-5xl font-extrabold tracking-tight font-outfit text-zinc-950 dark:text-white">Community Statistics</h2>
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

            <!-- Wave Divider: Demographics → Places -->
            <div class="relative z-10 bg-transparent">
                <svg class="wave-svg" viewBox="0 0 1440 80" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
                    <path d="M0,30 C300,70 600,5 900,45 C1100,65 1300,10 1440,35 L1440,0 L0,0 Z" class="fill-emerald-100/60 dark:fill-emerald-900/40" />
                </svg>
            </div>

            <!-- SECTION 7: Recommended Places -->
            <section id="places" class="scroll-mt-24 py-8 bg-transparent">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <livewire:recommended-places />
                </div>
            </section>

            <!-- Wave Divider: Places → Announcements -->
            <div class="relative z-10 bg-transparent">
                <svg class="wave-svg" viewBox="0 0 1440 80" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
                    <path d="M0,40 C240,80 480,0 720,55 C960,85 1200,15 1440,45 L1440,80 L0,80 Z" class="fill-emerald-100/60 dark:fill-emerald-900/40" />
                </svg>
            </div>

            <!-- SECTION 8: Premium Announcements Feed (Livewire) -->
            <section id="announcements" class="scroll-mt-24 py-16 bg-emerald-100/60 dark:bg-emerald-900/40">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <livewire:announcements />
                </div>
            </section>

            <!-- Wave Divider: Announcements → Contacts -->
            <div class="relative z-10 bg-transparent">
                <svg class="wave-svg" viewBox="0 0 1440 80" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
                    <path d="M0,25 C180,60 420,5 720,40 C960,70 1200,10 1440,30 L1440,0 L0,0 Z" class="fill-emerald-100/60 dark:fill-emerald-900/40" />
                </svg>
            </div>

            <!-- SECTION 8: Important Contact Numbers -->
            <section id="contacts" class="scroll-mt-24 py-8 bg-transparent">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="text-center max-w-2xl mx-auto space-y-3 mb-6">
                        <span class="text-brand text-lg font-bold uppercase tracking-wider font-outfit">Get In Touch</span>
                        <h2 class="text-5xl font-extrabold tracking-tight font-outfit text-zinc-950 dark:text-white">Important Contact Numbers</h2>
                        <p class="text-zinc-500 text-sm leading-relaxed">Phone numbers for quick access to barangay services and emergency hotlines.</p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                        <div class="bg-white/60 dark:bg-zinc-900/60 backdrop-blur-md p-6 rounded-2xl border border-zinc-200 dark:border-zinc-800 shadow-sm text-center flex flex-col items-center">
                            <div class="p-3 bg-emerald-500/10 text-brand rounded-full mb-3">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                            </div>
                            <div class="font-bold text-zinc-900 dark:text-white">Barangay Office</div>
                            <div class="text-brand font-mono mt-2"> 417-8919</div>
                            <div class="text-xs text-zinc-500 mt-1">Office Hours: 8am–5pm</div>
                        </div>

                        <div class="bg-white/60 dark:bg-zinc-900/60 backdrop-blur-md p-6 rounded-2xl border border-zinc-200 dark:border-zinc-800 shadow-sm text-center flex flex-col items-center">
                            <div class="p-3 bg-emerald-500/10 text-emerald-500 rounded-full mb-3">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                            </div>
                            <div class="font-bold text-zinc-900 dark:text-white">Health Hotline</div>
                            <div class="text-brand font-mono mt-2">+63 917 000 1111</div>
                            <div class="text-xs text-zinc-500 mt-1">For health concerns & immunization</div>
                        </div>

                        <div class="bg-white/60 dark:bg-zinc-900/60 backdrop-blur-md p-6 rounded-2xl border border-zinc-200 dark:border-zinc-800 shadow-sm text-center flex flex-col items-center">
                            <div class="p-3 bg-red-500/10 text-red-500 rounded-full mb-3">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.618 5.984A11.955 11.955 0 0112 2.944a11.952 11.952 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016zM12 9v2m0 4h.01" />
                                </svg>
                            </div>
                            <div class="font-bold text-zinc-900 dark:text-white">Police / Emergency</div>
                            <div class="text-brand font-mono mt-2">911 / 09985986413 (PNP Hotline) / 09092592953 (PCPL. DIONISIO A. BASTES JR.)</div>
                            <div class="text-xs text-zinc-500 mt-1">Immediate assistance</div>
                        </div>

                        <div class="bg-white/60 dark:bg-zinc-900/60 backdrop-blur-md p-6 rounded-2xl border border-zinc-200 dark:border-zinc-800 shadow-sm text-center flex flex-col items-center">
                            <div class="p-3 bg-amber-500/10 text-amber-500 rounded-full mb-3">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.966 7.966 0 01-2.343 5.657z" />
                                </svg>
                            </div>
                            <div class="font-bold text-zinc-900 dark:text-white">Fire Department</div>
                            <div class="text-brand font-mono mt-2">09184767153</div>
                            <div class="text-xs text-zinc-500 mt-1">Fire & Rescue</div>
                        </div>
                    </div>
                </div>
            </section>

        </main>


        <!-- FOOTER: Standard Premium Municipal Footer Layout -->
        <footer class="bg-zinc-100 dark:bg-zinc-950 text-zinc-500 dark:text-zinc-400 py-16 transition-colors duration-300">
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
                        <li>Email: <span class="text-zinc-700 dark:text-zinc-300 font-medium">sambogsupport@corella.gov</span></li>
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
