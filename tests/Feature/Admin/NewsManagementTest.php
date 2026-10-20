<?php

namespace Tests\Feature\Admin;

use App\Models\News;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class NewsManagementTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): User
    {
        return User::factory()->admin()->create();
    }

    /**
     * @param  array<string, mixed>  $overrides
     * @return array<string, mixed>
     */
    private function payload(array $overrides = []): array
    {
        return array_merge([
            'title' => 'Berita Uji',
            'excerpt' => 'Ringkasan berita uji.',
            'body' => 'Isi berita uji untuk pengujian.',
            'status' => News::STATUS_DRAFT,
            'published_at' => '',
        ], $overrides);
    }

    public function test_berita_draft_tidak_tampil_di_website(): void
    {
        $this->actingAs($this->admin())
            ->post(route('admin.news.store'), $this->payload())
            ->assertRedirect(route('admin.news.index'));

        $news = News::query()->firstWhere('title', 'Berita Uji');

        $this->assertSame(News::STATUS_DRAFT, $news->status);

        // Pesan sukses dari dashboard dibersihkan agar pemeriksaan menguji isi halaman publik.
        $this->flushSession();

        $this->get('/berita')->assertOk()->assertDontSee('Berita Uji');
        $this->get(route('news.show', $news->slug))->assertNotFound();
    }

    public function test_berita_yang_diterbitkan_tampil_di_website(): void
    {
        $this->actingAs($this->admin())
            ->post(route('admin.news.store'), $this->payload([
                'status' => News::STATUS_PUBLISHED,
                'published_at' => now()->subHour()->format('Y-m-d\TH:i'),
            ]))
            ->assertRedirect(route('admin.news.index'));

        $news = News::query()->firstWhere('title', 'Berita Uji');

        $this->assertNotNull($news->published_at);

        $this->flushSession();

        $this->get('/berita')->assertOk()->assertSee('Berita Uji');
        $this->get(route('news.show', $news->slug))->assertOk()->assertSee('Isi berita uji untuk pengujian.');
    }

    public function test_berita_terbit_tanpa_tanggal_memakai_waktu_sekarang(): void
    {
        $this->actingAs($this->admin())
            ->post(route('admin.news.store'), $this->payload([
                'status' => News::STATUS_PUBLISHED,
                'published_at' => '',
            ]))
            ->assertRedirect(route('admin.news.index'));

        $news = News::query()->firstWhere('title', 'Berita Uji');

        $this->assertNotNull($news->published_at);
        $this->get(route('news.show', $news->slug))->assertOk();
    }

    public function test_berita_terjadwal_belum_tampil(): void
    {
        $this->actingAs($this->admin())
            ->post(route('admin.news.store'), $this->payload([
                'status' => News::STATUS_PUBLISHED,
                'published_at' => now()->addWeek()->format('Y-m-d\TH:i'),
            ]))
            ->assertRedirect(route('admin.news.index'));

        $news = News::query()->firstWhere('title', 'Berita Uji');

        $this->assertSame('scheduled', $news->displayStatus());

        $this->flushSession();

        $this->get('/berita')->assertOk()->assertDontSee('Berita Uji');
        $this->get(route('news.show', $news->slug))->assertNotFound();
    }

    public function test_slug_berita_harus_unik(): void
    {
        News::factory()->create(['slug' => 'berita-lama']);

        $this->actingAs($this->admin())
            ->post(route('admin.news.store'), $this->payload(['slug' => 'berita-lama']))
            ->assertSessionHasErrors('slug');
    }

    public function test_isi_berita_wajib_diisi(): void
    {
        $this->actingAs($this->admin())
            ->post(route('admin.news.store'), $this->payload(['body' => '']))
            ->assertSessionHasErrors('body');
    }

    public function test_berita_dapat_diubah_dan_dihapus(): void
    {
        $admin = $this->admin();
        $news = News::factory()->draft()->create(['title' => 'Judul Awal']);

        $this->actingAs($admin)->put(route('admin.news.update', $news), [
            'title' => 'Judul Diperbarui',
            'slug' => $news->slug,
            'excerpt' => 'Ringkasan baru.',
            'body' => 'Isi baru.',
            'status' => News::STATUS_PUBLISHED,
            'published_at' => now()->subDay()->format('Y-m-d\TH:i'),
        ])->assertRedirect(route('admin.news.index'));

        $news->refresh();
        $this->assertSame('Judul Diperbarui', $news->title);
        $this->assertSame(News::STATUS_PUBLISHED, $news->status);

        $this->actingAs($admin)->delete(route('admin.news.destroy', $news))
            ->assertRedirect(route('admin.news.index'));

        $this->assertDatabaseMissing('news', ['id' => $news->getKey()]);
    }

    public function test_filter_status_berita(): void
    {
        News::factory()->create(['title' => 'Berita Terbit Saja']);
        News::factory()->draft()->create(['title' => 'Berita Draf Saja']);

        $this->actingAs($this->admin())
            ->get(route('admin.news.index', ['status' => 'draft']))
            ->assertOk()
            ->assertSee('Berita Draf Saja')
            ->assertDontSee('Berita Terbit Saja');
    }

    public function test_gambar_berita_dapat_diunggah(): void
    {
        Storage::fake('public');

        $this->actingAs($this->admin())
            ->post(route('admin.news.store'), $this->payload([
                'image' => UploadedFile::fake()->image('berita.jpg', 1800, 1000),
            ]))
            ->assertRedirect(route('admin.news.index'));

        $news = News::query()->firstWhere('title', 'Berita Uji');

        Storage::disk('public')->assertExists($news->image_path);

        $size = getimagesizefromstring(Storage::disk('public')->get($news->image_path));

        $this->assertSame(1600, $size[0]);
        $this->assertSame(889, $size[1]);
    }
}
