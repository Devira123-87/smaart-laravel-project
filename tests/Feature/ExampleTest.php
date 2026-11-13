<?php
// Kegunaan file: Berisi pengujian otomatis untuk memastikan perilaku aplikasi berjalan sesuai harapan.

namespace Tests\Feature;

use Database\Seeders\PillarSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    // Siapkan data awal yang diperlukan sebelum pengujian fitur dijalankan.

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(PillarSeeder::class);
    }

    /**
     * Pastikan halaman utama berhasil dibuka dan menampilkan pilar awal.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertOk()
            ->assertSee('Pilar Strategis')
            ->assertSee('Transformasi Digital');
    }
}
