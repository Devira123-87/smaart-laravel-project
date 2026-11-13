<?php
// Kegunaan file: Mengatur alamat yang tetap boleh diakses saat situs dalam pemeliharaan.

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance as Middleware;

class PreventRequestsDuringMaintenance extends Middleware
{
    /**
     * Daftar alamat yang tetap dapat diakses saat mode pemeliharaan aktif.
     *
     * @var array<int, string>
     */
    protected $except = [
        //
    ];
}
