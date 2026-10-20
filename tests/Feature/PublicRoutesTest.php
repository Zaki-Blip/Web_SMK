<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class PublicRoutesTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Semua halaman publik harus tampil tanpa error meski database masih kosong.
     *
     * @return array<string, array{string}>
     */
    public static function publicRoutes(): array
    {
        return [
            'beranda' => ['/'],
            'profil' => ['/profil'],
            'program' => ['/program'],
            'fasilitas' => ['/fasilitas'],
            'galeri' => ['/galeri'],
            'berita' => ['/berita'],
            'ppdb' => ['/ppdb'],
            'kontak' => ['/kontak'],
        ];
    }

    #[DataProvider('publicRoutes')]
    public function test_halaman_publik_mengembalikan_status_200_dengan_database_kosong(string $url): void
    {
        $this->get($url)->assertOk();
    }

    public function test_berita_yang_belum_ada_menghasilkan_404(): void
    {
        $this->get('/berita/berita-yang-tidak-ada')->assertNotFound();
    }

    public function test_halaman_tidak_ditemukan_menampilkan_404(): void
    {
        $this->get('/halaman-yang-tidak-ada')
            ->assertNotFound()
            ->assertSee('Halaman tidak ditemukan');
    }

    public function test_halaman_admin_memakai_noindex(): void
    {
        $this->actingAs(User::factory()->admin()->create())
            ->get('/admin')
            ->assertOk()
            ->assertSee('noindex', false);
    }

    public function test_dashboard_admin_butuh_login(): void
    {
        $this->get('/admin')->assertRedirect(route('admin.login'));
    }

    public function test_banner_versi_demo_tampil_saat_data_demo_aktif(): void
    {
        config(['school.demo_mode' => true]);

        $this->get('/')
            ->assertOk()
            ->assertSee('Versi demo', false);
    }

    public function test_banner_versi_demo_tidak_tampil_bila_nonaktif(): void
    {
        config(['school.demo_mode' => false]);

        $this->get('/')
            ->assertOk()
            ->assertDontSee('Versi demo', false);
    }
}
