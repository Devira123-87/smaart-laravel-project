<?php
// Kegunaan file: Menentukan lokasi template tampilan dan hasil kompilasi Blade.

return [

    /*
    |--------------------------------------------------------------------------
    | Lokasi File Tampilan
    |--------------------------------------------------------------------------
    |
    | Folder tempat Laravel mencari template Blade.
    |
    */

    'paths' => [
        resource_path('views'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Lokasi Tampilan Hasil Kompilasi
    |--------------------------------------------------------------------------
    |
    | Folder penyimpanan template Blade yang sudah dikompilasi.
    |
    */

    'compiled' => env(
        'VIEW_COMPILED_PATH',
        realpath(storage_path('framework/views'))
    ),

];
