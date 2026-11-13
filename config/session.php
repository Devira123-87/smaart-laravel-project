<?php
// Kegunaan file: Mengatur penyimpanan, masa berlaku, dan cookie sesi pengguna.

use Illuminate\Support\Str;

return [

    /*
    |--------------------------------------------------------------------------
    | Driver Sesi Default
    |--------------------------------------------------------------------------
    |
    | Menentukan tempat penyimpanan sesi pengguna.
    |
    */

    'driver' => env('SESSION_DRIVER', 'file'),

    /*
    |--------------------------------------------------------------------------
    | Lama Sesi
    |--------------------------------------------------------------------------
    |
    | Menentukan berapa lama sesi pengguna tetap aktif.
    |
    */

    'lifetime' => env('SESSION_LIFETIME', 120),

    'expire_on_close' => false,

    /*
    |--------------------------------------------------------------------------
    | Enkripsi Sesi
    |--------------------------------------------------------------------------
    |
    | Menentukan apakah data sesi dienkripsi.
    |
    */

    'encrypt' => false,

    /*
    |--------------------------------------------------------------------------
    | Lokasi File Sesi
    |--------------------------------------------------------------------------
    |
    | Folder penyimpanan file sesi jika memakai driver file.
    |
    */

    'files' => storage_path('framework/sessions'),

    /*
    |--------------------------------------------------------------------------
    | Koneksi Database Sesi
    |--------------------------------------------------------------------------
    |
    | Koneksi database yang dipakai untuk menyimpan sesi.
    |
    */

    'connection' => env('SESSION_CONNECTION'),

    /*
    |--------------------------------------------------------------------------
    | Tabel Sesi
    |--------------------------------------------------------------------------
    |
    | Nama tabel penyimpanan sesi jika driver database digunakan.
    |
    */

    'table' => 'sessions',

    /*
    |--------------------------------------------------------------------------
    | Cache Sesi
    |--------------------------------------------------------------------------
    |
    | Penyimpanan cache yang digunakan untuk sesi.
    |
    */

    'store' => env('SESSION_STORE'),

    /*
    |--------------------------------------------------------------------------
    | Peluang Pembersihan Sesi
    |--------------------------------------------------------------------------
    |
    | Mengatur kemungkinan pembersihan sesi lama pada setiap permintaan.
    |
    */

    'lottery' => [2, 100],

    /*
    |--------------------------------------------------------------------------
    | Nama Cookie Sesi
    |--------------------------------------------------------------------------
    |
    | Nama cookie browser yang menyimpan identitas sesi.
    |
    */

    'cookie' => env(
        'SESSION_COOKIE',
        Str::slug(env('APP_NAME', 'laravel'), '_').'_session'
    ),

    /*
    |--------------------------------------------------------------------------
    | Path Cookie Sesi
    |--------------------------------------------------------------------------
    |
    | Path situs tempat cookie sesi dapat digunakan.
    |
    */

    'path' => '/',

    /*
    |--------------------------------------------------------------------------
    | Domain Cookie Sesi
    |--------------------------------------------------------------------------
    |
    | Domain yang menerima cookie sesi.
    |
    */

    'domain' => env('SESSION_DOMAIN'),

    /*
    |--------------------------------------------------------------------------
    | Cookie Khusus HTTPS
    |--------------------------------------------------------------------------
    |
    | Membatasi pengiriman cookie sesi pada koneksi HTTPS.
    |
    */

    'secure' => env('SESSION_SECURE_COOKIE'),

    /*
    |--------------------------------------------------------------------------
    | Cookie Khusus HTTP
    |--------------------------------------------------------------------------
    |
    | Mencegah JavaScript browser membaca cookie sesi.
    |
    */

    'http_only' => true,

    /*
    |--------------------------------------------------------------------------
    | Pengaturan SameSite Cookie
    |--------------------------------------------------------------------------
    |
    | Mengatur kapan cookie ikut dikirim pada navigasi lintas situs.
    |
    */

    'same_site' => 'lax',

    /*
    |--------------------------------------------------------------------------
    | Cookie Terpartisi
    |--------------------------------------------------------------------------
    |
    | Mengatur penggunaan cookie yang dipisahkan per situs.
    |
    */

    'partitioned' => false,

];
