<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
        <style>
            /* ── Auth page brand design ── */
            .auth-bg {
                background: linear-gradient(135deg, #052e16 0%, #064e3b 40%, #0d3b2e 70%, #09090b 100%);
                position: relative;
                overflow: hidden;
            }

            /* Animated dot-grid mesh */
            .auth-mesh {
                position: absolute;
                inset: 0;
                background-image: radial-gradient(circle, rgba(52,211,153,0.09) 1px, transparent 1px);
                background-size: 28px 28px;
                animation: meshDrift 20s linear infinite;
            }
            @keyframes meshDrift {
                0%   { background-position: 0 0; }
                100% { background-position: 56px 56px; }
            }

            /* Floating glow orbs */
            .orb {
                position: absolute;
                border-radius: 50%;
                filter: blur(80px);
                opacity: 0.55;
                animation: orbFloat 8s ease-in-out infinite alternate;
            }
            .orb-1 {
                width: 420px; height: 420px;
                background: radial-gradient(circle, #34d399 0%, #059669 60%, transparent 80%);
                top: -120px; left: -100px;
                animation-duration: 9s;
            }
            .orb-2 {
                width: 360px; height: 360px;
                background: radial-gradient(circle, #2dd4bf 0%, #0d9488 60%, transparent 80%);
                bottom: -100px; right: -80px;
                animation-duration: 11s;
                animation-delay: -3s;
            }
            .orb-3 {
                width: 260px; height: 260px;
                background: radial-gradient(circle, #6ee7b7 0%, #10b981 60%, transparent 80%);
                top: 45%; left: 55%;
                animation-duration: 7s;
                animation-delay: -5s;
                opacity: 0.3;
            }
            @keyframes orbFloat {
                0%   { transform: translate(0, 0) scale(1); }
                100% { transform: translate(20px, 25px) scale(1.06); }
            }

            /* Top shimmer line */
            .auth-shimmer {
                position: absolute;
                top: 0; left: 0; right: 0;
                height: 1px;
                background: linear-gradient(90deg, transparent, rgba(52,211,153,0.7), transparent);
                animation: shimmerSlide 4s ease-in-out infinite;
            }
            @keyframes shimmerSlide {
                0%,100% { opacity: 0.4; transform: scaleX(0.5); }
                50%      { opacity: 1;   transform: scaleX(1); }
            }

            /* Glassmorphism card */
            .auth-card {
                background: rgba(9, 20, 14, 0.72);
                backdrop-filter: blur(20px);
                -webkit-backdrop-filter: blur(20px);
                border: 1px solid rgba(52, 211, 153, 0.18);
                border-radius: 1.5rem;
                box-shadow:
                    0 0 0 1px rgba(52,211,153,0.06),
                    0 25px 60px -10px rgba(0,0,0,0.7),
                    0 0 80px -20px rgba(16,185,129,0.25);
            }

            /* Brand badge */
            .auth-brand-badge {
                display: inline-flex;
                align-items: center;
                gap: 6px;
                padding: 4px 14px;
                border-radius: 9999px;
                background: rgba(52,211,153,0.12);
                border: 1px solid rgba(52,211,153,0.3);
                color: #6ee7b7;
                font-size: 0.65rem;
                font-weight: 700;
                letter-spacing: 0.12em;
                text-transform: uppercase;
            }

            /* Logo gradient icon bg */
            .auth-logo-wrap {
                background: linear-gradient(135deg, #34d399 0%, #2dd4bf 100%);
                border-radius: 0.875rem;
                width: 48px; height: 48px;
                display: flex; align-items: center; justify-content: center;
                box-shadow: 0 8px 24px -4px rgba(16,185,129,0.5);
                font-family: 'Outfit', sans-serif;
                font-weight: 900;
                color: white;
                font-size: 1.1rem;
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
                        <div class="auth-logo-wrap group-hover:scale-105 transition-transform duration-300">BC</div>
                        <div class="space-y-0.5">
                            <div class="text-white font-bold text-sm tracking-tight leading-tight">Brgy. Sambog, Corella, Bohol</div>
                            <div class="auth-brand-badge">
                                <span class="h-1.5 w-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
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
