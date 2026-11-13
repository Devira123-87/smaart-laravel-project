<?php
// Kegunaan file: Mengatur autentikasi API berbasis Laravel Sanctum.

use Laravel\Sanctum\Sanctum;

return [

    /*
    |--------------------------------------------------------------------------
    | Domain yang Menggunakan Sesi
    |--------------------------------------------------------------------------
    |
    | Domain yang boleh memakai autentikasi berbasis cookie.
    |
    */
                                                                                                                                                                                                                                                                               
    'stateful' => explode(',', env('SANCTUM_STATEFUL_DOMAINS', sprintf(
        '%s%s',
        'localhost,localhost:3000,127.0.0.1,127.0.0.1:8000,::1',
        Sanctum::currentApplicationUrlWithPort()
    ))),

    /*
    |--------------------------------------------------------------------------
    | Metode Autentikasi Sanctum
    |--------------------------------------------------------------------------
    |
    | Metode login yang diperiksa oleh Sanctum.
    |
    */

    'guard' => ['web'],

    /*
    |--------------------------------------------------------------------------
    | Masa Berlaku Token
    |--------------------------------------------------------------------------
    |
    | Lama token API berlaku sebelum kedaluwarsa.
    |
    */

    'expiration' => null,

    /*
    |--------------------------------------------------------------------------
    | Awalan Token Sanctum
    |--------------------------------------------------------------------------
    |
    | Teks awalan opsional untuk token yang dibuat.
    |
    */

    'token_prefix' => env('SANCTUM_TOKEN_PREFIX', ''),

    /*
    |--------------------------------------------------------------------------
    | Middleware Sanctum
    |--------------------------------------------------------------------------
    |
    | Middleware yang dipakai untuk menangani permintaan autentikasi.
    |
    */

    'middleware' => [
        'authenticate_session' => Laravel\Sanctum\Http\Middleware\AuthenticateSession::class,
        'encrypt_cookies' => App\Http\Middleware\EncryptCookies::class,
        'verify_csrf_token' => App\Http\Middleware\VerifyCsrfToken::class,
    ], 
    

];
 