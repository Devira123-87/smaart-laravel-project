<?php
// Kegunaan file: Mendaftarkan route dan aturan akses untuk siaran event waktu nyata.

namespace App\Providers;

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\ServiceProvider;

class BroadcastServiceProvider extends ServiceProvider
{
    /**
     * Daftarkan route dan aturan akses untuk siaran waktu nyata.
     */
    public function boot(): void
    {
        Broadcast::routes();

        require base_path('routes/channels.php');
    }
}
