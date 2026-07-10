const Pusher = require('pusher-js');

const pusher = new Pusher('my_reverb_key', {
    wsHost: '127.0.0.1',
    wsPort: 8080,
    forceTLS: false,
    disableStats: true,
    enabledTransports: ['ws']
});

pusher.connection.bind('connected', () => {
    console.log('Connected to Reverb!');
});

pusher.connection.bind('error', (err) => {
    console.error('Connection error:', err);
});

const channel = pusher.subscribe('public-test-channel');

channel.bind('test_event', (data) => {
    console.log('Received test_event:', data);
});

channel.bind('pusher:subscription_succeeded', () => {
    console.log('Successfully subscribed to public-test-channel!');
});
