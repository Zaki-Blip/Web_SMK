<?php

namespace Tests\Feature;

use App\Models\AdmissionSetting;
use App\Models\News;
use App\Models\Program;
use App\Models\SiteSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicSeoAndLinksTest extends TestCase
{
    use RefreshDatabase;

    public function test_sitemap_memuat_halaman_publik_dan_berita_published(): void
    {
        $news = News::factory()->create(['slug' => 'berita-sitemap']);
        News::factory()->draft()->create(['slug' => 'berita-draf-sitemap']);

        $response = $this->get('/sitemap.xml');

        $response->assertOk()
            ->assertHeader('Content-Type', 'application/xml')
            ->assertSee(route('home'), false)
            ->assertSee(route('admission.index'), false)
            ->assertSee(route('news.show', $news->slug), false)
            ->assertDontSee('berita-draf-sitemap');
    }

    public function test_robots_txt_melarang_area_admin(): void
    {
        // File statis bawaan Laravel harus dihapus agar route dinamis /robots.txt yang dipakai.
        $this->assertFileDoesNotExist(public_path('robots.txt'));

        $this->get('/robots.txt')
            ->assertOk()
            ->assertSee('Disallow: /admin', false)
            ->assertSee('Sitemap:', false);
    }

    public function test_nomor_whatsapp_lokal_dinormalkan_ke_format_internasional(): void
    {
        SiteSetting::current()->update(['whatsapp_number' => '0812-3456-7890']);

        $this->get('/kontak')
            ->assertOk()
            ->assertSee('https://wa.me/6281234567890', false);
    }

    public function test_nomor_whatsapp_dengan_tanda_plus_dinormalkan(): void
    {
        SiteSetting::current()->update(['whatsapp_number' => '+62 812 3456 7890']);

        $this->get('/kontak')
            ->assertOk()
            ->assertSee('https://wa.me/6281234567890', false);
    }

    public function test_tautan_maps_tampil_bila_tersedia(): void
    {
        SiteSetting::current()->update(['maps_url' => 'https://maps.app.goo.gl/contoh']);

        $this->get('/kontak')
            ->assertOk()
            ->assertSee('https://maps.app.goo.gl/contoh', false);
    }

    public function test_tautan_maps_tidak_dipaksakan_bila_belum_dikonfirmasi(): void
    {
        $this->get('/kontak')
            ->assertOk()
            ->assertSee('Tautan Google Maps akan tampil setelah URL peta dikonfirmasi oleh pihak sekolah.');
    }

    public function test_halaman_ppdb_menampilkan_pesan_netral_saat_data_kosong(): void
    {
        AdmissionSetting::current();

        $this->get('/ppdb')
            ->assertOk()
            ->assertSee('Informasi pendaftaran akan diperbarui oleh pihak sekolah');
    }

    public function test_halaman_ppdb_menampilkan_data_setelah_diisi(): void
    {
        AdmissionSetting::current()->update([
            'title' => 'PPDB Contoh',
            'description' => 'Deskripsi PPDB contoh.',
            'requirements' => 'Persyaratan contoh.',
            'whatsapp_number' => '62800111222333',
            'is_active' => true,
        ]);

        $this->get('/ppdb')
            ->assertOk()
            ->assertSee('PPDB Contoh')
            ->assertSee('Persyaratan contoh.')
            ->assertSee('https://wa.me/62800111222333', false);
    }

    public function test_meta_title_dan_description_memakai_pengaturan_situs(): void
    {
        SiteSetting::current()->update([
            'school_name' => 'Sekolah Uji',
            'meta_title' => 'Judul Meta Uji',
            'meta_description' => 'Deskripsi meta uji.',
        ]);

        // Beranda memakai meta_title/meta_description dari pengaturan situs.
        $this->get('/')
            ->assertOk()
            ->assertSee('Judul Meta Uji')
            ->assertSee('Deskripsi meta uji.');

        // Halaman lain memakai judul uniknya sendiri, tetapi tetap memuat nama sekolah.
        $this->get('/kontak')
            ->assertOk()
            ->assertSee('Kontak — Sekolah Uji');
    }

    public function test_pagination_tampil_saat_data_lebih_dari_satu_halaman(): void
    {
        Program::factory()->count(12)->create();

        $this->get('/program')
            ->assertOk()
            ->assertSee('page=2', false);
    }
}
