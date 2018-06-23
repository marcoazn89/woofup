<?php
/**
* Config
*
* Add your application's and dependencies configurations here.
*/
return [
    'outputBuffering' => false,

    'debug' =>  true,
    'whoops.editor' => 'sublime',

    'logs' => [
        'name'   => 'API',
        'format' => "[%datetime%] %channel%.%level_name%: %message% %context%\n\n",
        'paths'  => [
            'error'  => __DIR__ . '/../logs/api.error.log',
            'client-error' => __DIR__ . '/../logs/api.client-error.log',
            'client-error-detail' => __DIR__ . '/../logs/api.client-error-detail.log',
            'debug' => __DIR__ . '/../logs/api.debug.log'
        ]
    ],

    'state-manager' => [
        'user_data_dir' => __DIR__ . '/../.user-data'
    ],

    'database' => [
        'mysql' => [
        'driver'    => 'mysql',
        'host'      => getenv('DB_HOST'),
        'database'  => getenv('DB_NAME'),
        'username'  => getenv('DB_USER'),
        'password'  => getenv('DB_PASS'),
        'charset'   => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'prefix'    => ''
        ]
    ],

    'errorTemplates' => [
        'default' => [
            'html' => __DIR__ . '/Views/default-errors/html.php',
            'json' => __DIR__ . '/Views/default-errors/json.php'
        ]
    ],

    'auth' => [
        'private-key' => 'file://' . __DIR__ .'/../oauth-key.pem',
        'public-key' => 'file://' . __DIR__ .'/../oauth-key.pub',
        'expiration' => 604800
    ],

    'auth-routes' => [
        '/oauth2/token/refresh[/]' => [
            'user' => ['web'],
            'driver' => ['web'],
            'supplier' => ['web'],
            'multi' => ['web'],
            'admin' => ['web'],
            'superuser' => ['web', 'curl']
        ],
        '/signup/profile[/]' => [
            'user' => ['web']
        ],
        '/profile[/]' => [
            'user' => ['web'],
            'driver' => ['web'],
            'supplier' => ['web'],
            'multi' => ['web']
        ],
        '/profile/payment[/]' => [
            'driver' => ['web'],
            'supplier' => ['web'],
            'multi' => ['web']
        ],
        '/driver/vehicle[/]' => [
            'driver' => ['web'],
            'multi' => ['web']
        ],
        '/driver/transactions[/]' => [
            'driver' => ['web'],
            'multi' => ['web']
        ],
        '/driver/vehicle/{vehicleId}[/]' => [
            'driver' => ['web'],
            'multi' => ['web']
        ],
        '/listing[/]' => [
            'driver' => ['web'],
            'supplier' => ['web'],
            'multi' => ['web']
        ],
        '/listing/space[/]' => [
            'driver' => ['web'],
            'supplier' => ['web'],
            'multi' => ['web']
        ],
        '/listing/space/{spaceId}/search[/]' => [
            'driver' => ['web'],
            'multi' => ['web']
        ],
        '/listing/{listingId}/space/{spaceId}/book[/]' => [
            'driver' => ['web'],
            'multi' => ['web']
        ]
    ]
];
