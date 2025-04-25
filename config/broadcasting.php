<?php

return [

    /*
    |----------------------------------------------------------------------
    | Default Broadcaster
    |----------------------------------------------------------------------
    */
    'default' => env('BROADCAST_DRIVER', 'reverb'),  // Default to Reverb

    /*
    |----------------------------------------------------------------------
    | Broadcast Connections
    |----------------------------------------------------------------------
    */
    'connections' => [

        'reverb' => [
            'driver' => 'reverb',
            'key' => env('REVERB_APP_KEY'),
            'secret' => env('REVERB_APP_SECRET'),
            'app_id' => env('REVERB_APP_ID'),
            'options' => [
                'host' => env('REVERB_HOST'),
                'port' => env('REVERB_PORT', 6001),
                'scheme' => env('REVERB_SCHEME', 'ws'),
                'useTLS' => env('REVERB_SCHEME', 'https') === 'https',
            ],
        ],

        // Remove the Pusher connection if you're using Reverb exclusively.
        'pusher' => [
            'driver' => 'pusher',
            'key' => env('PUSHER_APP_KEY'),
            'secret' => env('PUSHER_APP_SECRET'),
            'app_id' => env('PUSHER_APP_ID'),
            'options' => [
                'cluster' => env('PUSHER_APP_CLUSTER'),
                'host' => env('PUSHER_HOST') ?: 'api-'.env('PUSHER_APP_CLUSTER', 'mt1').'.pusher.com',
                'port' => env('PUSHER_PORT', 443),
                'scheme' => env('PUSHER_SCHEME', 'https'),
                'encrypted' => true,
                'useTLS' => env('PUSHER_SCHEME', 'https') === 'https',
            ],
        ],
    ],
];

