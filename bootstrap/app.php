<?php
// Kegunaan file: Membuat aplikasi Laravel dan menghubungkan kernel web, terminal, serta penangan error.

/*
|--------------------------------------------------------------------------
| Membuat aplikasi
|--------------------------------------------------------------------------
|
| Membuat instance Laravel sebagai penghubung komponen dan wadah untuk
| mengelola layanan yang dipakai aplikasi.
|
*/

$app = new Illuminate\Foundation\Application(
    $_ENV['APP_BASE_PATH'] ?? dirname(__DIR__)
);

/*
|--------------------------------------------------------------------------
| Mendaftarkan komponen utama
|--------------------------------------------------------------------------
|
| Menghubungkan kernel web, kernel perintah terminal, dan penangan error
| agar dapat dipanggil saat diperlukan.
|
*/

$app->singleton(
    Illuminate\Contracts\Http\Kernel::class,
    App\Http\Kernel::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    App\Console\Kernel::class
);

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Exceptions\Handler::class
);

/*
|--------------------------------------------------------------------------
| Mengembalikan aplikasi
|--------------------------------------------------------------------------
|
| Mengembalikan instance aplikasi untuk dijalankan oleh pemanggil script ini.
|
*/

return $app;
