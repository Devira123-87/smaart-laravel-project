<?php
// Kegunaan file: Mewakili data pilar layanan beserta daftar fitur yang ditampilkan.

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

// Model untuk pilar layanan yang ditampilkan di halaman utama.
class Service extends Model
{
    // Kolom yang boleh diisi saat admin membuat atau mengubah pilar.
    protected $fillable = [
        'name',
        'slug',
        'category',
        'description',
        'icon',
        'features',
        'is_active',
    ];

    // Baca fitur sebagai daftar dan status aktif sebagai nilai benar/salah.
    protected $casts = [
        'features' => 'array',
        'is_active' => 'boolean',
    ];
}
