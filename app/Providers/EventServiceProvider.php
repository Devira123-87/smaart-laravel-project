<?php
// Kegunaan file: Menghubungkan event dengan proses yang harus dijalankan aplikasi.

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * Hubungkan event aplikasi dengan kelas yang menanganinya.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Daftarkan event aplikasi.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Tentukan apakah Laravel mencari event dan listener secara otomatis.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
