<?php
// Kegunaan file: Berisi pengujian otomatis untuk memastikan perilaku aplikasi berjalan sesuai harapan.

namespace Tests\Feature;

use App\Models\Service;
use App\Models\User;
use Database\Seeders\PillarSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StrategicPillarsTest extends TestCase
{
    use RefreshDatabase;

    // Siapkan data awal yang diperlukan sebelum pengujian fitur dijalankan.

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(PillarSeeder::class);
    }

    // Memastikan pilar awal tampil di halaman utama.

    public function test_seeded_strategic_pillars_are_displayed_on_the_homepage(): void
    {
        $this->get(route('home'))
            ->assertOk()
            ->assertSee('Pilar Strategis')
            ->assertSee('Status Sistem: Dual-Engine Terhubung')
            ->assertSee('Konsultasi layanan ini')
            ->assertSee('data-consultation-service="Transformasi Digital"', false)
            ->assertSee('Transformasi Digital')
            ->assertSee('Katalisator efisiensi melalui teknologi cerdas dan pengembangan ekosistem aplikasi terpusat.')
            ->assertSee('Custom Apps (ERP, HRIS, Koperasi)')
            ->assertSee('Cloud Location (IIX, SG, US)')
            ->assertSee('Web & Mobile Development')
            ->assertSee('Office 365 & Mail Hosting')
            ->assertSee('Arsitektur SDM')
            ->assertSee('Akselerator kapasitas melalui standar profesional dan manajemen event strategis.')
            ->assertSee('Pelatihan Bersertifikasi BNSP')
            ->assertSee('Manajemen M.I.C.E & Event')
            ->assertSee('Professional Training Center')
            ->assertSee('Inbound/Outbound Tracking')
            ->assertDontSee('id="services"', false);
    }

    // Memastikan admin dapat mengelola pilar dan hanya pilar aktif yang tampil.

    public function test_admin_can_manage_pillar_content_and_only_active_pillars_are_public(): void
    {
        $pillar = Service::where('slug', 'transformasi-digital')->firstOrFail();
        $admin = User::factory()->create();

        $this->actingAs($admin)
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('Kelola pilar strategis')
            ->assertSee('Pilar aktif');

        $this->actingAs($admin)
            ->get(route('admin.services.edit', $pillar))
            ->assertOk()
            ->assertSee('Pratinjau pilar')
            ->assertSee('name="icon"', false);

        $this->actingAs($admin)
            ->get(route('admin.services.create'))
            ->assertOk()
            ->assertSee('name="icon"', false)
            ->assertSee('Pratinjau pilar')
            ->assertSee('data-preview="icon"', false);

        $this->actingAs($admin)
            ->get(route('admin.services.index'))
            ->assertOk()
            ->assertSee('data-confirm="Hapus pilar Transformasi Digital?', false);

        $this->actingAs($admin)
            ->put(route('admin.services.update', $pillar), [
                'name' => 'Transformasi Digital',
                'slug' => 'transformasi-digital',
                'category' => 'Pilar 1',
                'icon' => '💡',
                'description' => 'Deskripsi pilar yang diperbarui.',
                'features' => "Aplikasi khusus\n\nIntegrasi cloud",
                'is_active' => '1',
            ])
            ->assertRedirect(route('admin.services.index'))
            ->assertSessionHas('success');

        $this->assertSame(['Aplikasi khusus', 'Integrasi cloud'], $pillar->fresh()->features);

        $this->get(route('home'))
            ->assertOk()
            ->assertSee('💡')
            ->assertSee('Deskripsi pilar yang diperbarui.')
            ->assertSee('Aplikasi khusus')
            ->assertSee('Integrasi cloud');

        $pillar->update(['is_active' => false]);

        $this->get(route('home'))
            ->assertOk()
            ->assertDontSee('Transformasi Digital')
            ->assertSee('Arsitektur SDM');
    }
}
