<?php
// Kegunaan file: Mengatur pengecualian pemeriksaan token CSRF untuk permintaan formulir.

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * Daftar alamat yang dikecualikan dari pemeriksaan token CSRF.
     *
     * @var array<int, string>
     */
    protected $except = [
        //
    ];
}
