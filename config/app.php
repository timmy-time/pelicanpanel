<?php

return [

    'name' => env('APP_NAME', 'Pelican'),
    'favicon' => env('APP_FAVICON', '/pelican.ico'),

    'version' => 'canary',

    'timezone' => 'UTC',

    'installed' => env('APP_INSTALLED', true),

    'exceptions' => [
        'report_all' => env('APP_REPORT_ALL_EXCEPTIONS', false),
    ],

];
