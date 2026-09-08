// Minimal application bootstrap
// Restore app-level JS here. Import shared modules so the bundle
// isn't empty (previously this file was removed/cleared).
import './passkeys';

// Add additional app initialization below as needed.
import Chart from 'chart.js/auto';

// Ensure Chart constructor is properly bound across ESM/CJS interop wrappers
const ChartClass = (Chart && Chart.Chart) ? Chart.Chart : ((Chart && Chart.default) ? Chart.default : Chart);
window.Chart = ChartClass;

// Core chart renderer & lifecycle manager
window.renderChartWhenReady = function (canvasId, configCallback, attempts = 0) {
    const init = () => {
        const canvas = typeof canvasId === 'string' ? document.getElementById(canvasId) : canvasId;
        if (!canvas) {
            if (attempts < 50) {
                setTimeout(() => window.renderChartWhenReady(canvasId, configCallback, attempts + 1), 50);
            }
            return;
        }

        const ActiveChart = window.Chart || ChartClass;
        if (!ActiveChart || typeof ActiveChart !== 'function') {
            if (attempts < 50) {
                setTimeout(() => window.renderChartWhenReady(canvasId, configCallback, attempts + 1), 50);
            }
            return;
        }

        // Destroy existing Chart instance on canvas if present to avoid canvas reuse errors
        if (typeof ActiveChart.getChart === 'function') {
            const existingChart = ActiveChart.getChart(canvas) || (typeof canvasId === 'string' ? ActiveChart.getChart(canvasId) : null);
            if (existingChart) {
                existingChart.destroy();
            }
        }

        try {
            // Execute config callback (populates labels, legend HTML, summary text, etc.)
            const config = typeof configCallback === 'function' ? configCallback() : configCallback;
            if (config) {
                new ActiveChart(canvas, config);
            }
        } catch (err) {
            console.error('Error rendering chart on canvas ' + (typeof canvasId === 'string' ? canvasId : 'element') + ':', err);
        }
    };

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init, { once: true });
    } else {
        init();
    }
};

// Drain and execute any early chart render requests queued before app.js loaded
const drainChartQueue = () => {
    if (Array.isArray(window._chartQueue) && window._chartQueue.length > 0) {
        const queue = window._chartQueue.splice(0, window._chartQueue.length);
        queue.forEach(item => {
            window.renderChartWhenReady(item.canvasId, item.configCallback);
        });
    }
};

// Function to trigger all charts registered with data-chart-init
const initAllCharts = () => {
    drainChartQueue();
    document.querySelectorAll('[data-chart-init]').forEach(el => {
        const fnName = el.getAttribute('data-chart-init');
        if (typeof window[fnName] === 'function') {
            window[fnName](el);
        }
    });
};

// Run chart initialization on DOM ready / initial page load
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initAllCharts);
} else {
    initAllCharts();
}

// Re-initialize charts registered with data-chart-init upon Livewire SPA page navigation
document.addEventListener('livewire:navigated', initAllCharts);
document.addEventListener('livewire:initialized', initAllCharts);

// Dynamically re-render charts when dark/light appearance theme changes
if (typeof window !== 'undefined' && window.MutationObserver) {
    let themeDebounceTimer = null;
    const themeObserver = new MutationObserver((mutations) => {
        for (const mutation of mutations) {
            if (mutation.type === 'attributes' && mutation.attributeName === 'class') {
                clearTimeout(themeDebounceTimer);
                themeDebounceTimer = setTimeout(initAllCharts, 80);
                break;
            }
        }
    });
    themeObserver.observe(document.documentElement, { attributes: true, attributeFilter: ['class'] });
}
if (typeof window !== 'undefined' && window.matchMedia) {
    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', initAllCharts);
}

import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allow your team to quickly build robust real-time web applications.
 */

import './echo';
