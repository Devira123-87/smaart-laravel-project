<?php
// Kegunaan file: Berisi pengujian otomatis untuk memastikan perilaku aplikasi berjalan sesuai harapan.

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectConsultationTest extends TestCase
{
    use RefreshDatabase;

    // Memastikan halaman utama menampilkan formulir konsultasi dengan alamat pengiriman yang benar.

    public function test_homepage_has_a_project_consultation_form_that_posts_to_the_consultation_route(): void
    {
        $this->get(route('home'))
            ->assertOk()
            ->assertSee('KONSULTASI SMAART')
            ->assertSee('action="'.route('consultations.store').'"', false)
            ->assertSee('name="name"', false)
            ->assertSee('name="email"', false)
            ->assertSee('name="service"', false)
            ->assertSee('name="message"', false);
    }

    // Memastikan konsultasi tersimpan dan dapat dilihat admin.

    public function test_visitor_can_submit_a_project_consultation_and_admin_can_see_it(): void
    {
        $this->post(route('consultations.store'), [
            'name' => 'Rina Pengunjung',
            'email' => 'rina@example.test',
            'phone' => '+628123456789',
            'company' => 'Contoh Usaha',
            'service' => 'Produk SMAART',
            'message' => 'Saya ingin berdiskusi tentang kebutuhan aplikasi.',
        ])->assertRedirect()
            ->assertSessionHas('success', 'Konsultasi berhasil dikirim!');

        $this->assertDatabaseHas('project_consultations', [
            'name' => 'Rina Pengunjung',
            'email' => 'rina@example.test',
            'service' => 'Produk SMAART',
            'message' => 'Saya ingin berdiskusi tentang kebutuhan aplikasi.',
            'status' => 'baru',
        ]);
    }

    // Memastikan isian konsultasi yang salah ditolak dan tidak disimpan.

    public function test_invalid_consultation_input_returns_validation_errors_without_saving(): void
    {
        $this->from(route('home'))
            ->post(route('consultations.store'), [
                'name' => '',
                'email' => 'not-an-email',
                'service' => '',
                'message' => '',
            ])
            ->assertRedirect(route('home'))
            ->assertSessionHasErrors(['name', 'email', 'service', 'message']);

        $this->assertDatabaseCount('project_consultations', 0);
    }
}
