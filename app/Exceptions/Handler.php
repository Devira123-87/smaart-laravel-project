<?php
// Kegunaan file: Mengatur penanganan error dan melindungi data sensitif saat validasi gagal.

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * Daftar isian yang tidak disimpan kembali ke sesi jika validasi gagal.
     *
     * @var array<int, string>
     */
    // Cegah kata sandi dikirim kembali ke sesi setelah validasi gagal.
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Daftarkan fungsi yang dijalankan saat aplikasi menangani error.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }
}
