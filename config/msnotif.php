<?php

return [
    /** Default */
    'channel' => env('MSNOTIF_CHANNEL', 'woowa'),

    /** Allow sending from local environment */
    'allow_local' => (bool) env('MSNOTIF_ALLOW_LOCAL', false),

    'log' => [
        'trace' => (bool) env('MSNOTIF_LOG_TRACE', false),
    ],

    /** Sender */
    'sender' => [
        'wauwa' => env('MSNOTIF_WAUWA_SENDER', 'anonymous'),
        'woowa_eco' => env('MSNOTIF_WOOWA_ECO_SENDER', '3bf8eb9597576e806b5f637123fb0267e0017550eade2ee1'),
        'woowa_multics' => env('MSNOTIF_WOOWA_MULTICS_SENDER', 'anonymous'),
    ],

    /** Default recipient */
    'receiver' => [
        'group' => env('MSNOTIF_RECIPIENT_GROUP', 'DtL4PkwlahWFGQlfzJsTdC'), // CID: Odoj App
        'phone' => env('MSNOTIF_RECIPIENT_PHONE', '+6280000'),
    ],

    /** Specific configuration */
    'wauwa' => [
        'host' => env('MSNOTIF_WAUWA_HOST', 'https://wauwa.class.id'),
        'secure' => (bool) env('MSNOTIF_WAUWA_SECURE', false),
    ],
    'driver' => [
        'woowa' => [
            'host' => env('MSNOTIF_WOOWA_HOST', 'https://notifapi.com/'),
            'license' => env('MSNOTIF_WOOWA_LISENCE'),
            'sender' => env('MSNOTIF_WOOWA_SENDER'),
            'sync' => env('MSNOTIF_WOOWA_SYNC', 'async'),
        ],
    ],
];
