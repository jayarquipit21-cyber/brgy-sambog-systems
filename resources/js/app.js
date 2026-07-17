// Minimal application bootstrap
// Restore app-level JS here. Import shared modules so the bundle
// isn't empty (previously this file was removed/cleared).
import './passkeys';

// Add additional app initialization below as needed.
import Chart from 'chart.js/auto';
window.Chart = Chart;

import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allow your team to quickly build robust real-time web applications.
 */

import './echo';
