<?php
// Kegunaan file: Tempat menghubungkan aturan akses dengan autentikasi dan otorisasi.

namespace App\Providers;

// Aktifkan import ini jika aplikasi mulai memakai aturan Gate.
// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Hubungkan model dengan policy yang mengatur izin aksesnya.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Daftarkan aturan autentikasi dan otorisasi aplikasi.
     */
    public function boot(): void
    {
        //
    }
}
