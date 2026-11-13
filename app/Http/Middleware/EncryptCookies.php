<?php
// Kegunaan file: Menentukan cookie yang tidak perlu dienkripsi oleh middleware Laravel.

namespace App\Http\Middleware;

use Illuminate\Cookie\Middleware\EncryptCookies as Middleware;

class EncryptCookies extends Middleware
{
    /**
     * Daftar nama cookie yang tidak perlu dienkripsi.
     *
     * @var array<int, string>
     */
    protected $except = [
        //
    ];
}
