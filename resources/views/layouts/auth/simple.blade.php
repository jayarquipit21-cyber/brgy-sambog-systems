<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')

        <!-- Theme init: prevents flash of wrong theme, mirrors homepage logic -->
        <script>
            (function () {
                const theme = localStorage.getItem('flux.appearance') || localStorage.getItem('theme') || 'system';
                if (theme === 'dark' || (theme === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                    document.documentElement.classList.add('dark');
                } else {
                    document.documentElement.classList.remove('dark');
                }
            })();
        </script>

        <style>
            /* ─────────────────────────────────────────
               AUTH PAGE BACKGROUND — Light mode base
            ───────────────────────────────────────── */
            .auth-bg {
                background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 30%, #99f6e4 65%, #e0f2fe 100%);
                position: relative;
                overflow: hidden;
                transition: background 0.4s ease;
            }

            /* Animated dot-grid mesh */
            .auth-mesh {
                position: absolute;
                inset: 0;
                background-image: radial-gradient(circle, rgba(4,120,87,0.13) 1px, transparent 1px);
                background-size: 28px 28px;
                animation: meshDrift 20s linear infinite;
            }
            @keyframes meshDrift {
                0%   { background-position: 0 0; }
                100% { background-position: 56px 56px; }
            }

            /* Floating glow orbs — light */
            .orb {
                position: absolute;
                border-radius: 50%;
                filter: blur(80px);
                animation: orbFloat 8s ease-in-out infinite alternate;
            }
            .orb-1 {
                width: 420px; height: 420px;
                background: radial-gradient(circle, rgba(52,211,153,0.55) 0%, rgba(5,150,105,0.35) 60%, transparent 80%);
                top: -120px; left: -100px;
                animation-duration: 9s;
            }
            .orb-2 {
                width: 360px; height: 360px;
                background: radial-gradient(circle, rgba(45,212,191,0.5) 0%, rgba(13,148,136,0.3) 60%, transparent 80%);
                bottom: -100px; right: -80px;
                animation-duration: 11s;
                animation-delay: -3s;
            }
            .orb-3 {
                width: 260px; height: 260px;
                background: radial-gradient(circle, rgba(110,231,183,0.4) 0%, rgba(16,185,129,0.25) 60%, transparent 80%);
                top: 45%; left: 55%;
                animation-duration: 7s;
                animation-delay: -5s;
            }
            @keyframes orbFloat {
                0%   { transform: translate(0, 0) scale(1); }
                100% { transform: translate(20px, 25px) scale(1.06); }
            }

            /* Top shimmer line */
            .auth-shimmer {
                position: absolute;
                top: 0; left: 0; right: 0;
                height: 1.5px;
                background: linear-gradient(90deg, transparent, rgba(16,185,129,0.8), transparent);
                animation: shimmerSlide 4s ease-in-out infinite;
            }
            @keyframes shimmerSlide {
                0%,100% { opacity: 0.4; transform: scaleX(0.5); }
                50%      { opacity: 1;   transform: scaleX(1); }
            }

            /* Glassmorphism card — light mode */
            .auth-card {
                background: rgba(255, 255, 255, 0.75);
                backdrop-filter: blur(20px);
                -webkit-backdrop-filter: blur(20px);
                border: 1px solid rgba(16, 185, 129, 0.22);
                border-radius: 1.5rem;
                box-shadow:
                    0 0 0 1px rgba(16,185,129,0.08),
                    0 25px 60px -10px rgba(0,0,0,0.12),
                    0 0 60px -20px rgba(16,185,129,0.2);
                transition: background 0.4s ease, border-color 0.4s ease, box-shadow 0.4s ease;
            }

            /* Brand badge — light */
            .auth-brand-badge {
                display: inline-flex;
                align-items: center;
                gap: 6px;
                padding: 4px 14px;
                border-radius: 9999px;
                background: rgba(16,185,129,0.15);
                border: 1px solid rgba(16,185,129,0.4);
                color: #047857;
                font-size: 0.65rem;
                font-weight: 700;
                letter-spacing: 0.12em;
                text-transform: uppercase;
                transition: color 0.3s ease, background 0.3s ease, border-color 0.3s ease;
            }

            /* Site name — light */
            .auth-site-name {
                color: #064e3b;
                font-weight: 700;
                font-size: 0.875rem;
                tracking: tight;
                line-height: 1.25;
                transition: color 0.3s ease;
            }

            /* Logo gradient icon */
            .auth-logo-wrap {
                background: linear-gradient(135deg, #34d399 0%, #2dd4bf 100%);
                border-radius: 0.875rem;
                width: 48px; height: 48px;
                display: flex; align-items: center; justify-content: center;
                box-shadow: 0 8px 24px -4px rgba(16,185,129,0.45);
                font-family: 'Outfit', sans-serif;
                font-weight: 900;
                color: white;
                font-size: 1.1rem;
                transition: transform 0.3s ease;
            }

            /* ─────────────────────────────────────────
               DARK MODE OVERRIDES
            ───────────────────────────────────────── */
            .dark .auth-bg {
                background: linear-gradient(135deg, #052e16 0%, #064e3b 40%, #0d3b2e 70%, #09090b 100%);
            }

            .dark .auth-mesh {
                background-image: radial-gradient(circle, rgba(52,211,153,0.09) 1px, transparent 1px);
            }

            .dark .orb-1 {
                background: radial-gradient(circle, #34d399 0%, #059669 60%, transparent 80%);
                opacity: 0.55;
            }
            .dark .orb-2 {
                background: radial-gradient(circle, #2dd4bf 0%, #0d9488 60%, transparent 80%);
                opacity: 0.55;
            }
            .dark .orb-3 {
                background: radial-gradient(circle, #6ee7b7 0%, #10b981 60%, transparent 80%);
                opacity: 0.3;
            }

            .dark .auth-card {
                background: rgba(9, 20, 14, 0.72);
                border-color: rgba(52, 211, 153, 0.18);
                box-shadow:
                    0 0 0 1px rgba(52,211,153,0.06),
                    0 25px 60px -10px rgba(0,0,0,0.7),
                    0 0 80px -20px rgba(16,185,129,0.25);
            }

            .dark .auth-brand-badge {
                background: rgba(52,211,153,0.12);
                border-color: rgba(52,211,153,0.3);
                color: #6ee7b7;
            }

            .dark .auth-site-name {
                color: #ffffff;
            }
        </style>
    </head>
    <body class="min-h-screen antialiased">

        <!-- Branded full-page background -->
        <div class="auth-bg min-h-screen flex flex-col items-center justify-center p-6 md:p-10">

            <!-- Animated layers -->
            <div class="auth-mesh"></div>
            <div class="orb orb-1"></div>
            <div class="orb orb-2"></div>
            <div class="orb orb-3"></div>
            <div class="auth-shimmer"></div>

            <!-- Content -->
            <div class="relative z-10 flex w-full max-w-sm flex-col gap-6">

                <!-- Branding header -->
                <div class="flex flex-col items-center gap-3 text-center">
                    <a href="{{ route('home') }}" class="flex flex-col items-center gap-3 group">
                        <div class="auth-logo-wrap group-hover:scale-105">BC</div>
                        <div class="space-y-1">
                            <div class="auth-site-name">Brgy. Sambog, Corella, Bohol</div>
                            <div class="auth-brand-badge">
                                <span class="h-1.5 w-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                Official Inhabitant Portal
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Glass card wrapping the slot -->
                <div class="auth-card p-8">
                    {{ $slot }}
                </div>

            </div>
        </div>

        @persist('toast')
            <flux:toast.group>
                <flux:toast />
            </flux:toast.group>
        @endpersist

        @fluxScripts
    </body>
</html>
