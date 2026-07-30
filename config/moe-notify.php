<?php

return [
    'default_channel' => env('NOTIFY_DEFAULT_CHANNEL', 'mail'),

    'channels' => [
        'mail' => [
            'driver' => env('NOTIFY_MAIL_DRIVER', 'log'),
        ],
        'sms' => [
            'driver' => env('NOTIFY_SMS_DRIVER', 'log'),
            'from' => env('NOTIFY_SMS_FROM'),
        ],
        'whatsapp' => [
            'driver' => env('NOTIFY_WA_DRIVER', 'log'),
            'from' => env('NOTIFY_WA_FROM'),
        ],
        'database' => [
            'table' => 'notifications',
        ],
    ],

    'templates' => [
        'table' => 'notification_templates',
        'cache_ttl' => 3600,
    ],

    'queue' => [
        'enabled' => env('NOTIFY_QUEUE_ENABLED', true),
        'connection' => env('NOTIFY_QUEUE_CONNECTION', 'default'),
        'queue' => env('NOTIFY_QUEUE_NAME', 'notifications'),
    ],

    'retry' => [
        'max_attempts' => 3,
        'backoff_seconds' => 5,
    ],

    'logging' => [
        'enabled' => true,
        'table' => 'notification_logs',
        'store_payload' => true,
    ],
];
