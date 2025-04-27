import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

Alpine.start();
