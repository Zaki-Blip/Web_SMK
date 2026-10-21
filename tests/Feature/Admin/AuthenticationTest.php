<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    private function admin(string $password = 'rahasia123'): User
    {
        return User::factory()->admin()->create([
            'email' => 'admin@contoh.test',
            'password' => Hash::make($password),
        ]);
    }

    public function test_tamu_diarahkan_ke_halaman_login(): void
    {
        $this->get('/admin')->assertRedirect(route('admin.login'));
    }

    public function test_halaman_login_dapat_dibuka(): void
    {
        $this->get(route('admin.login'))
            ->assertOk()
            ->assertSee('Masuk Dashboard');
    }

    public function test_admin_dapat_login(): void
    {
        $admin = $this->admin();

        $this->post(route('admin.login.attempt'), [
            'email' => 'admin@contoh.test',
            'password' => 'rahasia123',
        ])->assertRedirect(route('admin.dasbor'));

        $this->assertAuthenticatedAs($admin);
    }

    public function test_kata_sandi_salah_menampilkan_pesan_error(): void
    {
        $this->admin();

        $this->post(route('admin.login.attempt'), [
            'email' => 'admin@contoh.test',
            'password' => 'kata-sandi-salah',
        ])->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_email_dan_kata_sandi_wajib_diisi(): void
    {
        $this->post(route('admin.login.attempt'), [])
            ->assertSessionHasErrors(['email', 'password']);
    }

    public function test_pengguna_non_admin_ditolak_403(): void
    {
        $user = User::factory()->nonAdmin()->create();

        $this->actingAs($user)->get('/admin')->assertForbidden();
    }

    public function test_akun_non_admin_tidak_dapat_login(): void
    {
        User::factory()->nonAdmin()->create([
            'email' => 'bukan-admin@contoh.test',
            'password' => Hash::make('rahasia123'),
        ]);

        $this->post(route('admin.login.attempt'), [
            'email' => 'bukan-admin@contoh.test',
            'password' => 'rahasia123',
        ])->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_logout_lewat_post_dan_session_diinvalidasi(): void
    {
        $this->actingAs($this->admin())
            ->post(route('admin.logout'))
            ->assertRedirect(route('admin.login'));

        $this->assertGuest();
    }

    public function test_logout_lewat_get_tidak_diizinkan(): void
    {
        $this->actingAs($this->admin())
            ->get(route('admin.logout'))
            ->assertMethodNotAllowed();
    }

    public function test_pengguna_yang_sudah_login_diarahkan_ke_dashboard(): void
    {
        $this->actingAs($this->admin())
            ->get(route('admin.login'))
            ->assertRedirect(route('admin.dasbor'));
    }

    public function test_percobaan_login_dibatasi_setelah_lima_kali(): void
    {
        $this->admin();

        for ($attempt = 1; $attempt <= 5; $attempt++) {
            $this->post(route('admin.login.attempt'), [
                'email' => 'admin@contoh.test',
                'password' => 'salah-terus',
            ])->assertSessionHasErrors('email');
        }

        // Percobaan keenam ditolak oleh throttle, bukan karena kata sandi salah.
        $this->post(route('admin.login.attempt'), [
            'email' => 'admin@contoh.test',
            'password' => 'rahasia123',
        ])->assertSessionHasErrors('email');

        $message = (string) session('errors')->first('email');

        $this->assertStringContainsString('Terlalu banyak percobaan', $message);
    }

    public function test_admin_dapat_mengubah_kata_sandinya(): void
    {
        $admin = $this->admin();

        $this->actingAs($admin)->put(route('admin.akun.update'), [
            'name' => $admin->name,
            'email' => $admin->email,
            'current_password' => 'rahasia123',
            'password' => 'kata-sandi-baru-9',
            'password_confirmation' => 'kata-sandi-baru-9',
        ])->assertRedirect(route('admin.akun.edit'));

        $this->assertTrue(Hash::check('kata-sandi-baru-9', $admin->fresh()->password));
    }

    public function test_kata_sandi_saat_ini_harus_benar_untuk_mengubah_kata_sandi(): void
    {
        $admin = $this->admin();

        $this->actingAs($admin)->put(route('admin.akun.update'), [
            'name' => $admin->name,
            'email' => $admin->email,
            'current_password' => 'bukan-kata-sandi-saya',
            'password' => 'kata-sandi-baru-9',
            'password_confirmation' => 'kata-sandi-baru-9',
        ])->assertSessionHasErrors('current_password');

        $this->assertTrue(Hash::check('rahasia123', $admin->fresh()->password));
    }
}
