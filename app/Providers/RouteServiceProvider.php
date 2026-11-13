<?php
// Kegunaan file: Mendaftarkan kelompok route dan batas jumlah permintaan API/chat.

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Alamat tujuan utama setelah pengguna berhasil login.
     *
     * Pengguna biasanya diarahkan ke sini setelah autentikasi.
     *
     * @var string
     */
    public const HOME = '/admin/products';

    // Atur batas permintaan API/chat dan daftarkan route web serta API.
    /**
     * Atur batas permintaan API dan daftarkan kelompok route aplikasi.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        RateLimiter::for('chat', function (Request $request) {
            $visitor = $request->user()?->getAuthIdentifier() ?? $request->ip() ?? 'unknown';

            return [
                Limit::perMinute(10)->by("chat-minute:{$visitor}"),
                Limit::perDay(20)
                    ->by("chat-day:{$visitor}")
                    ->response(fn (Request $request, array $headers) => response()->json([
                        'message' => 'Batas 20 pesan dalam 24 jam sudah tercapai. Silakan coba lagi nanti.',
                    ], 429, $headers)),
            ];
        });

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }
}
