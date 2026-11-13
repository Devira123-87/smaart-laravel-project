<?php
// Kegunaan file: Mengatur proxy dan header yang dipercaya untuk membaca informasi permintaan.

namespace App\Http\Middleware;

use Illuminate\Http\Middleware\TrustProxies as Middleware;
use Illuminate\Http\Request;

class TrustProxies extends Middleware
{
    /**
     * Daftar proxy yang dipercaya aplikasi.
     *
     * @var array<int, string>|string|null
     */
    protected $proxies;

    /**
     * Header yang digunakan untuk mengenali proxy.
     *
     * @var int
     */
    protected $headers =
        Request::HEADER_X_FORWARDED_FOR |
        Request::HEADER_X_FORWARDED_HOST |
        Request::HEADER_X_FORWARDED_PORT |
        Request::HEADER_X_FORWARDED_PROTO |
        Request::HEADER_X_FORWARDED_AWS_ELB;
}
