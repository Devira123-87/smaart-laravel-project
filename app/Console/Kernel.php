<?php
// Kegunaan file: Menyiapkan jadwal dan memuat perintah terminal (Artisan) milik aplikasi.

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Atur jadwal perintah otomatis aplikasi.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Contoh jadwal perintah yang dijalankan setiap jam (saat ini nonaktif).
        // $schedule->command('inspire')->hourly();
    }

    /**
     * Muat perintah terminal yang tersedia untuk aplikasi.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
