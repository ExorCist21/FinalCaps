import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

// Reverb does not need Pusher, so remove it from here.
window.Echo = new Echo({
    broadcaster: 'reverb',
    key: process.env.VITE_REVERB_APP_KEY,  // Use your REVERB_APP_KEY from .env
    encrypted: true,  // Set to true if using 'wss://'
    authEndpoint: '/broadcasting/auth',
    auth: {
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    },
    host: process.env.VITE_REVERB_HOST,  // Use REVERB_HOST from .env
    port: process.env.VITE_REVERB_PORT,  // Use REVERB_PORT from .env
    scheme: process.env.VITE_REVERB_SCHEME  // Use REVERB_SCHEME from .env
});
