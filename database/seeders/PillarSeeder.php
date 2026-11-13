<?php
// Kegunaan file: Memasukkan data awal dua pilar layanan ke database.

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class PillarSeeder extends Seeder
{
    // Masukkan dua pilar awal jika slug-nya belum ada di database.
    public function run(): void
    {
        $pillars = [
            [
                'name' => 'Transformasi Digital',
                'slug' => 'transformasi-digital',
                'category' => 'Pilar 1',
                'description' => 'Katalisator efisiensi melalui teknologi cerdas dan pengembangan ekosistem aplikasi terpusat.',
                'features' => [
                    'Custom Apps (ERP, HRIS, Koperasi)',
                    'Cloud Location (IIX, SG, US)',
                    'Web & Mobile Development',
                    'Office 365 & Mail Hosting',
                ],
                'is_active' => true,
            ],
            [
                'name' => 'Arsitektur SDM',
                'slug' => 'arsitektur-sdm',
                'category' => 'Pilar 2',
                'description' => 'Akselerator kapasitas melalui standar profesional dan manajemen event strategis.',
                'features' => [

                
                    'Pelatihan Bersertifikasi BNSP',
                    'Manajemen M.I.C.E & Event',
                    'Professional Training Center',
                    'Inbound/Outbound Tracking',
                ],
                'is_active' => true,
            ],
        ];

        foreach ($pillars as $pillar) {
            Service::firstOrCreate(
                ['slug' => $pillar['slug']],
                $pillar,
            );
        }
    }
}
