<?php

return [
    'key'    => env('HUOBI_KEY', ''),
    'secret' => env('HUOBI_SECRET', ''),

    'host' => [
        'spot'   => env('HUOBI_HOST_SPOT', 'https://api.huobi.pro'),
        'future' => env('HUOBI_HOST_FUTURE', 'https://api.hbdm.com'),
    ]
];
