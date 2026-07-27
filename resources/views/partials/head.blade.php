<!-- Chart.js Standalone Library for Instant Head Initialization -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

<!-- Theme Initialization & Robust Chart Lifecycle Manager -->
<script>
    (function() {
        const theme = localStorage.getItem('flux.appearance') || localStorage.getItem('theme') || 'system';
        if (theme === 'dark' || (theme === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    })();

    // Robust chart renderer accessible by inline Blade scripts and app.js
    window.renderChartWhenReady = window.renderChartWhenReady || function (canvasId, configCallback, attempts = 0) {
        const init = () => {
            const canvas = typeof canvasId === 'string' ? document.getElementById(canvasId) : canvasId;
            if (!canvas) {
                if (attempts < 50) {
                    setTimeout(() => window.renderChartWhenReady(canvasId, configCallback, attempts + 1), 50);
                }
                return;
            }

            const ChartClass = window.Chart ? (window.Chart.Chart || window.Chart.default || window.Chart) : null;
            if (!ChartClass || typeof ChartClass !== 'function') {
                if (attempts < 50) {
                    setTimeout(() => window.renderChartWhenReady(canvasId, configCallback, attempts + 1), 50);
                }
                return;
            }

            try {
                if (typeof ChartClass.getChart === 'function') {
                    const existingChart = ChartClass.getChart(canvas);
                    if (existingChart) {
                        existingChart.destroy();
                    }
                }

                const config = typeof configCallback === 'function' ? configCallback() : configCallback;
                if (config) {
                    new ChartClass(canvas, config);
                }
            } catch (err) {
                console.error('Error rendering chart on canvas ' + canvasId + ':', err);
            }
        };

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', init, { once: true });
        } else {
            init();
        }
    };
</script>

<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>
    {{ filled($title ?? null) ? $title.' - '.config('app.name', 'Laravel') : config('app.name', 'Laravel') }}
</title>

<link rel="icon" href="/favicon.ico" sizes="any">
<link rel="icon" href="/favicon.svg" type="image/svg+xml">
<link rel="apple-touch-icon" href="/apple-touch-icon.png">

{{-- Instrument Sans via Bunny Fonts CDN (no build-time download required) --}}
<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

@vite(['resources/css/app.css', 'resources/js/app.js'])
@fluxAppearance

