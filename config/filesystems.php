<?php
// Kegunaan file: Mengatur lokasi penyimpanan file lokal dan publik.

return [

    /*
    |--------------------------------------------------------------------------
    | Penyimpanan File Default
    |--------------------------------------------------------------------------
    |
    | Menentukan lokasi utama untuk menyimpan file.
    |
    */

    'default' => env('FILESYSTEM_DISK', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Pilihan Penyimpanan File
    |--------------------------------------------------------------------------
    |
    | Pengaturan lokasi penyimpanan lokal dan publik.
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
            'throw' => false,
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
            'throw' => false,
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
            'endpoint' => env('AWS_ENDPOINT'),
            'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
            'throw' => false,
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Tautan Penyimpanan Publik
    |--------------------------------------------------------------------------
    |
    | Menghubungkan folder file publik ke lokasi yang dapat diakses browser.
    |
    */

    'links' => [
        public_path('storage') => storage_path('app/public'),
    ],

];
