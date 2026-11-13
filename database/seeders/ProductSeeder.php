<?php
// Kegunaan file: Memasukkan katalog produk contoh ke database.

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'name' => 'SMaart Sakpu',
                'slug' => 'smaart-sakpu',
                'tagline' => 'Collaborative AI',
                'description' => 'Analisa Kebijakan Publik cerdas berbasis Chatbot AI, hasil sinergi strategis dengan KPPU.',
                'image' => 'images/products/sakpu-preview.svg',
                'is_active' => true,
            ],
            [
                'name' => 'SMaart Channel',
                'slug' => 'smaart-channel',
                'tagline' => 'Omni-channel',
                'description' => 'Solusi Omni-channel terintegrasi AI untuk manajemen komunikasi bisnis tanpa hambatan.',
                'image' => 'images/products/channel-preview.svg',
                'is_active' => true,
            ],
            [
                'name' => 'SMaart POS',
                'slug' => 'smaart-pos',
                'tagline' => 'Smart Retail',
                'description' => 'Point of Sales modern yang didukung AI untuk analisa penjualan dan inventori otomatis.',
                'image' => 'images/products/pos-preview.svg',
                'is_active' => true,
            ],
            [
                'name' => 'SMaart HR',
                'slug' => 'smaart-hr',
                'tagline' => 'Efficient HR',
                'description' => 'Sistem manajemen tenaga kerja digital untuk efisiensi operasional dan penilaian kinerja.',
                'image' => 'images/products/hr-preview.svg',
                'is_active' => true,
            ],
        ];

        foreach ($products as $product) {
            Product::firstOrCreate(
                ['slug' => $product['slug']],
                $product,
            );
        }
    }
}
