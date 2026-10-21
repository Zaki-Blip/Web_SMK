<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class PublicRoutesTest extends TestCase
{
    use RefreshDatabase;

    public static function publicRoutes(): array
    {
        return [
            'beranda' => ['/'],
            'profil' => ['/profil'],
            'jurusan' => ['/jurusan'],
            'guru' => ['/guru'],
            'fasilitas' => ['/fasilitas'],
            'industri' => ['/industri'],
            'prestasi' => ['/prestasi'],
            'ekstrakurikuler' => ['/ekstrakurikuler'],
            'bkk' => ['/bkk'],
            'berita' => ['/berita'],
            'galeri' => ['/galeri'],
            'struktur organisasi' => ['/struktur-organisasi'],
            'alur pkl' => ['/alur-pkl'],
            'agenda' => ['/agenda'],
            'unduhan' => ['/unduhan'],
            'spmb' => ['/spmb'],
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

    public function test_redirect_legacy_ke_spmb(): void
    {
        $this->get('/ppdb')->assertStatus(301)->assertRedirect('/spmb');
    }

    public function test_redirect_legacy_program_ke_jurusan(): void
    {
        $this->get('/program')->assertStatus(301)->assertRedirect('/jurusan');
        $this->get('/program/teknik-komputer')->assertStatus(301)->assertRedirect('/jurusan/teknik-komputer');
    }

    public function test_nama_route_lama_sudah_tidak_terdaftar(): void
    {
        $legacyRouteNames = [
            'home',
            'profile.index',
            'facility.index',
            'gallery.index',
            'news.index',
            'news.show',
            'contact.index',
            'admission.index',
            'program.index',
            'program.show',
            'admin.dashboard',
            'admin.account.edit',
            'admin.profile.edit',
            'admin.settings.edit',
            'admin.facilities.index',
            'admin.gallery.index',
            'admin.news.index',
            'admin.jurusans.index',
            'admin.gurus.index',
            'admin.prestasis.index',
            'admin.ekstrakurikulers.index',
            'admin.faqs.index',
            'admin.testimonis.index',
            'admin.mitra.index',
            'admin.bkk.index',
            'admin.lowongan-bkks.index',
        ];

        foreach ($legacyRouteNames as $routeName) {
            $this->assertFalse(Route::has($routeName), 'Route lama masih terdaftar: '.$routeName);
        }
    }

    public function test_url_admin_lama_sudah_tidak_tersedia(): void
    {
        $this->actingAs(User::factory()->admin()->create());

        $legacyUrls = [
            '/home',
            '/profile',
            '/facility',
            '/news',
            '/gallery',
            '/contact',
            '/admission',
            '/admin/dashboard',
            '/admin/account',
            '/admin/profile',
            '/admin/settings',
            '/admin/facilities',
            '/admin/gallery',
            '/admin/news',
            '/admin/jurusans',
            '/admin/gurus',
            '/admin/prestasis',
            '/admin/ekstrakurikulers',
            '/admin/faqs',
            '/admin/testimonis',
            '/admin/mitra',
            '/admin/bkk',
            '/admin/lowongan-bkks',
            '/admin/admission',
            '/admin/programs',
            '/admin/admissions',
        ];

        foreach ($legacyUrls as $url) {
            $this->get($url)->assertNotFound();
        }
    }

    public function test_nama_tabel_lama_sudah_diganti_dengan_nama_indonesia(): void
    {
        foreach (['jurusan', 'guru', 'ekstrakurikuler', 'prestasi', 'mitra_industri', 'lowongan_bkk', 'testimoni', 'faq', 'fasilitas', 'galeri', 'berita', 'struktur_organisasi', 'alur_pkl', 'agenda', 'unduhan'] as $table) {
            $this->assertTrue(Schema::hasTable($table), 'Tabel baru tidak ditemukan: '.$table);
        }

        foreach (['jurusans', 'gurus', 'ekstrakurikulers', 'prestasis', 'mitra_industris', 'lowongan_bkks', 'testimonis', 'faqs', 'facilities', 'gallery_items', 'news', 'admission_settings'] as $table) {
            $this->assertFalse(Schema::hasTable($table), 'Tabel lama masih ada: '.$table);
        }

        $this->assertTrue(Schema::hasColumn('berita', 'kategori'));
        $this->assertFalse(Schema::hasColumn('berita', 'category'));
    }
}
