<?php
// Kegunaan file: Menentukan pola host yang dipercaya saat aplikasi menerima permintaan.

namespace App\Http\Middleware;

use Illuminate\Http\Middleware\TrustHosts as Middleware;

class TrustHosts extends Middleware
{
    /**
     * Tentukan pola alamat host yang dipercaya aplikasi.
     *
     * @return array<int, string|null>
     */
    public function hosts(): array
    {
        return [
            $this->allSubdomainsOfApplicationUrl(),
        ];
    }
}
