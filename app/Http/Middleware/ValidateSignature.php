<?php
// Kegunaan file: Menentukan parameter URL yang diabaikan saat tautan bertanda tangan diperiksa.

namespace App\Http\Middleware;

use Illuminate\Routing\Middleware\ValidateSignature as Middleware;

class ValidateSignature extends Middleware
{
    /**
     * Nama parameter URL yang diabaikan saat tanda tangan diperiksa.
     *
     * @var array<int, string>
     */
    protected $except = [
        // 'fbclid',
        // 'utm_campaign',
        // 'utm_content',
        // 'utm_medium',
        // 'utm_source',
        // 'utm_term',
    ];
}
