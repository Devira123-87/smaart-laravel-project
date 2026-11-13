<?php
// Kegunaan file: Tempat mendaftarkan layanan umum dan pengaturan awal aplikasi.

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Daftarkan layanan aplikasi yang dapat digunakan melalui container Laravel.
     */
    public function register(): void
    {
        //
    }

    /**
     * Jalankan pengaturan awal layanan aplikasi.
     */
    public function boot(): void
    {
        //
    }
}
