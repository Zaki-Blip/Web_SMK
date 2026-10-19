<?php

namespace Tests\Feature;

use App\Models\Facility;
use App\Models\GalleryItem;
use App\Models\News;
use App\Models\Program;
use App\Models\SchoolProfile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicContentVisibilityTest extends TestCase
{
    use RefreshDatabase;

    public function test_program_published_tampil_dan_unpublished_tidak_tampil(): void
    {
        Program::factory()->create(['name' => 'Program Terbit', 'slug' => 'program-terbit']);
        Program::factory()->unpublished()->create(['name' => 'Program Tersembunyi', 'slug' => 'program-tersembunyi']);

        $this->get('/program')
            ->assertOk()
            ->assertSee('Program Terbit')
            ->assertDontSee('Program Tersembunyi');

        $this->get('/')
            ->assertOk()
            ->assertSee('Program Terbit')
            ->assertDontSee('Program Tersembunyi');
    }

    public function test_fasilitas_published_tampil_dan_unpublished_tidak_tampil(): void
    {
        Facility::factory()->create(['name' => 'Fasilitas Terbit', 'slug' => 'fasilitas-terbit']);
        Facility::factory()->unpublished()->create(['name' => 'Fasilitas Tersembunyi', 'slug' => 'fasilitas-tersembunyi']);

        $this->get('/fasilitas')
            ->assertOk()
            ->assertSee('Fasilitas Terbit')
            ->assertDontSee('Fasilitas Tersembunyi');
    }

    public function test_galeri_published_tampil_dan_unpublished_tidak_tampil(): void
    {
        GalleryItem::factory()->create(['title' => 'Foto Terbit']);
        GalleryItem::factory()->unpublished()->create(['title' => 'Foto Tersembunyi']);

        $this->get('/galeri')
            ->assertOk()
            ->assertSee('Foto Terbit')
            ->assertDontSee('Foto Tersembunyi');
    }

    public function test_berita_published_tampil_di_daftar(): void
    {
        News::factory()->create(['title' => 'Berita Terbit', 'slug' => 'berita-terbit']);
        News::factory()->draft()->create(['title' => 'Berita Draf', 'slug' => 'berita-draf']);

        $this->get('/berita')
            ->assertOk()
            ->assertSee('Berita Terbit')
            ->assertDontSee('Berita Draf');
    }

    public function test_detail_berita_published_dapat_dibuka(): void
    {
        $news = News::factory()->create([
            'title' => 'Berita Lengkap',
            'slug' => 'berita-lengkap',
            'body' => 'Isi berita lengkap untuk pengujian.',
        ]);

        $this->get('/berita/'.$news->slug)
            ->assertOk()
            ->assertSee('Berita Lengkap')
            ->assertSee('Isi berita lengkap untuk pengujian.');
    }

    public function test_detail_berita_draft_menghasilkan_404(): void
    {
        $news = News::factory()->draft()->create(['slug' => 'berita-draf-404']);

        $this->get('/berita/'.$news->slug)->assertNotFound();
    }

    public function test_detail_berita_terjadwal_di_masa_depan_menghasilkan_404(): void
    {
        $news = News::factory()->scheduled()->create(['slug' => 'berita-terjadwal']);

        $this->get('/berita/'.$news->slug)->assertNotFound();
    }

    public function test_isi_berita_tidak_menjalankan_html_mentah(): void
    {
        $news = News::factory()->create([
            'slug' => 'berita-escape',
            'body' => '<script>alert("xss")</script>',
        ]);

        $this->get('/berita/'.$news->slug)
            ->assertOk()
            ->assertDontSee('<script>alert', false)
            ->assertSee('&lt;script&gt;', false);
    }

    public function test_profil_sekolah_tampil_setelah_diisi(): void
    {
        SchoolProfile::current()->update([
            'vision' => 'Visi contoh untuk pengujian.',
            'mission' => 'Misi contoh untuk pengujian.',
        ]);

        $this->get('/profil')
            ->assertOk()
            ->assertSee('Visi contoh untuk pengujian.')
            ->assertSee('Misi contoh untuk pengujian.');
    }

    public function test_berita_terkait_tampil_di_detail(): void
    {
        $main = News::factory()->create(['title' => 'Berita Utama', 'slug' => 'berita-utama']);
        News::factory()->create(['title' => 'Berita Pendamping', 'slug' => 'berita-pendamping']);

        $this->get('/berita/'.$main->slug)
            ->assertOk()
            ->assertSee('Berita terkait')
            ->assertSee('Berita Pendamping');
    }
}
