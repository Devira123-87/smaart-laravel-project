<?php
// Kegunaan file: Berisi pengujian otomatis untuk memastikan perilaku aplikasi berjalan sesuai harapan.

namespace Tests\Feature;

use Illuminate\Support\Facades\Auth;
use Mockery;
use Tests\TestCase;

class AdminAuthenticationTest extends TestCase
{
    // Memastikan tamu dapat membuka halaman login.
    public function test_login_page_is_available_to_guests(): void
    {
        $response = $this->get(route('login'));

        $response->assertOk();
        $response->assertSee('Masuk ke dashboard');
        $response->assertSee('name="email"', false);
        $response->assertSee('name="password"', false);
    }

    // Memastikan halaman admin meminta pengunjung login lebih dahulu.

    public function test_admin_routes_redirect_guests_to_login(): void
    {
        foreach ([
            'admin.dashboard',
            'admin.products.index',
            'admin.services.index',
            'admin.consultations.index',
            'admin.settings',
        ] as $route) {
            $this->get(route($route))
                ->assertRedirect(route('login'));
        }
    }

    // Memastikan email atau kata sandi yang salah ditolak.

    public function test_invalid_login_credentials_show_an_error(): void
    {
        $guard = Mockery::mock();
        $guard->shouldReceive('check')->once()->andReturnFalse();

        Auth::shouldReceive('guard')
            ->once()
            ->with(null)
            ->andReturn($guard);

        Auth::shouldReceive('attempt')
            ->once()
            ->with(['email' => 'admin@example.test', 'password' => 'wrong-password'], false)
            ->andReturnFalse();

        $this->post(route('login.store'), [
            'email' => 'admin@example.test',
            'password' => 'wrong-password',
        ])
            ->assertRedirect()
            ->assertSessionHasErrors('email');
    }
}
