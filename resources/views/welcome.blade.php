<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Brgy. Sambog, Corella, Bohol - Official Municipal Portal</title>
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
        
        <!-- SEO Meta Tags & Open Graph -->
        <meta name="description" content="Official municipal portal of Barangay Sambog, Corella, Bohol. Schedule document clearances, view inhabitant statistics, and access local council updates.">
        <meta name="keywords" content="Sambog, Corella, Bohol, Barangay Sambog, Official Portal, Barangay Clearance, Household Registry">
        <meta property="og:title" content="Barangay Sambog, Corella, Bohol - Official Municipal Portal">
        <meta property="og:description" content="Official inhabitant demographic registry and secure pick-up scheduling portal.">
        <meta property="og:type" content="website">
        <meta property="og:url" content="{{ url()->current() }}">
        <meta property="og:site_name" content="Barangay Sambog">
        <meta name="twitter:card" content="summary_large_image">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
        <style>
            body { font-family: 'Inter', sans-serif; }
            .font-outfit { font-family: 'Outfit', sans-serif; }
            
            /* Glassmorphism Surface Tokens */
            .glass-panel {
                background: rgba(255, 255, 255, 0.75);
                backdrop-filter: blur(16px);
                -webkit-backdrop-filter: blur(16px);
            }
            .dark .glass-panel {
                background: rgba(18, 18, 20, 0.75);
                backdrop-filter: blur(16px);
                -webkit-backdrop-filter: blur(16px);
            }
            
            /* Glow and Accent Gradients */
            .emerald-glow {
                background: radial-gradient(circle, rgba(16, 185, 129, 0.12) 0%, transparent 70%);
            }
            .bento-card-glow {
                transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;
            }
            .bento-card-glow:hover {
                transform: translateY(-2px);
                box-shadow: 0 12px 30px -10px rgba(16, 185, 129, 0.15);
            }

            /* Reduced motion handling */
            @media (prefers-reduced-motion: reduce) {
                .bento-card-glow:hover { transform: none; }
            }
        </style>
    </head>
    <body class="relative bg-zinc-50 dark:bg-zinc-950 text-zinc-900 dark:text-zinc-100 min-h-screen flex flex-col antialiased selection:bg-emerald-500 selection:text-white transition-colors duration-200 overflow-x-hidden">
        
        <!-- Star Constellation & Geometric Shape Canvas -->
        <div class="absolute inset-0 pointer-events-none z-0 overflow-hidden min-h-full">
            
            <!-- Light Mode: Soft Dot Grid Overlay -->
            <div class="absolute inset-0 bg-[radial-gradient(#059669_1.2px,transparent_1.2px)] [background-size:28px_28px] opacity-[0.14] dark:hidden"></div>

            <!-- Dark Mode: Dense Twinkling Star Constellation Field -->
            <div class="absolute inset-0 hidden dark:block">
                <!-- Constellation Dust Glows -->
                <div class="absolute top-[5%] left-[20%] w-[500px] h-[300px] bg-emerald-500/10 blur-[100px] rounded-full pointer-events-none"></div>
                <div class="absolute top-[35%] right-[15%] w-[600px] h-[350px] bg-teal-500/10 blur-[110px] rounded-full pointer-events-none"></div>
                <div class="absolute top-[70%] left-[25%] w-[550px] h-[300px] bg-sky-500/10 blur-[100px] rounded-full pointer-events-none"></div>

                <!-- DENSE STAR PARTICLES (0% - 20%) -->
                <div class="absolute top-[1%] left-[8%] w-1 h-1 bg-emerald-300 rounded-full animate-pulse shadow-[0_0_8px_#34d399]" style="animation-delay: -0.3s;"></div>
                <div class="absolute top-[2%] left-[45%] w-1.5 h-1.5 bg-teal-200 rounded-full animate-pulse shadow-[0_0_10px_#2dd4bf]" style="animation-delay: -1.7s;"></div>
                <div class="absolute top-[3%] left-[82%] w-2 h-2 bg-sky-300 rounded-full animate-pulse shadow-[0_0_12px_#38bdf8]" style="animation-delay: -2.9s;"></div>
                <div class="absolute top-[5%] left-[28%] w-1 h-1 bg-emerald-200 rounded-full animate-pulse shadow-[0_0_8px_#34d399]" style="animation-delay: -4.1s;"></div>
                <div class="absolute top-[6%] left-[64%] text-emerald-300/90 animate-pulse" style="animation-delay: -0.8s;">
                    <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0L14.59 9.41L24 12L14.59 14.59L12 24L9.41 14.59L0 12L9.41 9.41L12 0Z"/></svg>
                </div>
                <div class="absolute top-[7%] left-[16%] w-1.5 h-1.5 bg-sky-200 rounded-full animate-pulse shadow-[0_0_10px_#38bdf8]" style="animation-delay: -3.5s;"></div>
                <div class="absolute top-[9%] left-[92%] w-1 h-1 bg-teal-300 rounded-full animate-pulse shadow-[0_0_8px_#2dd4bf]" style="animation-delay: -1.2s;"></div>
                <div class="absolute top-[10%] left-[53%] w-2 h-2 bg-emerald-300 rounded-full animate-pulse shadow-[0_0_12px_#34d399]" style="animation-delay: -4.8s;"></div>
                <div class="absolute top-[12%] left-[36%] text-teal-300/80 animate-pulse" style="animation-delay: -2.3s;">
                    <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0L14.59 9.41L24 12L14.59 14.59L12 24L9.41 14.59L0 12L9.41 9.41L12 0Z"/></svg>
                </div>
                <div class="absolute top-[14%] left-[74%] w-1.5 h-1.5 bg-emerald-200 rounded-full animate-pulse shadow-[0_0_10px_#34d399]" style="animation-delay: -0.6s;"></div>
                <div class="absolute top-[16%] left-[22%] text-emerald-300/90 animate-pulse" style="animation-delay: -3.2s;">
                    <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0L14.59 9.41L24 12L14.59 14.59L12 24L9.41 14.59L0 12L9.41 9.41L12 0Z"/></svg>
                </div>
                <div class="absolute top-[18%] left-[86%] w-1 h-1 bg-sky-300 rounded-full animate-pulse shadow-[0_0_8px_#38bdf8]" style="animation-delay: -1.9s;"></div>
                <div class="absolute top-[20%] left-[41%] w-2 h-2 bg-teal-200 rounded-full animate-pulse shadow-[0_0_12px_#2dd4bf]" style="animation-delay: -4.4s;"></div>

                <!-- DENSE STAR PARTICLES (20% - 40%) -->
                <div class="absolute top-[22%] left-[10%] w-1.5 h-1.5 bg-emerald-300 rounded-full animate-pulse shadow-[0_0_10px_#34d399]" style="animation-delay: -2.7s;"></div>
                <div class="absolute top-[23%] left-[68%] text-teal-300/80 animate-pulse" style="animation-delay: -0.4s;">
                    <svg class="h-3.5 w-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0L14.59 9.41L24 12L14.59 14.59L12 24L9.41 14.59L0 12L9.41 9.41L12 0Z"/></svg>
                </div>
                <div class="absolute top-[25%] left-[55%] w-1 h-1 bg-sky-200 rounded-full animate-pulse shadow-[0_0_8px_#38bdf8]" style="animation-delay: -3.8s;"></div>
                <div class="absolute top-[27%] left-[30%] w-2 h-2 bg-emerald-300 rounded-full animate-pulse shadow-[0_0_12px_#34d399]" style="animation-delay: -1.1s;"></div>
                <div class="absolute top-[29%] left-[93%] w-1.5 h-1.5 bg-teal-300 rounded-full animate-pulse shadow-[0_0_10px_#2dd4bf]" style="animation-delay: -4.9s;"></div>
                <div class="absolute top-[31%] left-[18%] text-emerald-300/90 animate-pulse" style="animation-delay: -2.2s;">
                    <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0L14.59 9.41L24 12L14.59 14.59L12 24L9.41 14.59L0 12L9.41 9.41L12 0Z"/></svg>
                </div>
                <div class="absolute top-[33%] left-[79%] w-1 h-1 bg-sky-300 rounded-full animate-pulse shadow-[0_0_8px_#38bdf8]" style="animation-delay: -0.7s;"></div>
                <div class="absolute top-[35%] left-[46%] w-2 h-2 bg-emerald-200 rounded-full animate-pulse shadow-[0_0_12px_#34d399]" style="animation-delay: -3.3s;"></div>
                <div class="absolute top-[37%] left-[14%] text-teal-300/80 animate-pulse" style="animation-delay: -1.5s;">
                    <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0L14.59 9.41L24 12L14.59 14.59L12 24L9.41 14.59L0 12L9.41 9.41L12 0Z"/></svg>
                </div>
                <div class="absolute top-[39%] left-[62%] w-1.5 h-1.5 bg-teal-200 rounded-full animate-pulse shadow-[0_0_10px_#2dd4bf]" style="animation-delay: -4.0s;"></div>

                <!-- DENSE STAR PARTICLES (40% - 60%) -->
                <div class="absolute top-[41%] left-[25%] w-1 h-1 bg-emerald-300 rounded-full animate-pulse shadow-[0_0_8px_#34d399]" style="animation-delay: -2.6s;"></div>
                <div class="absolute top-[43%] left-[88%] w-2 h-2 bg-sky-300 rounded-full animate-pulse shadow-[0_0_12px_#38bdf8]" style="animation-delay: -0.1s;"></div>
                <div class="absolute top-[45%] left-[37%] text-emerald-300/90 animate-pulse" style="animation-delay: -3.7s;">
                    <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0L14.59 9.41L24 12L14.59 14.59L12 24L9.41 14.59L0 12L9.41 9.41L12 0Z"/></svg>
                </div>
                <div class="absolute top-[47%] left-[72%] w-1.5 h-1.5 bg-teal-300 rounded-full animate-pulse shadow-[0_0_10px_#2dd4bf]" style="animation-delay: -1.4s;"></div>
                <div class="absolute top-[49%] left-[12%] w-1 h-1 bg-emerald-200 rounded-full animate-pulse shadow-[0_0_8px_#34d399]" style="animation-delay: -4.3s;"></div>
                <div class="absolute top-[51%] left-[51%] text-amber-300/80 animate-pulse" style="animation-delay: -2.0s;">
                    <svg class="h-3.5 w-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0L14.59 9.41L24 12L14.59 14.59L12 24L9.41 14.59L0 12L9.41 9.41L12 0Z"/></svg>
                </div>
                <div class="absolute top-[53%] left-[83%] w-2 h-2 bg-sky-200 rounded-full animate-pulse shadow-[0_0_12px_#38bdf8]" style="animation-delay: -0.8s;"></div>
                <div class="absolute top-[55%] left-[29%] w-1.5 h-1.5 bg-emerald-300 rounded-full animate-pulse shadow-[0_0_10px_#34d399]" style="animation-delay: -3.0s;"></div>
                <div class="absolute top-[57%] left-[65%] w-1 h-1 bg-teal-200 rounded-full animate-pulse shadow-[0_0_8px_#2dd4bf]" style="animation-delay: -1.6s;"></div>
                <div class="absolute top-[59%] left-[94%] text-teal-300/90 animate-pulse" style="animation-delay: -4.6s;">
                    <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0L14.59 9.41L24 12L14.59 14.59L12 24L9.41 14.59L0 12L9.41 9.41L12 0Z"/></svg>
                </div>

                <!-- DENSE STAR PARTICLES (60% - 80%) -->
                <div class="absolute top-[61%] left-[16%] w-2 h-2 bg-sky-300 rounded-full animate-pulse shadow-[0_0_12px_#38bdf8]" style="animation-delay: -2.1s;"></div>
                <div class="absolute top-[63%] left-[44%] w-1 h-1 bg-emerald-300 rounded-full animate-pulse shadow-[0_0_8px_#34d399]" style="animation-delay: -0.5s;"></div>
                <div class="absolute top-[65%] left-[78%] text-emerald-300/80 animate-pulse" style="animation-delay: -3.9s;">
                    <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0L14.59 9.41L24 12L14.59 14.59L12 24L9.41 14.59L0 12L9.41 9.41L12 0Z"/></svg>
                </div>
                <div class="absolute top-[67%] left-[32%] w-1.5 h-1.5 bg-teal-200 rounded-full animate-pulse shadow-[0_0_10px_#2dd4bf]" style="animation-delay: -1.3s;"></div>
                <div class="absolute top-[69%] left-[89%] w-1 h-1 bg-sky-200 rounded-full animate-pulse shadow-[0_0_8px_#38bdf8]" style="animation-delay: -4.5s;"></div>
                <div class="absolute top-[71%] left-[21%] text-teal-300/90 animate-pulse" style="animation-delay: -2.8s;">
                    <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0L14.59 9.41L24 12L14.59 14.59L12 24L9.41 14.59L0 12L9.41 9.41L12 0Z"/></svg>
                </div>
                <div class="absolute top-[73%] left-[58%] w-2 h-2 bg-emerald-200 rounded-full animate-pulse shadow-[0_0_12px_#34d399]" style="animation-delay: -0.2s;"></div>
                <div class="absolute top-[75%] left-[10%] w-1.5 h-1.5 bg-teal-300 rounded-full animate-pulse shadow-[0_0_10px_#2dd4bf]" style="animation-delay: -3.4s;"></div>
                <div class="absolute top-[77%] left-[81%] w-1 h-1 bg-emerald-300 rounded-full animate-pulse shadow-[0_0_8px_#34d399]" style="animation-delay: -1.8s;"></div>
                <div class="absolute top-[79%] left-[39%] text-sky-300/80 animate-pulse" style="animation-delay: -4.1s;">
                    <svg class="h-3.5 w-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0L14.59 9.41L24 12L14.59 14.59L12 24L9.41 14.59L0 12L9.41 9.41L12 0Z"/></svg>
                </div>

                <!-- DENSE STAR PARTICLES (80% - 100%) -->
                <div class="absolute top-[81%] left-[67%] w-1.5 h-1.5 bg-sky-300 rounded-full animate-pulse shadow-[0_0_10px_#38bdf8]" style="animation-delay: -2.5s;"></div>
                <div class="absolute top-[83%] left-[24%] w-2 h-2 bg-emerald-300 rounded-full animate-pulse shadow-[0_0_12px_#34d399]" style="animation-delay: -0.9s;"></div>
                <div class="absolute top-[85%] left-[91%] text-emerald-300/90 animate-pulse" style="animation-delay: -3.6s;">
                    <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0L14.59 9.41L24 12L14.59 14.59L12 24L9.41 14.59L0 12L9.41 9.41L12 0Z"/></svg>
                </div>
                <div class="absolute top-[87%] left-[49%] w-1 h-1 bg-teal-200 rounded-full animate-pulse shadow-[0_0_8px_#2dd4bf]" style="animation-delay: -1.7s;"></div>
                <div class="absolute top-[89%] left-[13%] w-1.5 h-1.5 bg-emerald-200 rounded-full animate-pulse shadow-[0_0_10px_#34d399]" style="animation-delay: -4.8s;"></div>
                <div class="absolute top-[91%] left-[77%] text-teal-300/80 animate-pulse" style="animation-delay: -2.2s;">
                    <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0L14.59 9.41L24 12L14.59 14.59L12 24L9.41 14.59L0 12L9.41 9.41L12 0Z"/></svg>
                </div>
                <div class="absolute top-[93%] left-[35%] w-2 h-2 bg-sky-300 rounded-full animate-pulse shadow-[0_0_12px_#38bdf8]" style="animation-delay: -0.6s;"></div>
                <div class="absolute top-[95%] left-[84%] w-1 h-1 bg-emerald-300 rounded-full animate-pulse shadow-[0_0_8px_#34d399]" style="animation-delay: -3.3s;"></div>
                <div class="absolute top-[97%] left-[56%] text-emerald-300/90 animate-pulse" style="animation-delay: -1.4s;">
                    <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0L14.59 9.41L24 12L14.59 14.59L12 24L9.41 14.59L0 12L9.41 9.41L12 0Z"/></svg>
                </div>
                <div class="absolute top-[99%] left-[20%] w-1.5 h-1.5 bg-teal-200 rounded-full animate-pulse shadow-[0_0_10px_#2dd4bf]" style="animation-delay: -4.0s;"></div>
            </div>

            <!-- LAYER 1: HERO SECTION (0% - 15%) -->
            <div class="absolute top-10 left-1/2 -translate-x-1/2 w-[1300px] h-[650px] bg-gradient-to-tr from-emerald-400/25 via-teal-400/20 to-transparent blur-[110px] rounded-full animate-pulse-slow"></div>
            <!-- Glowing Hero Pills -->
            <div class="absolute top-24 left-4 sm:left-12 w-48 h-16 rounded-full border-2 border-emerald-500 dark:border-emerald-400/60 bg-emerald-100 dark:bg-emerald-950/60 backdrop-blur-sm -rotate-12 shadow-lg shadow-emerald-500/10 dark:shadow-[0_0_25px_rgba(16,185,129,0.35)] animate-float hidden lg:flex items-center justify-center">
                <div class="w-24 h-3 rounded-full bg-emerald-500 dark:bg-emerald-400/50"></div>
            </div>
            <div class="absolute top-44 right-6 sm:right-16 w-56 h-16 rounded-full border-2 border-teal-500 dark:border-teal-400/60 bg-teal-100 dark:bg-teal-950/60 backdrop-blur-sm rotate-6 shadow-lg shadow-teal-500/10 dark:shadow-[0_0_25px_rgba(20,184,166,0.35)] animate-float hidden lg:flex items-center justify-center" style="animation-delay: -3s;">
                <div class="w-28 h-3 rounded-full bg-teal-500 dark:bg-teal-400/50"></div>
            </div>
            <!-- Hero Floating Glowing Diamond Nodes -->
            <div class="absolute top-72 left-1/4 w-14 h-14 rounded-2xl border-2 border-emerald-400 dark:border-emerald-400/70 bg-emerald-100 dark:bg-emerald-950/60 rotate-45 shadow-md dark:shadow-[0_0_20px_rgba(16,185,129,0.4)] animate-float hidden md:block" style="animation-delay: -1.5s;"></div>
            <div class="absolute top-96 right-1/3 w-16 h-16 rounded-2xl border-2 border-teal-400 dark:border-teal-400/70 bg-teal-100 dark:bg-teal-950/60 rotate-12 shadow-md dark:shadow-[0_0_20px_rgba(20,184,166,0.4)] animate-float hidden md:block" style="animation-delay: -4.5s;"></div>

            <!-- Small Hero Shapes -->
            <div class="absolute top-36 left-[18%] w-6 h-6 rounded-lg border border-emerald-400 bg-emerald-200 dark:bg-emerald-900/60 dark:border-emerald-400/80 rotate-12 shadow-sm dark:shadow-[0_0_12px_rgba(16,185,129,0.5)] animate-float hidden sm:block" style="animation-delay: -0.8s;"></div>
            <div class="absolute top-52 right-[22%] w-8 h-8 rounded-full border border-teal-400 bg-teal-200 dark:bg-teal-900/60 dark:border-teal-400/80 shadow-sm dark:shadow-[0_0_12px_rgba(20,184,166,0.5)] animate-float hidden sm:block" style="animation-delay: -2.4s;"></div>
            <div class="absolute top-80 right-[15%] w-5 h-5 rounded-md border border-sky-400 bg-sky-200 dark:bg-sky-900/60 dark:border-sky-400/80 rotate-45 shadow-sm dark:shadow-[0_0_10px_rgba(56,189,248,0.5)] animate-float hidden sm:block" style="animation-delay: -3.8s;"></div>
            <div class="absolute top-[12%] left-[10%] w-7 h-7 rounded-full border border-amber-400 bg-amber-200 dark:bg-amber-900/60 dark:border-amber-400/80 shadow-sm dark:shadow-[0_0_12px_rgba(251,191,36,0.5)] animate-float hidden sm:block" style="animation-delay: -1.2s;"></div>

            <!-- LAYER 2: ABOUT & SERVICES SECTION (15% - 35%) -->
            <div class="absolute top-[16%] -left-32 w-[520px] h-[520px] rounded-[80px] border-2 border-emerald-400 dark:border-emerald-400/50 bg-emerald-100 dark:bg-emerald-950/50 rotate-45 dark:shadow-[0_0_35px_rgba(16,185,129,0.25)]"></div>
            <div class="absolute top-[20%] -right-28 w-[440px] h-[440px] rounded-full border-2 border-teal-400 dark:border-teal-400/50 bg-teal-100 dark:bg-teal-950/50 dark:shadow-[0_0_35px_rgba(20,184,166,0.25)]"></div>
            <div class="absolute top-[26%] left-10 w-40 h-14 rounded-full border-2 border-sky-400 dark:border-sky-400/60 bg-sky-100 dark:bg-sky-950/60 -rotate-6 shadow-md dark:shadow-[0_0_20px_rgba(56,189,248,0.3)] animate-float hidden lg:block" style="animation-delay: -2s;"></div>
            <div class="absolute top-[30%] right-12 w-44 h-14 rounded-full border-2 border-emerald-400 dark:border-emerald-400/60 bg-emerald-100 dark:bg-emerald-950/60 rotate-12 shadow-md dark:shadow-[0_0_20px_rgba(16,185,129,0.3)] animate-float hidden lg:block" style="animation-delay: -5s;"></div>
            <!-- Glowing Concentric Service Ring Accent -->
            <div class="absolute top-[28%] left-1/2 -translate-x-1/2 w-[620px] h-[620px] rounded-full border-2 border-emerald-400 dark:border-emerald-400/45 flex items-center justify-center dark:shadow-[0_0_40px_rgba(16,185,129,0.2)]">
                <div class="w-[440px] h-[440px] rounded-full border-2 border-teal-400 dark:border-teal-400/45 dark:shadow-[0_0_30px_rgba(20,184,166,0.2)]"></div>
            </div>

            <!-- Small Layer 2 Shapes -->
            <div class="absolute top-[18%] left-[32%] w-7 h-7 rounded-xl border border-violet-400 bg-violet-200 dark:bg-violet-900/60 dark:border-violet-400/80 rotate-12 shadow-sm dark:shadow-[0_0_12px_rgba(167,139,250,0.5)] animate-float hidden sm:block" style="animation-delay: -1.7s;"></div>
            <div class="absolute top-[22%] right-[28%] w-6 h-6 rounded-md border border-emerald-400 bg-emerald-200 dark:bg-emerald-900/60 dark:border-emerald-400/80 rotate-45 shadow-sm dark:shadow-[0_0_10px_rgba(16,185,129,0.5)] animate-float hidden sm:block" style="animation-delay: -4.1s;"></div>
            <div class="absolute top-[25%] left-[22%] w-8 h-8 rounded-full border border-sky-400 bg-sky-200 dark:bg-sky-900/60 dark:border-sky-400/80 shadow-sm dark:shadow-[0_0_12px_rgba(56,189,248,0.5)] animate-float hidden sm:block" style="animation-delay: -0.5s;"></div>
            <div class="absolute top-[32%] left-[45%] w-6 h-6 rounded-lg border border-teal-400 bg-teal-200 dark:bg-teal-900/60 dark:border-teal-400/80 rotate-12 shadow-sm dark:shadow-[0_0_10px_rgba(20,184,166,0.5)] animate-float hidden sm:block" style="animation-delay: -3.1s;"></div>
            <div class="absolute top-[34%] right-[38%] w-7 h-7 rounded-full border border-amber-400 bg-amber-200 dark:bg-amber-900/60 dark:border-amber-400/80 shadow-sm dark:shadow-[0_0_12px_rgba(251,191,36,0.5)] animate-float hidden sm:block" style="animation-delay: -2.3s;"></div>

            <!-- LAYER 3: POPULATION STATISTICS SECTION (35% - 55%) -->
            <div class="absolute top-[42%] left-1/2 -translate-x-1/2 w-[850px] h-[850px] rounded-full border-2 border-emerald-400 dark:border-emerald-400/50 flex items-center justify-center dark:shadow-[0_0_50px_rgba(16,185,129,0.25)]">
                <div class="w-[650px] h-[650px] rounded-full border-2 border-teal-400 dark:border-teal-400/50 flex items-center justify-center dark:shadow-[0_0_40px_rgba(20,184,166,0.2)]">
                    <div class="w-[450px] h-[450px] rounded-full border-2 border-sky-400 dark:border-sky-400/50 flex items-center justify-center dark:shadow-[0_0_30px_rgba(56,189,248,0.2)]">
                        <div class="w-[250px] h-[250px] rounded-full border-2 border-emerald-400 dark:border-emerald-400/40"></div>
                    </div>
                </div>
            </div>
            <!-- Statistics Side Geometry -->
            <div class="absolute top-[45%] -left-20 w-72 h-72 rounded-[50px] border-2 border-violet-400 dark:border-violet-400/50 bg-violet-100 dark:bg-violet-950/50 rotate-12 dark:shadow-[0_0_30px_rgba(167,139,250,0.25)]"></div>
            <div class="absolute top-[48%] -right-20 w-80 h-80 rounded-[60px] border-2 border-amber-400 dark:border-amber-400/50 bg-amber-100 dark:bg-amber-950/50 -rotate-12 dark:shadow-[0_0_30px_rgba(251,191,36,0.25)]"></div>

            <!-- Small Layer 3 Shapes -->
            <div class="absolute top-[38%] left-[15%] w-8 h-8 rounded-2xl border border-indigo-400 bg-indigo-200 dark:bg-indigo-900/60 dark:border-indigo-400/80 rotate-45 shadow-sm dark:shadow-[0_0_12px_rgba(129,140,248,0.5)] animate-float hidden sm:block" style="animation-delay: -1.9s;"></div>
            <div class="absolute top-[41%] right-[18%] w-6 h-6 rounded-md border border-emerald-400 bg-emerald-200 dark:bg-emerald-900/60 dark:border-emerald-400/80 rotate-12 shadow-sm dark:shadow-[0_0_10px_rgba(16,185,129,0.5)] animate-float hidden sm:block" style="animation-delay: -4.4s;"></div>
            <div class="absolute top-[46%] left-[35%] w-7 h-7 rounded-full border border-teal-400 bg-teal-200 dark:bg-teal-900/60 dark:border-teal-400/80 shadow-sm dark:shadow-[0_0_12px_rgba(20,184,166,0.5)] animate-float hidden sm:block" style="animation-delay: -0.9s;"></div>
            <div class="absolute top-[50%] right-[32%] w-7 h-7 rounded-lg border border-sky-400 bg-sky-200 dark:bg-sky-900/60 dark:border-sky-400/80 rotate-45 shadow-sm dark:shadow-[0_0_12px_rgba(56,189,248,0.5)] animate-float hidden sm:block" style="animation-delay: -2.8s;"></div>
            <div class="absolute top-[53%] left-[24%] w-6 h-6 rounded-md border border-amber-400 bg-amber-200 dark:bg-amber-900/60 dark:border-amber-400/80 rotate-12 shadow-sm dark:shadow-[0_0_10px_rgba(251,191,36,0.5)] animate-float hidden sm:block" style="animation-delay: -3.5s;"></div>

            <!-- LAYER 4: COUNCIL & PROJECTS SECTION (55% - 75%) -->
            <div class="absolute top-[58%] -right-36 w-[550px] h-[550px] rounded-[90px] border-2 border-amber-400 dark:border-amber-400/45 bg-amber-100 dark:bg-amber-950/40 -rotate-12 dark:shadow-[0_0_35px_rgba(251,191,36,0.2)]"></div>
            <div class="absolute top-[62%] -left-24 w-96 h-96 rounded-[70px] border-2 border-indigo-400 dark:border-indigo-400/45 bg-indigo-100 dark:bg-indigo-950/40 rotate-45 dark:shadow-[0_0_35px_rgba(129,140,248,0.2)]"></div>
            <!-- Floating Mid Solid Glowing Pills -->
            <div class="absolute top-[65%] left-16 w-48 h-16 rounded-full border-2 border-emerald-400 dark:border-emerald-400/60 bg-emerald-100 dark:bg-emerald-950/60 -rotate-6 shadow-md dark:shadow-[0_0_25px_rgba(16,185,129,0.3)] animate-float hidden lg:flex items-center justify-center">
                <div class="w-24 h-3 rounded-full bg-emerald-500 dark:bg-emerald-400/50"></div>
            </div>
            <div class="absolute top-[69%] right-16 w-48 h-16 rounded-full border-2 border-teal-400 dark:border-teal-400/60 bg-teal-100 dark:bg-teal-950/60 rotate-12 shadow-md dark:shadow-[0_0_25px_rgba(20,184,166,0.3)] animate-float hidden lg:flex items-center justify-center" style="animation-delay: -3.5s;">
                <div class="w-24 h-3 rounded-full bg-teal-500 dark:bg-teal-400/50"></div>
            </div>

            <!-- Small Layer 4 Shapes -->
            <div class="absolute top-[56%] right-[25%] w-8 h-8 rounded-full border border-violet-400 bg-violet-200 dark:bg-violet-900/60 dark:border-violet-400/80 shadow-sm dark:shadow-[0_0_12px_rgba(167,139,250,0.5)] animate-float hidden sm:block" style="animation-delay: -1.1s;"></div>
            <div class="absolute top-[60%] left-[28%] w-6 h-6 rounded-md border border-emerald-400 bg-emerald-200 dark:bg-emerald-900/60 dark:border-emerald-400/80 rotate-12 shadow-sm dark:shadow-[0_0_10px_rgba(16,185,129,0.5)] animate-float hidden sm:block" style="animation-delay: -4.7s;"></div>
            <div class="absolute top-[64%] right-[42%] w-7 h-7 rounded-xl border border-sky-400 bg-sky-200 dark:bg-sky-900/60 dark:border-sky-400/80 rotate-45 shadow-sm dark:shadow-[0_0_12px_rgba(56,189,248,0.5)] animate-float hidden sm:block" style="animation-delay: -2.1s;"></div>
            <div class="absolute top-[68%] left-[40%] w-6 h-6 rounded-full border border-teal-400 bg-teal-200 dark:bg-teal-900/60 dark:border-teal-400/80 shadow-sm dark:shadow-[0_0_10px_rgba(20,184,166,0.5)] animate-float hidden sm:block" style="animation-delay: -0.3s;"></div>
            <div class="absolute top-[72%] right-[20%] w-8 h-8 rounded-2xl border border-amber-400 bg-amber-200 dark:bg-amber-900/60 dark:border-amber-400/80 rotate-12 shadow-sm dark:shadow-[0_0_12px_rgba(251,191,36,0.5)] animate-float hidden sm:block" style="animation-delay: -3.9s;"></div>

            <!-- LAYER 5: ORDINANCES & PLACES SECTION (75% - 88%) -->
            <div class="absolute top-[75%] left-1/2 -translate-x-1/2 w-[1000px] h-[500px] bg-gradient-to-r from-emerald-400/20 via-teal-400/18 to-emerald-500/15 blur-[120px] rounded-full"></div>
            <div class="absolute top-[78%] left-8 w-52 h-16 rounded-full border-2 border-sky-400 dark:border-sky-400/60 bg-sky-100 dark:bg-sky-950/60 rotate-12 shadow-md dark:shadow-[0_0_25px_rgba(56,189,248,0.3)] animate-float hidden lg:block" style="animation-delay: -2.5s;"></div>
            <div class="absolute top-[82%] right-10 w-48 h-16 rounded-full border-2 border-emerald-400 dark:border-emerald-400/60 bg-emerald-100 dark:bg-emerald-950/60 -rotate-12 shadow-md dark:shadow-[0_0_25px_rgba(16,185,129,0.3)] animate-float hidden lg:block" style="animation-delay: -4s;"></div>
            <!-- Rotated Solid Diamond Pattern Grid -->
            <div class="absolute top-[80%] left-1/3 w-20 h-20 rounded-2xl border-2 border-teal-400 dark:border-teal-400/60 bg-teal-100 dark:bg-teal-950/60 rotate-45 shadow-sm dark:shadow-[0_0_20px_rgba(20,184,166,0.35)]"></div>
            <div class="absolute top-[84%] right-1/3 w-24 h-24 rounded-3xl border-2 border-emerald-400 dark:border-emerald-400/60 bg-emerald-100 dark:bg-emerald-950/60 -rotate-12 shadow-sm dark:shadow-[0_0_20px_rgba(16,185,129,0.35)]"></div>

            <!-- Small Layer 5 Shapes -->
            <div class="absolute top-[76%] left-[20%] w-7 h-7 rounded-lg border border-emerald-400 bg-emerald-200 dark:bg-emerald-900/60 dark:border-emerald-400/80 rotate-12 shadow-sm dark:shadow-[0_0_12px_rgba(16,185,129,0.5)] animate-float hidden sm:block" style="animation-delay: -1.6s;"></div>
            <div class="absolute top-[79%] right-[22%] w-6 h-6 rounded-full border border-sky-400 bg-sky-200 dark:bg-sky-900/60 dark:border-sky-400/80 shadow-sm dark:shadow-[0_0_10px_rgba(56,189,248,0.5)] animate-float hidden sm:block" style="animation-delay: -3.3s;"></div>
            <div class="absolute top-[83%] left-[42%] w-8 h-8 rounded-2xl border border-teal-400 bg-teal-200 dark:bg-teal-900/60 dark:border-teal-400/80 rotate-45 shadow-sm dark:shadow-[0_0_12px_rgba(20,184,166,0.5)] animate-float hidden sm:block" style="animation-delay: -0.7s;"></div>
            <div class="absolute top-[86%] right-[38%] w-6 h-6 rounded-md border border-indigo-400 bg-indigo-200 dark:bg-indigo-900/60 dark:border-indigo-400/80 rotate-12 shadow-sm dark:shadow-[0_0_10px_rgba(129,140,248,0.5)] animate-float hidden sm:block" style="animation-delay: -4.2s;"></div>

            <!-- LAYER 6: FAQS & CONTACT FOOTER SECTION (88% - 100%) -->
            <div class="absolute top-[89%] -left-44 w-[650px] h-[650px] rounded-full border-2 border-emerald-400 dark:border-emerald-400/50 bg-emerald-100 dark:bg-emerald-950/40 dark:shadow-[0_0_40px_rgba(16,185,129,0.25)]"></div>
            <div class="absolute top-[92%] -right-28 w-[550px] h-[550px] rounded-full border-2 border-teal-400 dark:border-teal-400/50 bg-teal-100 dark:bg-teal-950/40 dark:shadow-[0_0_40px_rgba(20,184,166,0.25)]"></div>
            <div class="absolute top-[94%] right-1/2 translate-x-1/2 w-[1100px] h-[500px] bg-gradient-to-tr from-emerald-500/20 via-teal-500/15 to-zinc-900/5 blur-[130px] rounded-full"></div>

            <!-- Small Layer 6 Shapes -->
            <div class="absolute top-[90%] left-[25%] w-7 h-7 rounded-full border border-emerald-400 bg-emerald-200 dark:bg-emerald-900/60 dark:border-emerald-400/80 shadow-sm dark:shadow-[0_0_12px_rgba(16,185,129,0.5)] animate-float hidden sm:block" style="animation-delay: -2.0s;"></div>
            <div class="absolute top-[93%] right-[25%] w-6 h-6 rounded-lg border border-teal-400 bg-teal-200 dark:bg-teal-900/60 dark:border-teal-400/80 rotate-45 shadow-sm dark:shadow-[0_0_10px_rgba(20,184,166,0.5)] animate-float hidden sm:block" style="animation-delay: -3.7s;"></div>
            <div class="absolute top-[96%] left-[38%] w-8 h-8 rounded-2xl border border-sky-400 bg-sky-200 dark:bg-sky-900/60 dark:border-sky-400/80 rotate-12 shadow-sm dark:shadow-[0_0_12px_rgba(56,189,248,0.5)] animate-float hidden sm:block" style="animation-delay: -1.3s;"></div>
        </div>

        <!-- Header / Navigation Bar -->
        <header class="sticky top-0 z-50 glass-panel border-b border-zinc-200/80 dark:border-zinc-800/80">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between gap-4">
                
                <!-- Municipal Brand Logo -->
                <a href="#" class="flex items-center gap-3.5 group flex-shrink-0">
                    <div class="h-10 w-10 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center text-white font-black text-base shadow-md font-outfit group-hover:scale-105 transition duration-200">
                        BS
                    </div>
                    <div class="min-w-0">
                        <span class="text-lg font-black tracking-tight text-zinc-950 dark:text-white font-outfit truncate block">Brgy. Sambog</span>
                        <span class="text-[10px] text-zinc-500 dark:text-zinc-400 font-bold uppercase tracking-widest block -mt-0.5">Corella, Bohol</span>
                    </div>
                </a>

                <!-- Live Civic Status Indicator -->
                <div class="hidden md:flex items-center gap-2 px-3 py-1 bg-emerald-500/10 border border-emerald-500/20 rounded-full text-xs font-semibold text-emerald-700 dark:text-emerald-400">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                    </span>
                    <span>Hall Open • Mon-Fri 8 AM - 5 PM</span>
                </div>

                <!-- Navigation Links -->
                <nav class="hidden md:flex items-center gap-6 text-xs font-semibold text-zinc-600 dark:text-zinc-300 font-outfit">
                    <a href="#about" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition flex items-center gap-1.5">
                        About
                    </a>
                    <a href="#services" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition flex items-center gap-1.5">
                        Services
                    </a>
                    <a href="#announcements" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition flex items-center gap-1.5">
                        Bulletins
                    </a>

                    <!-- Explore Dropdown Menu -->
                    <div x-data="{ open: false }" class="relative">
                        <button
                            @click="open = !open"
                            @keydown.escape="open = false"
                            :aria-expanded="open"
                            aria-haspopup="true"
                            class="hover:text-emerald-600 dark:hover:text-emerald-400 transition flex items-center gap-1 cursor-pointer focus:outline-none py-2"
                        >
                            <span>Explore</span>
                            <svg class="h-3.5 w-3.5 transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <div
                            x-show="open"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 scale-95 -translate-y-1"
                            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                            x-transition:leave-end="opacity-0 scale-95 -translate-y-1"
                            @click.away="open = false"
                            x-cloak
                            class="absolute left-1/2 -translate-x-1/2 top-full mt-1 w-72 rounded-2xl bg-white dark:bg-zinc-900 border border-zinc-200/80 dark:border-zinc-800 shadow-2xl p-2 z-50 divide-y divide-zinc-100 dark:divide-zinc-800/60"
                        >
                            <div class="py-1 space-y-0.5">
                                <a @click="open = false" href="#demographics" class="flex items-center gap-3 px-3 py-2 rounded-xl hover:bg-zinc-100 dark:hover:bg-zinc-800/70 transition group">
                                    <div class="p-2 rounded-lg bg-sky-500/10 text-sky-600 dark:text-sky-400 group-hover:scale-110 transition">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
                                    </div>
                                    <div>
                                        <div class="text-xs font-bold text-zinc-900 dark:text-white font-outfit">Community Statistics</div>
                                        <div class="text-[10px] text-zinc-400">Live inhabitant population metrics</div>
                                    </div>
                                </a>

                                <a @click="open = false" href="#officials" class="flex items-center gap-3 px-3 py-2 rounded-xl hover:bg-zinc-100 dark:hover:bg-zinc-800/70 transition group">
                                    <div class="p-2 rounded-lg bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 group-hover:scale-110 transition">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                                    </div>
                                    <div>
                                        <div class="text-xs font-bold text-zinc-900 dark:text-white font-outfit">Barangay Council</div>
                                        <div class="text-[10px] text-zinc-400">Local municipal leadership</div>
                                    </div>
                                </a>

                                <a @click="open = false" href="#projects" class="flex items-center gap-3 px-3 py-2 rounded-xl hover:bg-zinc-100 dark:hover:bg-zinc-800/70 transition group">
                                    <div class="p-2 rounded-lg bg-amber-500/10 text-amber-600 dark:text-amber-400 group-hover:scale-110 transition">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m3 0h1m-1 0v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                                    </div>
                                    <div>
                                        <div class="text-xs font-bold text-zinc-900 dark:text-white font-outfit">Community Projects</div>
                                        <div class="text-[10px] text-zinc-400">Roads, lights & facility upgrades</div>
                                    </div>
                                </a>
                            </div>

                            <div class="py-1 space-y-0.5">
                                <a @click="open = false" href="#ordinances" class="flex items-center gap-3 px-3 py-2 rounded-xl hover:bg-zinc-100 dark:hover:bg-zinc-800/70 transition group">
                                    <div class="p-2 rounded-lg bg-indigo-500/10 text-indigo-600 dark:text-indigo-400 group-hover:scale-110 transition">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                    </div>
                                    <div>
                                        <div class="text-xs font-bold text-zinc-900 dark:text-white font-outfit">Local Ordinances</div>
                                        <div class="text-[10px] text-zinc-400">Curfew, waste & noise policies</div>
                                    </div>
                                </a>

                                <a @click="open = false" href="#places" class="flex items-center gap-3 px-3 py-2 rounded-xl hover:bg-zinc-100 dark:hover:bg-zinc-800/70 transition group">
                                    <div class="p-2 rounded-lg bg-teal-500/10 text-teal-600 dark:text-teal-400 group-hover:scale-110 transition">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                    </div>
                                    <div>
                                        <div class="text-xs font-bold text-zinc-900 dark:text-white font-outfit">Places & Landmarks</div>
                                        <div class="text-[10px] text-zinc-400">Local spots & destination guide</div>
                                    </div>
                                </a>

                                <a @click="open = false" href="#faqs" class="flex items-center gap-3 px-3 py-2 rounded-xl hover:bg-zinc-100 dark:hover:bg-zinc-800/70 transition group">
                                    <div class="p-2 rounded-lg bg-violet-500/10 text-violet-600 dark:text-violet-400 group-hover:scale-110 transition">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                    </div>
                                    <div>
                                        <div class="text-xs font-bold text-zinc-900 dark:text-white font-outfit">Help Center & FAQs</div>
                                        <div class="text-[10px] text-zinc-400">Clearances & inhabitant answers</div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>

                    <a href="#contact" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition flex items-center gap-1.5">
                        Contact
                    </a>
                </nav>

                <!-- Actions & Theme Toggle -->
                <div class="flex items-center gap-3">
                    
                    <!-- Theme Selector Dropdown -->
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
                        <button @click="open = !open" type="button" aria-label="Toggle theme menu" class="p-2 rounded-xl bg-zinc-100 hover:bg-zinc-200 dark:bg-zinc-900 dark:hover:bg-zinc-800 border border-zinc-200 dark:border-zinc-800 text-zinc-700 dark:text-zinc-300 transition cursor-pointer">
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

                        <div x-show="open" @click.away="open = false" x-cloak class="absolute right-0 mt-2 w-32 rounded-xl bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 shadow-xl py-1 z-50 text-xs">
                            <button @click="theme = 'light'; open = false" class="w-full text-left px-3 py-1.5 hover:bg-zinc-100 dark:hover:bg-zinc-800 flex items-center gap-2 text-zinc-700 dark:text-zinc-300 font-medium">
                                Light
                            </button>
                            <button @click="theme = 'dark'; open = false" class="w-full text-left px-3 py-1.5 hover:bg-zinc-100 dark:hover:bg-zinc-800 flex items-center gap-2 text-zinc-700 dark:text-zinc-300 font-medium">
                                Dark
                            </button>
                            <button @click="theme = 'system'; open = false" class="w-full text-left px-3 py-1.5 hover:bg-zinc-100 dark:hover:bg-zinc-800 flex items-center gap-2 text-zinc-700 dark:text-zinc-300 font-medium">
                                System
                            </button>
                        </div>
                    </div>

                    @auth
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center px-4 py-2 text-sm font-semibold text-white bg-emerald-600 hover:bg-emerald-700 rounded-xl transition shadow-md shadow-emerald-600/10 font-outfit">
                            Go to Workspace
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-4 py-2 text-sm font-semibold text-white bg-emerald-600 hover:bg-emerald-700 rounded-xl transition shadow-md shadow-emerald-600/10 font-outfit">
                            Access Portal
                        </a>
                    @endauth
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-grow z-10 space-y-24 py-12">

            <!-- HERO SECTION: Bento Grid Hero -->
            <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-stretch">
                    
                    <!-- Left Hero Content (7 cols) -->
                    <div class="lg:col-span-7 flex flex-col justify-center space-y-6">
                        <div class="inline-flex items-center gap-2 w-fit px-3.5 py-1 bg-emerald-500/10 border border-emerald-500/20 text-emerald-700 dark:text-emerald-400 rounded-full text-xs font-bold uppercase tracking-wider font-outfit">
                            <span>Official Municipal Workspace</span>
                        </div>

                        <h1 class="text-4xl sm:text-6xl font-black tracking-tight font-outfit text-zinc-950 dark:text-white leading-[1.1]">
                            Digital Governance for <span class="bg-gradient-to-r from-emerald-600 via-teal-500 to-emerald-400 bg-clip-text text-transparent">Brgy. Sambog</span>
                        </h1>

                        <p class="text-base sm:text-lg text-zinc-600 dark:text-zinc-400 leading-relaxed max-w-2xl font-normal">
                            Welcome to the official inhabitant portal of Barangay Sambog, Corella, Bohol. Schedule document clearances, view live community statistics, and access local municipal services seamlessly.
                        </p>

                        <div class="flex flex-wrap items-center gap-4 pt-2">
                            @auth
                                <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center px-6 py-3.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm rounded-xl transition duration-200 shadow-lg shadow-emerald-600/20 font-outfit">
                                    Open Workspace Dashboard
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-6 py-3.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm rounded-xl transition duration-200 shadow-lg shadow-emerald-600/20 font-outfit">
                                    Access Inhabitant Portal
                                </a>
                                <a href="#services" class="inline-flex items-center justify-center px-5 py-3.5 bg-zinc-100 dark:bg-zinc-900 hover:bg-zinc-200 dark:hover:bg-zinc-800 border border-zinc-200 dark:border-zinc-800 text-zinc-700 dark:text-zinc-300 font-semibold text-sm rounded-xl transition duration-200 font-outfit">
                                    Explore Public Services ↓
                                </a>
                            @endauth
                        </div>
                    </div>

                    <!-- Right Hero Bento Spotlight (5 cols) -->
                    <div class="lg:col-span-5 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-1 gap-4">
                        
                        <!-- Bento Spotlight 1: Quick Stats Snippet -->
                        <div class="glass-panel p-6 rounded-3xl border border-zinc-200/80 dark:border-zinc-800/80 bento-card-glow flex items-center justify-between">
                            <div>
                                <span class="text-xs uppercase font-extrabold tracking-wider text-emerald-600 dark:text-emerald-400 font-outfit">Registered Inhabitants</span>
                                <div class="text-3xl font-black font-outfit text-zinc-950 dark:text-white mt-1 tabular-nums">{{ number_format($totalResidents) }}</div>
                                <span class="text-xs text-zinc-500">Across {{ number_format($totalHouseholds) }} Active Family Units</span>
                            </div>
                            <div class="p-3 bg-emerald-500/10 text-emerald-600 rounded-2xl">
                                <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                        </div>

                        <!-- Bento Spotlight 2: Document Appointment Shortcut -->
                        <div class="glass-panel p-6 rounded-3xl border border-zinc-200/80 dark:border-zinc-800/80 bento-card-glow flex flex-col justify-between space-y-4">
                            <div class="flex items-center justify-between">
                                <span class="text-xs uppercase font-extrabold tracking-wider text-teal-600 dark:text-teal-400 font-outfit">Barangay Documents</span>
                                <span class="px-2 py-0.5 bg-emerald-500/10 text-emerald-600 rounded text-[10px] font-bold">Fast-Track</span>
                            </div>
                            <div>
                                <h3 class="text-base font-bold text-zinc-950 dark:text-white font-outfit">Clearance & Certificate Pickup</h3>
                                <p class="text-xs text-zinc-500 mt-1">Book scheduled document pick-ups without waiting in long queues at the Barangay Hall.</p>
                            </div>
                            <a href="{{ route('login') }}" class="inline-flex items-center gap-2 text-xs font-bold text-emerald-600 dark:text-emerald-400 hover:underline">
                                Request Document Clearance &rarr;
                            </a>
                        </div>

                    </div>
                </div>
            </section>

            <!-- SECTION: About Barangay Sambog -->
            <section id="about" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 scroll-mt-24">
                <div class="glass-panel p-8 sm:p-12 rounded-3xl border border-zinc-200/80 dark:border-zinc-800/80 grid grid-cols-1 lg:grid-cols-12 gap-8 items-center bento-card-glow">
                    <div class="lg:col-span-7 space-y-4">
                        <span class="text-xs uppercase font-extrabold tracking-wider text-emerald-600 dark:text-emerald-400 font-outfit">Local Heritage & Governance</span>
                        <h2 class="text-3xl font-extrabold tracking-tight font-outfit text-zinc-950 dark:text-white">
                            Serving Corella with Innovation & Transparency
                        </h2>
                        <p class="text-sm text-zinc-600 dark:text-zinc-400 leading-relaxed">
                            Barangay Sambog, located in the historic municipality of Corella, Bohol, is dedicated to progressive civic governance. Through our digital inhabitant registry and fast-track appointment system, we empower residents, support vulnerable sectors, and maintain transparent municipal operations across all Purok zones.
                        </p>
                    </div>
                    <div class="lg:col-span-5 grid grid-cols-2 gap-4 text-center">
                        <div class="p-4 bg-zinc-100/80 dark:bg-zinc-900/80 rounded-2xl border border-zinc-200/60 dark:border-zinc-800/60">
                            <div class="text-2xl font-black font-outfit text-emerald-600 dark:text-emerald-400">Purok 1–7</div>
                            <div class="text-xs text-zinc-500 mt-1 font-medium">Community Zones</div>
                        </div>
                        <div class="p-4 bg-zinc-100/80 dark:bg-zinc-900/80 rounded-2xl border border-zinc-200/60 dark:border-zinc-800/60">
                            <div class="text-2xl font-black font-outfit text-emerald-600 dark:text-emerald-400">24/7</div>
                            <div class="text-xs text-zinc-500 mt-1 font-medium">Digital Desk Access</div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- DEV SANDBOX COLLAPSIBLE DRAWER -->
            <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div x-data="{ showSandbox: false }" class="glass-panel rounded-2xl border border-zinc-200/80 dark:border-zinc-800/80 overflow-hidden">
                    <button @click="showSandbox = !showSandbox" class="w-full px-6 py-4 flex items-center justify-between text-left hover:bg-zinc-100/50 dark:hover:bg-zinc-900/50 transition">
                        <div class="flex items-center gap-3">
                            <span class="px-2.5 py-0.5 bg-amber-500/10 text-amber-600 dark:text-amber-400 border border-amber-500/20 text-xs font-bold rounded-md font-mono">DEV</span>
                            <span class="text-sm font-bold text-zinc-800 dark:text-zinc-200 font-outfit">Developer Sandbox Test Accounts</span>
                        </div>
                        <span class="text-xs text-zinc-500 font-medium" x-text="showSandbox ? 'Hide Accounts ▲' : 'Show Accounts ▼'"></span>
                    </button>
                    
                    <div x-show="showSandbox" x-cloak class="px-6 pb-6 pt-2 border-t border-zinc-200/60 dark:border-zinc-800/60">
                        <p class="text-xs text-zinc-500 mb-4">Password for all test roles: <code class="bg-emerald-500/10 text-emerald-600 px-1.5 py-0.5 rounded font-mono font-bold">password</code></p>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 text-xs font-mono">
                            <div class="p-3 bg-zinc-100 dark:bg-zinc-900/80 rounded-xl border border-zinc-200 dark:border-zinc-800">
                                <div class="font-bold font-sans text-zinc-900 dark:text-white">Admin</div>
                                <div class="text-zinc-500 mt-0.5 select-all">admin@barangay.gov</div>
                            </div>
                            <div class="p-3 bg-zinc-100 dark:bg-zinc-900/80 rounded-xl border border-zinc-200 dark:border-zinc-800">
                                <div class="font-bold font-sans text-zinc-900 dark:text-white">Health Admin</div>
                                <div class="text-zinc-500 mt-0.5 select-all">health@barangay.gov</div>
                            </div>
                            <div class="p-3 bg-zinc-100 dark:bg-zinc-900/80 rounded-xl border border-zinc-200 dark:border-zinc-800">
                                <div class="font-bold font-sans text-zinc-900 dark:text-white">Household Head</div>
                                <div class="text-zinc-500 mt-0.5 select-all">head@barangay.gov</div>
                            </div>
                            <div class="p-3 bg-zinc-100 dark:bg-zinc-900/80 rounded-xl border border-zinc-200 dark:border-zinc-800">
                                <div class="font-bold font-sans text-zinc-900 dark:text-white">Resident Member</div>
                                <div class="text-zinc-500 mt-0.5 select-all">resident@barangay.gov</div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- SECTION: Public Municipal Services Bento -->
            <section id="services" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 scroll-mt-24 space-y-8">
                <div class="text-center max-w-2xl mx-auto space-y-2">
                    <span class="text-xs uppercase font-extrabold tracking-wider text-emerald-600 dark:text-emerald-400 font-outfit">Citizen Welfare</span>
                    <h2 class="text-3xl sm:text-4xl font-extrabold tracking-tight font-outfit text-zinc-950 dark:text-white">Public Municipal Services</h2>
                    <p class="text-zinc-500 text-sm">Efficient municipal tools designed to serve every family unit in Brgy. Sambog.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    
                    <div class="glass-panel p-8 rounded-3xl border border-zinc-200/80 dark:border-zinc-800/80 bento-card-glow space-y-4">
                        <div class="p-3 bg-emerald-500/10 text-emerald-600 rounded-2xl w-fit">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold font-outfit text-zinc-950 dark:text-white">Barangay Clearances</h3>
                        <p class="text-sm text-zinc-500 leading-relaxed">
                            Schedule pick-up dates for official clearances, certificates of indigency, and business permits directly online.
                        </p>
                    </div>

                    <div class="glass-panel p-8 rounded-3xl border border-zinc-200/80 dark:border-zinc-800/80 bento-card-glow space-y-4">
                        <div class="p-3 bg-teal-500/10 text-teal-600 rounded-2xl w-fit">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m3 0h1m-1 0v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold font-outfit text-zinc-950 dark:text-white">Household Registry</h3>
                        <p class="text-sm text-zinc-500 leading-relaxed">
                            Verified family heads can review household composition, sync demographic records, and update voter parameters.
                        </p>
                    </div>

                    <div class="glass-panel p-8 rounded-3xl border border-zinc-200/80 dark:border-zinc-800/80 bento-card-glow space-y-4">
                        <div class="p-3 bg-sky-500/10 text-sky-600 rounded-2xl w-fit">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold font-outfit text-zinc-950 dark:text-white">Vulnerable Sector Support</h3>
                        <p class="text-sm text-zinc-500 leading-relaxed">
                            Dedicated monitoring for senior citizens, pediatric nutrition coverages, and local immunization programs.
                        </p>
                    </div>

                </div>
            </section>

            <!-- SECTION: Inhabitant Demographics & Statistics -->
            <section id="demographics" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 scroll-mt-24 space-y-8">
                <div class="text-center max-w-2xl mx-auto space-y-2">
                    <span class="text-xs uppercase font-extrabold tracking-wider text-emerald-600 dark:text-emerald-400 font-outfit">Live Population Metrics</span>
                    <h2 class="text-3xl sm:text-4xl font-extrabold tracking-tight font-outfit text-zinc-950 dark:text-white">Community Statistics</h2>
                    <p class="text-zinc-500 text-sm">Real-time statistics sourced from the official inhabitant registry.</p>
                </div>

                <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
                    
                    <div class="glass-panel p-6 rounded-3xl border border-zinc-200/80 dark:border-zinc-800/80 text-center bento-card-glow space-y-1">
                        <span class="text-xs font-bold uppercase tracking-wider text-sky-600 dark:text-sky-400">Total Residents</span>
                        <div class="text-4xl sm:text-5xl font-black font-outfit text-sky-500 tabular-nums">{{ number_format($totalResidents) }}</div>
                        <span class="text-xs text-zinc-500 font-medium">Registered Citizens</span>
                    </div>

                    <div class="glass-panel p-6 rounded-3xl border border-zinc-200/80 dark:border-zinc-800/80 text-center bento-card-glow space-y-1">
                        <span class="text-xs font-bold uppercase tracking-wider text-amber-600 dark:text-amber-400">Total Households</span>
                        <div class="text-4xl sm:text-5xl font-black font-outfit text-amber-500 tabular-nums">{{ number_format($totalHouseholds) }}</div>
                        <span class="text-xs text-zinc-500 font-medium">Active Family Units</span>
                    </div>

                    <div class="glass-panel p-6 rounded-3xl border border-zinc-200/80 dark:border-zinc-800/80 text-center bento-card-glow space-y-1">
                        <span class="text-xs font-bold uppercase tracking-wider text-violet-600 dark:text-violet-400">Senior Citizens</span>
                        <div class="text-4xl sm:text-5xl font-black font-outfit text-violet-500 tabular-nums">{{ number_format($seniorCitizens) }}</div>
                        <span class="text-xs text-zinc-500 font-medium">Supported Seniors (60+)</span>
                    </div>

                    <div class="glass-panel p-6 rounded-3xl border border-zinc-200/80 dark:border-zinc-800/80 text-center bento-card-glow space-y-1">
                        <span class="text-xs font-bold uppercase tracking-wider text-emerald-600 dark:text-emerald-400">Immunization Rate</span>
                        <div class="text-4xl sm:text-5xl font-black font-outfit text-emerald-500 tabular-nums">{{ $totalResidents > 0 ? number_format(($vaccinatedCount / $totalResidents) * 100, 1) : 0 }}%</div>
                        <span class="text-xs text-zinc-500 font-medium">Vaccinated Inhabitants</span>
                    </div>

                </div>
            </section>

            <!-- SECTION: Local Barangay Council -->
            <section id="officials" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 scroll-mt-24 space-y-8">
                <div class="text-center max-w-2xl mx-auto space-y-2">
                    <span class="text-xs uppercase font-extrabold tracking-wider text-emerald-600 dark:text-emerald-400 font-outfit">Barangay Leadership</span>
                    <h2 class="text-3xl sm:text-4xl font-extrabold tracking-tight font-outfit text-zinc-950 dark:text-white">Local Barangay Council</h2>
                    <p class="text-zinc-500 text-sm">Dedicated public officials serving the community of Brgy. Sambog.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    
                    <div class="glass-panel p-6 rounded-3xl border border-zinc-200/80 dark:border-zinc-800/80 text-center bento-card-glow space-y-3">
                        <div class="h-16 w-16 mx-auto rounded-full bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center text-white font-black text-xl font-outfit shadow-md">
                            RR
                        </div>
                        <div>
                            <h4 class="font-bold text-base text-zinc-950 dark:text-white font-outfit">Hon. Rey Anthony N. Rebuta</h4>
                            <span class="text-xs text-emerald-600 dark:text-emerald-400 font-bold uppercase tracking-wider block mt-0.5">Barangay Captain</span>
                        </div>
                        <p class="text-xs text-zinc-500">Leading community governance and municipal administration.</p>
                    </div>

                    <div class="glass-panel p-6 rounded-3xl border border-zinc-200/80 dark:border-zinc-800/80 text-center bento-card-glow space-y-3">
                        <div class="h-16 w-16 mx-auto rounded-full bg-gradient-to-br from-teal-500 to-sky-600 flex items-center justify-center text-white font-black text-xl font-outfit shadow-md">
                            AS
                        </div>
                        <div>
                            <h4 class="font-bold text-base text-zinc-950 dark:text-white font-outfit">Hon. Alice Smith</h4>
                            <span class="text-xs text-emerald-600 dark:text-emerald-400 font-bold uppercase tracking-wider block mt-0.5">Committee on Health</span>
                        </div>
                        <p class="text-xs text-zinc-500">Coordinating community healthcare and immunization programs.</p>
                    </div>

                    <div class="glass-panel p-6 rounded-3xl border border-zinc-200/80 dark:border-zinc-800/80 text-center bento-card-glow space-y-3">
                        <div class="h-16 w-16 mx-auto rounded-full bg-gradient-to-br from-sky-500 to-indigo-600 flex items-center justify-center text-white font-black text-xl font-outfit shadow-md">
                            AI
                        </div>
                        <div>
                            <h4 class="font-bold text-base text-zinc-950 dark:text-white font-outfit">Arnel T. Itong</h4>
                            <span class="text-xs text-emerald-600 dark:text-emerald-400 font-bold uppercase tracking-wider block mt-0.5">Barangay Treasurer</span>
                        </div>
                        <p class="text-xs text-zinc-500">Managing fiscal resources and development budgets.</p>
                    </div>

                    <div class="glass-panel p-6 rounded-3xl border border-zinc-200/80 dark:border-zinc-800/80 text-center bento-card-glow space-y-3">
                        <div class="h-16 w-16 mx-auto rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-black text-xl font-outfit shadow-md">
                            CD
                        </div>
                        <div>
                            <h4 class="font-bold text-base text-zinc-950 dark:text-white font-outfit">Cecilia S. Daquio</h4>
                            <span class="text-xs text-emerald-600 dark:text-emerald-400 font-bold uppercase tracking-wider block mt-0.5">Barangay Secretary</span>
                        </div>
                        <p class="text-xs text-zinc-500">Handling document processing, records, and appointments.</p>
                    </div>

                </div>
            </section>

            <!-- SECTION: Community Projects -->
            <section id="projects" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 scroll-mt-24 space-y-8">
                <div class="text-center max-w-2xl mx-auto space-y-2">
                    <span class="text-xs uppercase font-extrabold tracking-wider text-emerald-600 dark:text-emerald-400 font-outfit">Infrastructure & Development</span>
                    <h2 class="text-3xl sm:text-4xl font-extrabold tracking-tight font-outfit text-zinc-950 dark:text-white">Community Projects</h2>
                    <p class="text-zinc-500 text-sm">Ongoing and completed development initiatives in Brgy. Sambog.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="glass-panel p-6 rounded-3xl border border-zinc-200/80 dark:border-zinc-800/80 bento-card-glow space-y-3">
                        <span class="px-2 py-0.5 bg-emerald-500/10 text-emerald-600 rounded text-[10px] font-bold uppercase font-outfit">Infrastructure</span>
                        <h3 class="text-xl font-bold font-outfit text-zinc-950 dark:text-white">Purok 3 Road Paving</h3>
                        <p class="text-xs text-zinc-500 leading-relaxed">Paving and drainage upgrades connecting interior purok zones to the municipal highway.</p>
                    </div>
                    <div class="glass-panel p-6 rounded-3xl border border-zinc-200/80 dark:border-zinc-800/80 bento-card-glow space-y-3">
                        <span class="px-2 py-0.5 bg-teal-500/10 text-teal-600 rounded text-[10px] font-bold uppercase font-outfit">Recreation</span>
                        <h3 class="text-xl font-bold font-outfit text-zinc-950 dark:text-white">Covered Court Renovation</h3>
                        <p class="text-xs text-zinc-500 leading-relaxed">Facility improvements and lighting upgrades for community assemblies and sports leagues.</p>
                    </div>
                    <div class="glass-panel p-6 rounded-3xl border border-zinc-200/80 dark:border-zinc-800/80 bento-card-glow space-y-3">
                        <span class="px-2 py-0.5 bg-sky-500/10 text-sky-600 rounded text-[10px] font-bold uppercase font-outfit">Public Safety</span>
                        <h3 class="text-xl font-bold font-outfit text-zinc-950 dark:text-white">Solar Streetlighting</h3>
                        <p class="text-xs text-zinc-500 leading-relaxed">Installation of eco-friendly solar streetlights along main thoroughfares and dark walkways.</p>
                    </div>
                </div>
            </section>

            <!-- SECTION: Local Ordinances -->
            <section id="ordinances" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 scroll-mt-24 space-y-8">
                <div class="text-center max-w-2xl mx-auto space-y-2">
                    <span class="text-xs uppercase font-extrabold tracking-wider text-emerald-600 dark:text-emerald-400 font-outfit">Community Regulations</span>
                    <h2 class="text-3xl sm:text-4xl font-extrabold tracking-tight font-outfit text-zinc-950 dark:text-white">Local Ordinances</h2>
                    <p class="text-zinc-500 text-sm">Key policies enforced to maintain peace, order, and sanitation.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="glass-panel p-6 rounded-3xl border border-zinc-200/80 dark:border-zinc-800/80 bento-card-glow space-y-3">
                        <div class="p-3 bg-indigo-500/10 text-indigo-600 rounded-2xl w-fit">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                        <h3 class="text-xl font-bold font-outfit text-zinc-950 dark:text-white">Curfew Hours</h3>
                        <p class="text-xs text-zinc-500 leading-relaxed">10:00 PM to 4:00 AM for minors to maintain safety and security across all Purok zones.</p>
                    </div>
                    <div class="glass-panel p-6 rounded-3xl border border-zinc-200/80 dark:border-zinc-800/80 bento-card-glow space-y-3">
                        <div class="p-3 bg-emerald-500/10 text-emerald-600 rounded-2xl w-fit">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                        </div>
                        <h3 class="text-xl font-bold font-outfit text-zinc-950 dark:text-white">Waste Segregation</h3>
                        <p class="text-xs text-zinc-500 leading-relaxed">Strict 'No Segregation, No Collection' policy. Biodegradable on Mondays, Non-bio on Thursdays.</p>
                    </div>
                    <div class="glass-panel p-6 rounded-3xl border border-zinc-200/80 dark:border-zinc-800/80 bento-card-glow space-y-3">
                        <div class="p-3 bg-amber-500/10 text-amber-600 rounded-2xl w-fit">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z" /></svg>
                        </div>
                        <h3 class="text-xl font-bold font-outfit text-zinc-950 dark:text-white">Noise Control</h3>
                        <p class="text-xs text-zinc-500 leading-relaxed">Loud audio equipment and karaoke prohibited past 10:00 PM to respect residential quiet hours.</p>
                    </div>
                </div>
            </section>

            <!-- SECTION: Recommended Places & Landmarks (Livewire) -->
            <section id="places" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 scroll-mt-24 space-y-8">
                <div class="text-center max-w-2xl mx-auto space-y-2">
                    <span class="text-xs uppercase font-extrabold tracking-wider text-emerald-600 dark:text-emerald-400 font-outfit">Local Destinations</span>
                    <h2 class="text-3xl sm:text-4xl font-extrabold tracking-tight font-outfit text-zinc-950 dark:text-white">Places & Landmarks</h2>
                    <p class="text-zinc-500 text-sm">Discover recommended spots and municipal landmarks around Corella, Bohol.</p>
                </div>

                <livewire:recommended-places />
            </section>

            <!-- SECTION: Community Announcements (Livewire) -->
            <section id="announcements" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 scroll-mt-24 space-y-8">
                <div class="text-center max-w-2xl mx-auto space-y-2">
                    <span class="text-xs uppercase font-extrabold tracking-wider text-emerald-600 dark:text-emerald-400 font-outfit">Public Bulletins</span>
                    <h2 class="text-3xl sm:text-4xl font-extrabold tracking-tight font-outfit text-zinc-950 dark:text-white">Barangay Announcements</h2>
                    <p class="text-zinc-500 text-sm">Official announcements and updates issued by the Barangay Council.</p>
                </div>

                <livewire:announcements />
            </section>

            <!-- SECTION: FAQs & Help Center -->
            <section id="faqs" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 scroll-mt-24 space-y-12">
                <div class="space-y-6">
                    <div class="text-center max-w-2xl mx-auto space-y-2">
                        <span class="text-xs uppercase font-extrabold tracking-wider text-emerald-600 dark:text-emerald-400 font-outfit">Inhabitant Help Center</span>
                        <h2 class="text-3xl sm:text-4xl font-extrabold tracking-tight font-outfit text-zinc-950 dark:text-white">Frequently Asked Questions</h2>
                        <p class="text-zinc-500 text-sm">Find quick answers to common questions about barangay document requests, household registration, and public services.</p>
                    </div>

                    <!-- Alpine.js Accordion Container -->
                    <div x-data="{ active: 1 }" class="max-w-4xl mx-auto space-y-3">
                        
                        <!-- Question 1 -->
                        <div class="glass-panel rounded-2xl border border-zinc-200/80 dark:border-zinc-800/80 overflow-hidden transition">
                            <button @click="active = (active === 1 ? null : 1)" class="w-full px-6 py-4 flex items-center justify-between text-left focus:outline-none focus:ring-2 focus:ring-emerald-500/50 cursor-pointer">
                                <span class="font-bold text-sm sm:text-base text-zinc-950 dark:text-white font-outfit">How do I request an official Barangay Clearance or Certificate?</span>
                                <svg class="h-5 w-5 text-emerald-600 dark:text-emerald-400 transition-transform duration-200 flex-shrink-0" :class="{ 'rotate-180': active === 1 }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div x-show="active === 1" x-collapse x-cloak class="px-6 pb-5 pt-1 text-xs sm:text-sm text-zinc-600 dark:text-zinc-400 leading-relaxed border-t border-zinc-200/40 dark:border-zinc-800/40">
                                Log in with your registered inhabitant account, navigate to the <strong>Appointments</strong> section, select your required document purpose (such as Clearance, Indigency, or Business Permit), and choose an available pickup schedule. You will receive live status notifications when your request is processed.
                            </div>
                        </div>

                        <!-- Question 2 -->
                        <div class="glass-panel rounded-2xl border border-zinc-200/80 dark:border-zinc-800/80 overflow-hidden transition">
                            <button @click="active = (active === 2 ? null : 2)" class="w-full px-6 py-4 flex items-center justify-between text-left focus:outline-none focus:ring-2 focus:ring-emerald-500/50 cursor-pointer">
                                <span class="font-bold text-sm sm:text-base text-zinc-950 dark:text-white font-outfit">Who is authorized to update family profiles in the Household Registry?</span>
                                <svg class="h-5 w-5 text-emerald-600 dark:text-emerald-400 transition-transform duration-200 flex-shrink-0" :class="{ 'rotate-180': active === 2 }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div x-show="active === 2" x-collapse x-cloak class="px-6 pb-5 pt-1 text-xs sm:text-sm text-zinc-600 dark:text-zinc-400 leading-relaxed border-t border-zinc-200/40 dark:border-zinc-800/40">
                                Only designated <strong>Household Heads</strong> registered in the Registry of Barangay Inhabitants (RBI) have authorization to register dependents or modify family details. Household heads can add new family members, sync demographic parameters, and manage voter records.
                            </div>
                        </div>

                        <!-- Question 3 -->
                        <div class="glass-panel rounded-2xl border border-zinc-200/80 dark:border-zinc-800/80 overflow-hidden transition">
                            <button @click="active = (active === 3 ? null : 3)" class="w-full px-6 py-4 flex items-center justify-between text-left focus:outline-none focus:ring-2 focus:ring-emerald-500/50 cursor-pointer">
                                <span class="font-bold text-sm sm:text-base text-zinc-950 dark:text-white font-outfit">What are the requirements when claiming documents at the Barangay Hall?</span>
                                <svg class="h-5 w-5 text-emerald-600 dark:text-emerald-400 transition-transform duration-200 flex-shrink-0" :class="{ 'rotate-180': active === 3 }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div x-show="active === 3" x-collapse x-cloak class="px-6 pb-5 pt-1 text-xs sm:text-sm text-zinc-600 dark:text-zinc-400 leading-relaxed border-t border-zinc-200/40 dark:border-zinc-800/40">
                                Please bring one valid government-issued ID (or Student ID for minors) along with your appointment confirmation reference. If sending an authorized representative, ensure they present an authorization letter and copies of both valid IDs.
                            </div>
                        </div>

                        <!-- Question 4 -->
                        <div class="glass-panel rounded-2xl border border-zinc-200/80 dark:border-zinc-800/80 overflow-hidden transition">
                            <button @click="active = (active === 4 ? null : 4)" class="w-full px-6 py-4 flex items-center justify-between text-left focus:outline-none focus:ring-2 focus:ring-emerald-500/50 cursor-pointer">
                                <span class="font-bold text-sm sm:text-base text-zinc-950 dark:text-white font-outfit">How do senior citizens and vulnerable sectors access healthcare support?</span>
                                <svg class="h-5 w-5 text-emerald-600 dark:text-emerald-400 transition-transform duration-200 flex-shrink-0" :class="{ 'rotate-180': active === 4 }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div x-show="active === 4" x-collapse x-cloak class="px-6 pb-5 pt-1 text-xs sm:text-sm text-zinc-600 dark:text-zinc-400 leading-relaxed border-t border-zinc-200/40 dark:border-zinc-800/40">
                                Our Barangay Health Administration tracks senior wellness metrics, pediatric nutritional coverage, and immunization programs. Qualified senior citizens and vulnerable inhabitants receive direct announcements for free health check-ups and medical assistance.
                            </div>
                        </div>

                        <!-- Question 5 -->
                        <div class="glass-panel rounded-2xl border border-zinc-200/80 dark:border-zinc-800/80 overflow-hidden transition">
                            <button @click="active = (active === 5 ? null : 5)" class="w-full px-6 py-4 flex items-center justify-between text-left focus:outline-none focus:ring-2 focus:ring-emerald-500/50 cursor-pointer">
                                <span class="font-bold text-sm sm:text-base text-zinc-950 dark:text-white font-outfit">What are the Barangay Hall operating hours?</span>
                                <svg class="h-5 w-5 text-emerald-600 dark:text-emerald-400 transition-transform duration-200 flex-shrink-0" :class="{ 'rotate-180': active === 5 }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div x-show="active === 5" x-collapse x-cloak class="px-6 pb-5 pt-1 text-xs sm:text-sm text-zinc-600 dark:text-zinc-400 leading-relaxed border-t border-zinc-200/40 dark:border-zinc-800/40">
                                The Barangay Hall is open Monday through Friday from 8:00 AM to 5:00 PM (closed on Philippine public holidays). Our online portal for document appointment scheduling and community announcements remains accessible 24/7.
                            </div>
                        </div>

                    </div>
                </div>
            </section>

            <!-- SECTION: Contact Us & Emergency Hotlines -->
            <section id="contact" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 scroll-mt-24 space-y-8">
                <span id="contacts"></span>
                
                <div class="text-center max-w-2xl mx-auto space-y-2">
                    <span class="text-xs uppercase font-extrabold tracking-wider text-emerald-600 dark:text-emerald-400 font-outfit">Get In Touch</span>
                    <h2 class="text-3xl sm:text-4xl font-extrabold tracking-tight font-outfit text-zinc-950 dark:text-white">Contact & Location</h2>
                    <p class="text-zinc-500 text-sm">Reach out to the Barangay Secretary desk or visit our hall during operating hours.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    
                    <!-- Card 1: Official Desk -->
                    <div class="glass-panel p-6 rounded-3xl border border-zinc-200/80 dark:border-zinc-800/80 bento-card-glow space-y-3">
                        <div class="p-3 bg-emerald-500/10 text-emerald-600 rounded-2xl w-fit">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m3 0h1m-1 0v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                        <h4 class="font-bold text-lg text-zinc-950 dark:text-white font-outfit">Barangay Hall</h4>
                        <p class="text-xs text-zinc-500 leading-relaxed">Barangay Hall, Sambog<br>Corella, Bohol 6337, Philippines</p>
                        <span class="text-xs text-emerald-600 dark:text-emerald-400 font-bold block pt-1">Mon – Fri: 8:00 AM – 5:00 PM</span>
                    </div>

                    <!-- Card 2: Phone & Email -->
                    <div class="glass-panel p-6 rounded-3xl border border-zinc-200/80 dark:border-zinc-800/80 bento-card-glow space-y-3">
                        <div class="p-3 bg-teal-500/10 text-teal-600 rounded-2xl w-fit">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                        </div>
                        <h4 class="font-bold text-lg text-zinc-950 dark:text-white font-outfit">Official Communications</h4>
                        <p class="text-xs text-zinc-500 leading-relaxed">
                            Phone: <a href="tel:09123456789" class="text-zinc-800 dark:text-zinc-200 font-medium hover:underline">(0912) 345-6789</a><br>
                            Email: <a href="mailto:info@barangaysambog.gov.ph" class="text-zinc-800 dark:text-zinc-200 font-medium hover:underline">info@barangaysambog.gov.ph</a>
                        </p>
                        <span class="text-xs text-teal-600 dark:text-teal-400 font-bold block pt-1">Secretary Office Desk</span>
                    </div>

                    <!-- Card 3: 24/7 Hotline -->
                    <div class="p-6 rounded-3xl bg-gradient-to-br from-emerald-900 via-teal-900 to-zinc-900 text-white space-y-3 bento-card-glow flex flex-col justify-between">
                        <div class="space-y-2">
                            <span class="px-2.5 py-0.5 bg-red-500/20 text-red-300 border border-red-500/30 rounded text-[10px] font-bold uppercase tracking-wider font-outfit">24/7 Hotline</span>
                            <h4 class="font-bold text-lg text-white font-outfit">Emergency Response</h4>
                            <p class="text-xs text-zinc-300 leading-relaxed">For immediate peace, order, or safety emergencies in any Purok zone.</p>
                        </div>
                        <a href="tel:09123456789" class="inline-flex items-center justify-center px-4 py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white font-bold text-xs rounded-xl transition font-outfit">
                            📞 Dial Emergency Hotline
                        </a>
                    </div>

                </div>
            </section>

        </main>

        <!-- Footer -->
        <footer class="border-t border-zinc-200/80 dark:border-zinc-800/80 bg-zinc-100/50 dark:bg-zinc-900/50 py-12 text-zinc-600 dark:text-zinc-400 text-xs">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="space-y-3">
                    <div class="flex items-center gap-2 font-bold text-zinc-950 dark:text-white font-outfit text-base">
                        <div class="h-6 w-6 rounded-lg bg-emerald-600 text-white flex items-center justify-center text-xs font-black">BS</div>
                        <span>Brgy. Sambog</span>
                    </div>
                    <p class="text-zinc-500 leading-relaxed">Official Municipal Inhabitant Portal of Barangay Sambog, Municipality of Corella, Province of Bohol.</p>
                </div>
                
                <div>
                    <h5 class="font-bold text-zinc-950 dark:text-white font-outfit mb-3">Quick Navigation</h5>
                    <ul class="space-y-2">
                        <li><a href="#about" class="hover:text-emerald-600 transition">About Us</a></li>
                        <li><a href="#services" class="hover:text-emerald-600 transition">Public Services</a></li>
                        <li><a href="#demographics" class="hover:text-emerald-600 transition">Inhabitant Statistics</a></li>
                        <li><a href="#officials" class="hover:text-emerald-600 transition">Local Council</a></li>
                        <li><a href="#projects" class="hover:text-emerald-600 transition">Projects</a></li>
                        <li><a href="#ordinances" class="hover:text-emerald-600 transition">Ordinances</a></li>
                        <li><a href="#places" class="hover:text-emerald-600 transition">Places</a></li>
                        <li><a href="#announcements" class="hover:text-emerald-600 transition">Announcements</a></li>
                    </ul>
                </div>

                <div>
                    <h5 class="font-bold text-zinc-950 dark:text-white font-outfit mb-3">Operating Hours</h5>
                    <p class="text-zinc-500 leading-relaxed">Monday – Friday<br>8:00 AM – 5:00 PM<br>(Closed on Public Holidays)</p>
                </div>

                <div>
                    <h5 class="font-bold text-zinc-950 dark:text-white font-outfit mb-3">Location</h5>
                    <p class="text-zinc-500 leading-relaxed">Barangay Hall, Sambog, Corella, Bohol 6337, Philippines</p>
                </div>
            </div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-12 pt-6 border-t border-zinc-200/60 dark:border-zinc-800/60 flex flex-col sm:flex-row items-center justify-between gap-4">
                <p>&copy; {{ date('Y') }} Barangay Sambog, Corella, Bohol. All rights reserved.</p>
                <p class="text-zinc-400">Powered by Modern Civic Systems</p>
            </div>
        </footer>

        @livewireScripts
    </body>
</html>
