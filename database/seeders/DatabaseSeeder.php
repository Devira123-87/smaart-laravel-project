<?php
// Kegunaan file: Menjalankan seeder konten awal dan membuat akun admin bawaan.

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /** Isi database dengan data awal yang diperlukan aplikasi. */
    public function run(): void
    {
        $this->call(PillarSeeder::class);
        $this->call(ProductSeeder::class);

        User::firstOrCreate(
            ['email' => 'admin@smaart.id'],
            [
                'name' => 'SMAART Admin',
                'password' => bcrypt('password'),
            ]
        );
    }
}
