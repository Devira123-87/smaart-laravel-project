<?php
// Kegunaan file: Mengatur metode login, sumber akun, dan proses reset kata sandi.

return [

    /*
    |--------------------------------------------------------------------------
    | Pengaturan Autentikasi Default
    |--------------------------------------------------------------------------
    |
    | Menentukan metode dan sumber data login bawaan.
    |
    */

    'defaults' => [
        'guard' => 'web',
        'passwords' => 'users',
    ],

    /*
    |--------------------------------------------------------------------------
    | Metode Autentikasi
    |--------------------------------------------------------------------------
    |
    | Menentukan cara aplikasi memeriksa identitas pengguna.
    |
    */

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Sumber Data Pengguna
    |--------------------------------------------------------------------------
    |
    | Menentukan lokasi akun yang dipakai untuk login.
    |
    */

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],

        // 'users' => [
        //     'driver' => 'database',
        //     'table' => 'users',
        // ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Pengaturan Reset Kata Sandi
    |--------------------------------------------------------------------------
    |
    | Mengatur proses dan masa berlaku tautan reset kata sandi.
    |
    */

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Batas Waktu Konfirmasi Kata Sandi
    |--------------------------------------------------------------------------
    |
    | Lama konfirmasi kata sandi dianggap masih berlaku.
    |
    */

    'password_timeout' => 10800,

];
