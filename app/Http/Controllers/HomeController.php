<?php
// Kegunaan file: Mengambil konten aktif dan menyiapkannya untuk halaman beranda.

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Service;
use Illuminate\View\View;

class HomeController extends Controller
{
    // Ambil pilar dan produk aktif untuk ditampilkan di halaman beranda.
    public function __invoke(): View
    {
        $pillars = Service::query()
            ->where('is_active', true)
            ->orderBy('id')
            ->get();
        $products = Product::query()
            ->where('is_active', true)
            ->latest()
            ->get();

        return view('welcome', compact('pillars', 'products'));
    }
}
