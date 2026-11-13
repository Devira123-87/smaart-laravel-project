<?php
// Kegunaan file: Menentukan isian permintaan yang tidak dipangkas spasinya otomatis.

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\TrimStrings as Middleware;

class TrimStrings extends Middleware
{
    /**
     * Daftar isian yang spasinya tidak dipangkas otomatis.
     *
     * @var array<int, string>
     */
    protected $except = [
        'current_password',
        'password',
        'password_confirmation',
    ];
}
