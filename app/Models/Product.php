<?php
// Kegunaan file: Mewakili data katalog produk dan menyiapkan alamat gambar produk.

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

// Model katalog produk; accessor di bawah menyiapkan alamat gambar untuk halaman.
class Product extends Model
{
    // Kolom yang boleh diisi melalui pembuatan atau pembaruan produk.
    protected $fillable = [
        'name',
        'slug',
        'tagline',
        'description',
        'image',
        'image_2',
        'website_url',
        'is_active', 
    ];

    // Ubah status aktif menjadi nilai boolean saat data dibaca.
    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Sediakan URL gambar utama untuk dipakai oleh template.
    public function getImageUrlAttribute(): ?string
    {
        return $this->getProductImageUrl($this->image);
    }

    // Sediakan URL gambar kedua jika produk memiliki gambar tambahan.
    public function getImage2UrlAttribute(): ?string
    {
        return $this->getProductImageUrl($this->image_2);
    }

    // Ubah path lokal atau URL gambar menjadi alamat yang dapat dibuka browser.
    private function getProductImageUrl(?string $image): ?string
    {
        if (! filled($image)) {
            return null;
        }

        if (preg_match('/^https?:\/\//i', $image) === 1) {
            return $image;
        }

        if (Str::startsWith($image, 'products/')) {
            return '/storage/'.ltrim($image, '/');
        }

        return asset(ltrim($image, '/'));
    }
}
