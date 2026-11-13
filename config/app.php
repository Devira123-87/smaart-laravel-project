<?php
// Kegunaan file: Mengatur identitas aplikasi, bahasa, zona waktu, kunci enkripsi, dan provider.

use Illuminate\Support\Facades\Facade;
use Illuminate\Support\ServiceProvider;

return [

    /*
    |--------------------------------------------------------------------------
    | Nama Aplikasi
    |--------------------------------------------------------------------------
    |
    | Menentukan nama yang digunakan aplikasi, termasuk pada notifikasi dan halaman tertentu.
    |
    */

    'name' => env('APP_NAME', 'Laravel'),

    /*
    |--------------------------------------------------------------------------
    | Lingkungan Aplikasi
    |--------------------------------------------------------------------------
    |
    | Menentukan lingkungan berjalan, misalnya lokal atau produksi.
    |
    */

    'env' => env('APP_ENV', 'production'),

    /*
    |--------------------------------------------------------------------------
    | Mode Debug Aplikasi
    |--------------------------------------------------------------------------
    |
    | Mengatur detail pesan kesalahan yang ditampilkan saat terjadi masalah.
    |
    */

    'debug' => (bool) env('APP_DEBUG', false),

    /*
    |--------------------------------------------------------------------------
    | URL Aplikasi
    |--------------------------------------------------------------------------
    |
    | Menentukan alamat dasar aplikasi.
    |
    */

    'url' => env('APP_URL', 'http://localhost'),

    'asset_url' => env('ASSET_URL'),

    /*
    |--------------------------------------------------------------------------
    | Zona Waktu Aplikasi
    |--------------------------------------------------------------------------
    |
    | Menentukan zona waktu untuk tanggal dan waktu aplikasi.
    |
    */

    'timezone' => 'UTC',

    /*
    |--------------------------------------------------------------------------
    | Pengaturan Bahasa Aplikasi
    |--------------------------------------------------------------------------
    |
    | Menentukan bahasa utama dan format lokal aplikasi.
    |
    */

    'locale' => 'en',

    /*
    |--------------------------------------------------------------------------
    | Bahasa Cadangan
    |--------------------------------------------------------------------------
    |
    | Menentukan bahasa alternatif jika terjemahan utama tidak tersedia.
    |
    */

    'fallback_locale' => 'en',

    /*
    |--------------------------------------------------------------------------
    | Bahasa Data Contoh
    |--------------------------------------------------------------------------
    |
    | Menentukan bahasa untuk data palsu yang dibuat saat pengujian.
    |
    */

    'faker_locale' => 'en_US',

    /*
    |--------------------------------------------------------------------------
    | Kunci Enkripsi
    |--------------------------------------------------------------------------
    |
    | Kunci untuk mengenkripsi data sesi dan data aplikasi tertentu.
    |
    */

    'key' => env('APP_KEY'),

    'cipher' => 'AES-256-CBC',

    /*
    |--------------------------------------------------------------------------
    | Mode Pemeliharaan
    |--------------------------------------------------------------------------
    |
    | Mengatur cara aplikasi mengaktifkan halaman pemeliharaan.
    |
    */

    'maintenance' => [
        'driver' => 'file',
        // 'store' => 'redis',
    ],

    /*
    |--------------------------------------------------------------------------
    | Service Provider Otomatis
    |--------------------------------------------------------------------------
    |
    | Daftar komponen Laravel yang dimuat saat aplikasi dimulai.
    |
    */

    'providers' => ServiceProvider::defaultProviders()->merge([
        /*
         * Service provider dari paket tambahan.
         */

        /*
         * Service provider khusus aplikasi ini.
         */
        App\Providers\AppServiceProvider::class,
        App\Providers\AuthServiceProvider::class,
        // App\Providers\BroadcastServiceProvider::class,
        App\Providers\EventServiceProvider::class,
        App\Providers\RouteServiceProvider::class,
    ])->toArray(),

    /*
    |--------------------------------------------------------------------------
    | Alias Kelas
    |--------------------------------------------------------------------------
    |
    | Nama singkat yang dapat dipakai untuk mengakses kelas tertentu.
    |
    */

    'aliases' => Facade::defaultAliases()->merge([
        // 'Example' => App\Facades\Example::class,
    ])->toArray(),

];
