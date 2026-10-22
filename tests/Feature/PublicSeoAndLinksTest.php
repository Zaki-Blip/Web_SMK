<?php

namespace Tests\Feature;

use App\Models\Berita;
use App\Models\Jurusan;
use App\Models\SiteSetting;
use App\Models\Spmb;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicSeoAndLinksTest extends TestCase
{
    use RefreshDatabase;

    public function test_sitemap_memuat_halaman_publik_dan_berita_published(): void
    {
        $news = Berita::factory()->create(['slug' => 'berita-sitemap']);
        Berita::factory()->draft()->create(['slug' => 'berita-draf-sitemap']);

        $response = $this->get('/sitemap.xml');

        $response->assertOk()
            ->assertHeader('Content-Type', 'application/xml')
            ->assertSee(route('beranda'), false)
            ->assertSee(route('spmb.index'), false)
            ->assertSee(route('struktur.index'), false)
            ->assertSee(route('berita.show', $news->slug), false)
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

    public function test_halaman_spmb_menampilkan_pesan_netral_saat_data_kosong(): void
    {
        Spmb::current();

        $this->get('/spmb')
            ->assertOk()
            ->assertSee('Informasi pendaftaran akan diperbarui oleh pihak sekolah');
    }

    public function test_halaman_spmb_menampilkan_data_setelah_diisi(): void
    {
        Spmb::current()->update([
            'syarat' => 'Persyaratan contoh.',
            'is_open' => true,
        ]);

        $this->get('/spmb')
            ->assertOk()
            ->assertSee('Persyaratan contoh.');
    }

    public function test_halaman_publik_memuat_canonical_open_graph_twitter_dan_json_ld(): void
    {
        SiteSetting::current()->update([
            'school_name' => 'Sekolah Uji',
            'logo_path' => 'logo/smkn64.png',
        ]);

        $this->get('/')
            ->assertOk()
            ->assertSee('<link rel="canonical" href="'.url('/').'">', false)
            ->assertSee('property="og:image"', false)
            ->assertSee('name="twitter:card" content="summary_large_image"', false)
            ->assertSee('"@type":"EducationalOrganization"', false)
            ->assertSee('"@type":"WebSite"', false)
            ->assertSee('"@type":"WebPage"', false);
    }

    public function test_detail_berita_memuat_news_article_dan_breadcrumb_json_ld(): void
    {
        $news = Berita::factory()->create([
            'title' => 'Berita SEO',
            'slug' => 'berita-seo',
            'kategori' => 'pengumuman',
            'image_path' => 'berita/berita-seo.jpg',
        ]);

        $this->get(route('berita.show', $news->slug))
            ->assertOk()
            ->assertSee('"@type":"NewsArticle"', false)
            ->assertSee('"@type":"BreadcrumbList"', false)
            ->assertSee('property="article:section" content="pengumuman"', false)
            ->assertSee('berita/berita-seo.jpg', false);
    }

    public function test_detail_jurusan_memuat_course_dan_breadcrumb_json_ld(): void
    {
        $jurusan = Jurusan::factory()->create([
            'nama' => 'Jurusan SEO',
            'slug' => 'jurusan-seo',
        ]);

        $this->get(route('jurusan.show', $jurusan->slug))
            ->assertOk()
            ->assertSee('"@type":"Course"', false)
            ->assertSee('"@type":"BreadcrumbList"', false);
    }

    public function test_semua_json_ld_dapat_diuraikan(): void
    {
        $news = Berita::factory()->create([
            'title' => 'Berita JSON',
            'slug' => 'berita-json',
            'kategori' => 'kegiatan',
        ]);

        $html = $this->get(route('berita.show', $news->slug))->getContent();

        preg_match_all('/<script type="application\/ld\+json">(.*?)<\/script>/s', $html, $matches);

        $this->assertNotEmpty($matches[1]);

        foreach ($matches[1] as $json) {
            $decoded = json_decode(trim($json), true);

            $this->assertIsArray($decoded);
            $this->assertArrayHasKey('@type', $decoded);
        }
    }

    public function test_berita_dapat_disaring_berdasarkan_kategori(): void
    {
        Berita::factory()->create([
            'title' => 'Pengumuman Penting',
            'slug' => 'pengumuman-penting',
            'kategori' => 'pengumuman',
        ]);
        Berita::factory()->create([
            'title' => 'Berita Umum',
            'slug' => 'berita-umum',
            'kategori' => 'berita',
        ]);

        $this->get('/berita?kategori=pengumuman')
            ->assertOk()
            ->assertSee('Pengumuman Penting')
            ->assertDontSee('Berita Umum')
            ->assertSee('kategori=pengumuman', false);

        $this->get('/berita?kategori=berita')
            ->assertOk()
            ->assertSee('Berita Umum')
            ->assertDontSee('Pengumuman Penting');
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
        Jurusan::factory()->count(12)->create();

        $this->get('/jurusan')
            ->assertOk()
            ->assertSee('page=2', false);
    }
}
