// Minimal application bootstrap
// Restore app-level JS here. Import shared modules so the bundle
// isn't empty (previously this file was removed/cleared).
import './passkeys';

// Add additional app initialization below as needed.
import Chart from 'chart.js/auto';
window.Chart = Chart;

// Safe chart renderer & lifecycle manager for Chart.js
window.renderChartWhenReady = function (canvasId, configCallback, attempts = 0) {
    const init = () => {
        const canvas = typeof canvasId === 'string' ? document.getElementById(canvasId) : canvasId;
        if (!canvas) return;

        // Destroy existing Chart instance attached to canvas if present
        if (window.Chart && typeof window.Chart.getChart === 'function') {
            const existingChart = window.Chart.getChart(canvas);
            if (existingChart) {
                existingChart.destroy();
            }
        }

        const config = typeof configCallback === 'function' ? configCallback() : configCallback;
        if (config && window.Chart) {
            new window.Chart(canvas, config);
        }
    };

    if (typeof window.Chart !== 'undefined') {
        init();
    } else if (attempts < 50) {
        setTimeout(() => window.renderChartWhenReady(canvasId, configCallback, attempts + 1), 50);
    }
};

// Re-initialize charts registered with data-chart-init upon Livewire SPA page navigation
document.addEventListener('livewire:navigated', () => {
    document.querySelectorAll('[data-chart-init]').forEach(el => {
        const fnName = el.getAttribute('data-chart-init');
        if (typeof window[fnName] === 'function') {
            window[fnName]();
        }
    });
});

import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allow your team to quickly build robust real-time web applications.
 */

import './echo';
