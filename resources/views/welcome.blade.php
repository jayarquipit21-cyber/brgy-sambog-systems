<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Brgy. Sambog, Corella, Bohol - Official Municipal Website</title>
        <link rel="icon" href="/favicon.ico" sizes="any">
        
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
            /* Premium Red-Orange Color Theme */
            .text-brand {
                color: #f53003;
            }
            .bg-brand {
                background-color: #f53003;
            }
            .hover\:bg-brand-dark:hover {
                background-color: #d62700;
            }
            .premium-gradient {
                background: linear-gradient(135deg, #f53003 0%, #ff6b4a 100%);
            }
            .premium-gradient-dark {
                background: linear-gradient(135deg, #18181b 0%, #09090b 100%);
            }
            .glassmorphism {
                background: rgba(255, 255, 255, 0.85);
                backdrop-filter: blur(12px);
                -webkit-backdrop-filter: blur(12px);
            }
            .dark .glassmorphism {
                background: rgba(18, 18, 18, 0.85);
                backdrop-filter: blur(12px);
                -webkit-backdrop-filter: blur(12px);
            }
        </style>
    </head>
    <body class="bg-zinc-50 dark:bg-zinc-950 text-zinc-900 dark:text-zinc-100 min-h-screen flex flex-col transition-colors duration-300">
        
        <!-- Sticky Premium Header / Navigation Bar -->
        <header class="sticky top-0 z-50 glassmorphism border-b border-zinc-200 dark:border-zinc-800/80 transition-all duration-300">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
                <!-- Municipal Branding -->
                <a href="#" class="flex items-center gap-3 group">
                    <div class="h-11 w-11 rounded-xl premium-gradient flex items-center justify-center text-white font-black text-xl shadow-lg shadow-orange-500/20 font-outfit transform group-hover:scale-105 transition duration-300">
                        BC
                    </div>
                    <div>
                        <span class="text-xl font-black tracking-tight text-zinc-950 dark:text-white font-outfit">Brgy. Sambog, Corella, Bohol</span>
                        <div class="text-[9px] text-zinc-500 dark:text-zinc-400 font-bold uppercase tracking-widest mt-0.5">Official Inhabitant Portal</div>
                    </div>
                </a>

                <!-- Navigation Links for a comprehensive website experience -->
                <nav class="hidden md:flex items-center gap-8 text-sm font-semibold text-zinc-600 dark:text-zinc-300">
                    <a href="#about" class="hover:text-brand transition">About Us</a>
                    <a href="#services" class="hover:text-brand transition">Public Services</a>
                    <a href="#demographics" class="hover:text-brand transition">Statistics</a>
                    <a href="#officials" class="hover:text-brand transition">Local Council</a>
                    <a href="#announcements" class="hover:text-brand transition">Announcements</a>
                </nav>

                <!-- Authentication Portal Access -->
                <div class="flex items-center gap-4">
                    @auth
                        <div class="flex items-center gap-3">
                            <span class="text-xs text-zinc-500 dark:text-zinc-400 hidden lg:inline-block font-semibold">Hello, {{ Auth::user()->name }}</span>
                            <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center px-5 py-2.5 text-xs font-bold text-white bg-brand hover:bg-brand-dark rounded-xl transition shadow-md shadow-orange-500/10 font-outfit">
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
                        <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-5 py-2.5 text-xs font-bold text-white bg-brand hover:bg-brand-dark rounded-xl transition shadow-md shadow-orange-500/10 font-outfit">
                            Access Portal
                        </a>
                    @endauth
                </div>
            </div>
        </header>

        <!-- Main Content Area -->
        <main class="flex-grow">
            
            <!-- SECTION 1: Gorgeous Municipal Hero Banner -->
            <section class="relative overflow-hidden py-24 sm:py-32 bg-zinc-950 text-white">
                <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top,_var(--tw-gradient-stops))] from-zinc-800/50 via-zinc-950 to-zinc-950 z-0"></div>
                <div class="absolute -right-20 -bottom-20 h-96 w-96 rounded-full bg-brand/10 blur-3xl z-0"></div>
                
                <div class="relative z-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-8">
                    <span class="inline-flex items-center gap-1.5 px-3.5 py-1 bg-brand/10 border border-brand/25 text-brand rounded-full text-xs font-bold tracking-wider uppercase">
                        <span class="h-1.5 w-1.5 rounded-full bg-brand animate-pulse"></span>
                        Official Municipal Domain
                    </span>
                    
                    <h1 class="text-4xl sm:text-7xl font-black font-outfit tracking-tight leading-none text-white max-w-5xl mx-auto">
                        Empowering Citizens, Shaping <span class="text-transparent bg-clip-text premium-gradient">Brgy. Sambog, Corella, Bohol</span>
                    </h1>
                    
                    <p class="text-base sm:text-xl text-zinc-400 max-w-3xl mx-auto leading-relaxed font-light">
                        Welcome to our official municipal website. Stay connected with community stats, schedule secure clearance pick-ups, and get in touch with local council updates effortlessly.
                    </p>
                    
                    <div class="flex flex-wrap items-center justify-center gap-4 pt-4">
                        @auth
                            <a href="{{ route('dashboard') }}" class="px-8 py-4 bg-brand hover:bg-brand-dark text-white font-bold rounded-xl shadow-lg transition transform hover:-translate-y-0.5 font-outfit">
                                Open Services Portal
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="px-8 py-4 bg-brand hover:bg-brand-dark text-white font-bold rounded-xl shadow-lg transition transform hover:-translate-y-0.5 font-outfit">
                                Resident Login
                            </a>
                        @endauth
                        <a href="#about" class="px-8 py-4 bg-zinc-800 hover:bg-zinc-700 text-zinc-200 font-bold rounded-xl border border-zinc-700/80 transition font-outfit">
                            Explore Community
                        </a>
                    </div>
                </div>
            </section>

            <!-- SECTION 2: Dynamic Live Stats Grid -->
            <section id="demographics" class="relative z-20 -mt-16 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-3xl p-8 sm:p-10 shadow-2xl grid grid-cols-2 lg:grid-cols-4 gap-8 divide-y lg:divide-y-0 lg:divide-x divide-zinc-200 dark:divide-zinc-800">
                    
                    <div class="flex flex-col items-center text-center p-4">
                        <span class="text-xs uppercase font-extrabold tracking-wider text-zinc-400">Total Population</span>
                        <span class="text-4xl sm:text-5xl font-black text-brand font-outfit mt-2">{{ number_format($totalResidents) }}</span>
                        <span class="text-xs text-zinc-500 mt-1 font-semibold">Registered Inhabitants</span>
                    </div>

                    <div class="flex flex-col items-center text-center p-4 pt-8 lg:pt-4">
                        <span class="text-xs uppercase font-extrabold tracking-wider text-zinc-400">Total Households</span>
                        <span class="text-4xl sm:text-5xl font-black text-zinc-900 dark:text-white font-outfit mt-2">{{ number_format($totalHouseholds) }}</span>
                        <span class="text-xs text-zinc-500 mt-1 font-semibold">Active Family Units</span>
                    </div>

                    <div class="flex flex-col items-center text-center p-4 pt-8 lg:pt-4">
                        <span class="text-xs uppercase font-extrabold tracking-wider text-zinc-400">Senior Citizens</span>
                        <span class="text-4xl sm:text-5xl font-black text-zinc-900 dark:text-white font-outfit mt-2">{{ number_format($seniorCitizens) }}</span>
                        <span class="text-xs text-zinc-500 mt-1 font-semibold">Supported Seniors (60+)</span>
                    </div>

                    <div class="flex flex-col items-center text-center p-4 pt-8 lg:pt-4">
                        <span class="text-xs uppercase font-extrabold tracking-wider text-zinc-400">Immunization Rate</span>
                        <span class="text-4xl sm:text-5xl font-black text-emerald-500 font-outfit mt-2">
                            {{ $totalResidents > 0 ? number_format(($vaccinatedCount / $totalResidents) * 100, 1) : 0 }}%
                        </span>
                        <span class="text-xs text-zinc-500 mt-1 font-semibold">Vaccinated Inhabitants</span>
                    </div>

                </div>
            </section>

            <!-- SECTION 3: About Barangay Corella -->
            <section id="about" class="py-24 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                <div class="space-y-6">
                    <span class="text-brand text-xs font-bold uppercase tracking-widest font-outfit">Local Heritage</span>
                    <h2 class="text-3xl sm:text-4xl font-extrabold tracking-tight font-outfit text-zinc-950 dark:text-white">
                        Serving Our Community with Innovation & Transparency
                    </h2>
                    <p class="text-zinc-600 dark:text-zinc-400 leading-relaxed font-light text-sm">
                        Brgy. Sambog, Corella, Bohol is dedicated to implementing progressive municipal policies that empower every household unit. By structuring our official registries dynamically, we ensure absolute transparency, quick clearances scheduling, and high-security standards for local health datasets.
                    </p>
                    <p class="text-zinc-600 dark:text-zinc-400 leading-relaxed font-light text-sm">
                        Our neighborhood consists of dynamic Purok zones, each monitored closely to provide equal support to vulnerable sectors, pediatric nutritional coverages, and senior citizen wellness programs.
                    </p>
                </div>
                <div class="relative overflow-hidden rounded-3xl bg-zinc-900 border border-zinc-800 p-8 shadow-xl space-y-6">
                    <div class="absolute -right-10 -bottom-10 h-32 w-32 rounded-full bg-brand/5 blur-xl"></div>
                    <h4 class="text-base font-bold text-white font-outfit">Brgy. Sambog Local Dev Sandbox</h4>
                    <p class="text-xs text-zinc-400 leading-relaxed">
                        Testing role authorization, RBAC parameters, or database layer query limits? Access these pre-seeded sandbox accounts using password: <code class="text-brand font-mono font-bold bg-brand/10 px-1 py-0.5 rounded">password</code>
                    </p>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
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
            <section id="services" class="py-24 bg-zinc-100 dark:bg-zinc-900/40 border-y border-zinc-200 dark:border-zinc-900">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
                    <div class="text-center max-w-2xl mx-auto space-y-3">
                        <span class="text-brand text-xs font-bold uppercase tracking-widest font-outfit">Citizen Welfare</span>
                        <h2 class="text-3xl sm:text-4xl font-extrabold tracking-tight font-outfit text-zinc-950 dark:text-white">Public Municipal Services</h2>
                        <p class="text-zinc-500 text-xs leading-relaxed font-light">
                            Explore dynamic public programs structured to deliver premium governance solutions directly to Brgy. Sambog, Corella, Bohol's inhabitants.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        
                        <div class="bg-white dark:bg-zinc-900 p-8 rounded-3xl shadow-sm border border-zinc-200/50 dark:border-zinc-800/80 hover:shadow-md transition duration-300">
                            <div class="p-3 bg-red-500/10 text-brand rounded-2xl w-fit mb-6">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <h3 class="font-bold text-lg font-outfit mb-3 text-zinc-950 dark:text-white">Barangay Clearances</h3>
                            <p class="text-zinc-500 text-xs leading-relaxed font-light">
                                Schedule personal pick-up slots at the Barangay Hall to pick up processed official clearances, indigency certifications, and administrative paperworks safely.
                            </p>
                        </div>

                        <div class="bg-white dark:bg-zinc-900 p-8 rounded-3xl shadow-sm border border-zinc-200/50 dark:border-zinc-800/80 hover:shadow-md transition duration-300">
                            <div class="p-3 bg-emerald-500/10 text-emerald-500 rounded-2xl w-fit mb-6">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <h3 class="font-bold text-lg font-outfit mb-3 text-zinc-950 dark:text-white">Household Registry</h3>
                            <p class="text-zinc-500 text-xs leading-relaxed font-light">
                                Verified household heads can instantly review registered residents inside their family units, directly sync demographic statuses, and manage appointment requests.
                            </p>
                        </div>

                        <div class="bg-white dark:bg-zinc-900 p-8 rounded-3xl shadow-sm border border-zinc-200/50 dark:border-zinc-800/80 hover:shadow-md transition duration-300">
                            <div class="p-3 bg-blue-500/10 text-blue-500 rounded-2xl w-fit mb-6">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                            </div>
                            <h3 class="font-bold text-lg font-outfit mb-3 text-zinc-950 dark:text-white">Vulnerable Health Support</h3>
                            <p class="text-zinc-500 text-xs leading-relaxed font-light">
                                Directing health administration officers with age-dynamic indicators to filter chronic adult conditions or track stunting metrics for pediatric age brackets.
                            </p>
                        </div>

                    </div>
                </div>
            </section>

            <!-- SECTION 5: Local Council / Officials Showcase -->
            <section id="officials" class="py-24 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
                <div class="text-center max-w-2xl mx-auto space-y-3">
                    <span class="text-brand text-xs font-bold uppercase tracking-widest font-outfit">Barangay Leadership</span>
                    <h2 class="text-3xl sm:text-4xl font-extrabold tracking-tight font-outfit text-zinc-950 dark:text-white">Local Barangay Council</h2>
                    <p class="text-zinc-500 text-xs leading-relaxed font-light">
                        Meet the dedicated leaders coordinating the development and administrative operations of Brgy. Sambog, Corella, Bohol.
                    </p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                    <!-- Captain -->
                    <div class="bg-white dark:bg-zinc-900 rounded-3xl border border-zinc-200 dark:border-zinc-800/80 p-6 flex flex-col items-center text-center shadow-sm">
                        <div class="h-20 w-20 rounded-full premium-gradient flex items-center justify-center text-white text-xl font-bold font-outfit shadow-md">
                            JD
                        </div>
                        <h4 class="font-bold text-zinc-950 dark:text-white mt-4 font-outfit">Hon. John Doe</h4>
                        <span class="text-[10px] text-brand uppercase font-extrabold tracking-wider mt-1">Barangay Captain</span>
                        <p class="text-[11px] text-zinc-500 mt-2 font-light">Overseeing overall community administration and development.</p>
                    </div>

                    <!-- Councilor 1 -->
                    <div class="bg-white dark:bg-zinc-900 rounded-3xl border border-zinc-200 dark:border-zinc-800/80 p-6 flex flex-col items-center text-center shadow-sm">
                        <div class="h-20 w-20 rounded-full bg-zinc-800 flex items-center justify-center text-zinc-300 text-xl font-bold font-outfit">
                            AS
                        </div>
                        <h4 class="font-bold text-zinc-950 dark:text-white mt-4 font-outfit">Hon. Alice Smith</h4>
                        <span class="text-[10px] text-zinc-500 uppercase font-extrabold tracking-wider mt-1">Committee on Health</span>
                        <p class="text-[11px] text-zinc-500 mt-2 font-light">Coordinating public health drives and vaccination metrics monitoring.</p>
                    </div>

                    <!-- Councilor 2 -->
                    <div class="bg-white dark:bg-zinc-900 rounded-3xl border border-zinc-200 dark:border-zinc-800/80 p-6 flex flex-col items-center text-center shadow-sm">
                        <div class="h-20 w-20 rounded-full bg-zinc-800 flex items-center justify-center text-zinc-300 text-xl font-bold font-outfit">
                            RJ
                        </div>
                        <h4 class="font-bold text-zinc-950 dark:text-white mt-4 font-outfit">Hon. Robert Jones</h4>
                        <span class="text-[10px] text-zinc-500 uppercase font-extrabold tracking-wider mt-1">Committee on Finance</span>
                        <p class="text-[11px] text-zinc-500 mt-2 font-light">Handling budgetary resources and community development allocations.</p>
                    </div>

                    <!-- Secretary -->
                    <div class="bg-white dark:bg-zinc-900 rounded-3xl border border-zinc-200 dark:border-zinc-800/80 p-6 flex flex-col items-center text-center shadow-sm">
                        <div class="h-20 w-20 rounded-full bg-zinc-800 flex items-center justify-center text-zinc-300 text-xl font-bold font-outfit">
                            EM
                        </div>
                        <h4 class="font-bold text-zinc-950 dark:text-white mt-4 font-outfit">Emily Miller</h4>
                        <span class="text-[10px] text-zinc-500 uppercase font-extrabold tracking-wider mt-1">Barangay Secretary</span>
                        <p class="text-[11px] text-zinc-500 mt-2 font-light">Managing document issuance, clearances database, and slot scheduling.</p>
                    </div>
                </div>
            </section>

            <!-- SECTION 6: Premium Announcements Feed -->
            <section id="announcements" class="py-24 bg-zinc-100 dark:bg-zinc-900/40 border-t border-zinc-200 dark:border-zinc-900">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
                    <div class="text-center max-w-2xl mx-auto space-y-3">
                        <span class="text-brand text-xs font-bold uppercase tracking-widest font-outfit">Bulletins & Feeds</span>
                        <h2 class="text-3xl sm:text-4xl font-extrabold tracking-tight font-outfit text-zinc-950 dark:text-white">Community Notice Board</h2>
                        <p class="text-zinc-500 text-xs leading-relaxed font-light">
                            Stay up-to-date with official statements, seasonal alerts, and local assembly programs.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        
                        <div class="bg-white dark:bg-zinc-900 p-8 rounded-3xl border border-zinc-200/50 dark:border-zinc-800/80 shadow-sm space-y-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-orange-500/10 text-brand uppercase">Public Service Notice</span>
                            <h4 class="text-lg font-bold font-outfit text-zinc-950 dark:text-white">Physical Document Collection Slots Open</h4>
                            <p class="text-zinc-500 text-xs leading-relaxed font-light">
                                Residents can now request personal pickup slots directly via their authenticated inhabitant dashboard. Approved clearancces or indigency certificates can be picked up at the Barangay Hall on business days.
                            </p>
                            <div class="text-[10px] text-zinc-400 font-semibold">Published: Today</div>
                        </div>

                        <div class="bg-white dark:bg-zinc-900 p-8 rounded-3xl border border-zinc-200/50 dark:border-zinc-800/80 shadow-sm space-y-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-blue-500/10 text-blue-500 uppercase">Health Bulletin</span>
                            <h4 class="text-lg font-bold font-outfit text-zinc-950 dark:text-white">Pediatric Wellness and Vaccination Checkup</h4>
                            <p class="text-zinc-500 text-xs leading-relaxed font-light">
                                In coordination with the Barangay Health Office, a comprehensive demographic assessment is active to monitor vaccination coverages and nutritional statuses for children in Purok 1 to 8.
                            </p>
                            <div class="text-[10px] text-zinc-400 font-semibold">Published: Yesterday</div>
                        </div>

                    </div>
                </div>
            </section>

        </main>

        <!-- FOOTER: Standard Premium Municipal Footer Layout -->
        <footer class="bg-zinc-950 text-zinc-400 py-16 border-t border-zinc-800/50 transition-colors">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-4 gap-12 text-sm font-light">
                
                <!-- Brand Unit -->
                <div class="space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="h-9 w-9 rounded-lg premium-gradient flex items-center justify-center text-white font-black text-lg font-outfit">
                            BC
                        </div>
                        <span class="text-lg font-bold tracking-tight text-white font-outfit">Brgy. Sambog, Corella, Bohol</span>
                    </div>
                    <p class="text-xs text-zinc-500 leading-relaxed font-light">
                        Official inhabitant demographic registry and secure pick-up scheduling workspace portal domain.
                    </p>
                </div>

                <!-- Quick Navigation Links -->
                <div class="space-y-4">
                    <h5 class="text-white font-bold font-outfit text-xs uppercase tracking-wider">Site Map</h5>
                    <ul class="space-y-2 text-xs">
                        <li><a href="#about" class="hover:text-white transition">About Us</a></li>
                        <li><a href="#services" class="hover:text-white transition">Public Services</a></li>
                        <li><a href="#demographics" class="hover:text-white transition">Inhabitants Statistics</a></li>
                        <li><a href="#officials" class="hover:text-white transition">Barangay Council</a></li>
                    </ul>
                </div>

                <!-- Operating Hours -->
                <div class="space-y-4">
                    <h5 class="text-white font-bold font-outfit text-xs uppercase tracking-wider">Barangay Office Hours</h5>
                    <ul class="space-y-2 text-xs text-zinc-500">
                        <li>Monday - Friday: <span class="text-zinc-300 font-medium">8:00 AM - 5:00 PM</span></li>
                        <li>Saturday - Sunday: <span class="text-zinc-300 font-medium">Closed</span></li>
                        <li>National Holidays: <span class="text-zinc-300 font-medium">Closed</span></li>
                    </ul>
                </div>

                <!-- Contacts -->
                <div class="space-y-4">
                    <h5 class="text-white font-bold font-outfit text-xs uppercase tracking-wider">Contact Details</h5>
                    <ul class="space-y-2 text-xs text-zinc-500">
                        <li>Email: <span class="text-zinc-300 font-medium">support@corella.gov</span></li>
                        <li>Hotline: <span class="text-zinc-300 font-medium">+63 912 345 6789</span></li>
                        <li>Address: <span class="text-zinc-300 font-medium">Barangay Hall, Brgy. Sambog, Corella, Bohol</span></li>
                    </ul>
                </div>

            </div>

            <!-- Legals -->
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 border-t border-zinc-900 mt-12 pt-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-zinc-600">
                <div>
                    &copy; {{ date('Y') }} Brgy. Sambog, Corella, Bohol Municipal Government. All rights reserved.
                </div>
                <div class="flex gap-6">
                    <a href="#" class="hover:text-zinc-400 transition">Privacy Policy</a>
                    <a href="#" class="hover:text-zinc-400 transition">Terms of Governance</a>
                </div>
            </div>
        </footer>

        @livewireScripts
    </body>
</html>
