<?php
// Kegunaan file: Mengatur cara kata sandi diubah menjadi hash yang aman.

return [

    /*
    |--------------------------------------------------------------------------
    | Metode Hash Kata Sandi
    |--------------------------------------------------------------------------
    |
    | Menentukan algoritma untuk menyimpan kata sandi dengan aman.
    |
    */

    'driver' => 'bcrypt',

    /*
    |--------------------------------------------------------------------------
    | Pengaturan Bcrypt
    |--------------------------------------------------------------------------
    |
    | Mengatur kekuatan algoritma Bcrypt.
    |
    */

    'bcrypt' => [
        'rounds' => env('BCRYPT_ROUNDS', 12),
        'verify' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Pengaturan Argon
    |--------------------------------------------------------------------------
    |
    | Mengatur kekuatan algoritma Argon.
    |
    */

    'argon' => [
        'memory' => 65536,
        'threads' => 1,
        'time' => 4,
        'verify' => true,
    ],

];
