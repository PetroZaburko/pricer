<?php


return [
    'API_version' => env('SHOPIFY_API_VERSION', '2020-07'),
    'API_auth' => [env('SHOPIFY_API_KEY'),env('SHOPIFY_API_PASSWORD')],
    'base_uri' => env('BASE_URI'),
    'base_currency' => env('BASE_CURRENCY'),
    'rate_limit' => env('SHOPIFY_API_RATE_LIMIT')

];
