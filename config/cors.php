<?php
// Kegunaan file: Mengatur akses API dari domain lain melalui browser.

return [

    /*
    |--------------------------------------------------------------------------
    | Pengaturan CORS (akses lintas domain)
    |--------------------------------------------------------------------------
    |
    | Mengatur domain yang diizinkan mengakses API dari browser.
    |
    */

    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    'allowed_methods' => ['*'],

    'allowed_origins' => ['*'],

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => false,

];
