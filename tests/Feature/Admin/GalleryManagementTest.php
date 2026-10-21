<?php

namespace Tests\Feature\Admin;

use App\Models\Galeri;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class GalleryManagementTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): User
    {
        return User::factory()->admin()->create();
    }

    private function upload(array $overrides = []): TestResponse
    {
        return $this->actingAs($this->admin())->post(route('admin.galeri.store'), array_merge([
            'title' => 'Kegiatan Uji',
            'caption' => 'Keterangan kegiatan uji.',
            'category' => 'Kegiatan',
            'sort_order' => 1,
            'is_published' => '1',
            'image' => UploadedFile::fake()->image('kegiatan.jpg', 2400, 1600),
        ], $overrides));
    }

    public function test_daftar_galeri_menampilkan_metadata(): void
    {
        Galeri::factory()->create(['title' => 'Foto Kegiatan Pagi']);

        $this->actingAs($this->admin())
            ->get(route('admin.galeri.index'))
            ->assertOk()
            ->assertSee('Foto Kegiatan Pagi');
    }

    public function test_foto_baru_dapat_diunggah_dan_diperkecil(): void
    {
        Storage::fake('public');

        $this->upload()->assertRedirect(route('admin.galeri.index'));

        $item = Galeri::query()->firstWhere('title', 'Kegiatan Uji');

        $this->assertNotNull($item);
        Storage::disk('public')->assertExists($item->image_path);

        $size = getimagesizefromstring(Storage::disk('public')->get($item->image_path));

        // Galeri diperkecil ke lebar maksimal 1600 px dengan rasio tetap.
        $this->assertSame(1600, $size[0]);
        $this->assertSame(1067, $size[1]);
    }

    public function test_gambar_wajib_ada_saat_menambah_foto(): void
    {
        Storage::fake('public');

        $this->upload(['image' => null])->assertSessionHasErrors('image');

        $this->assertSame(0, Galeri::query()->count());
    }

    public function test_format_tidak_sah_ditolak(): void
    {
        Storage::fake('public');

        $this->upload(['image' => UploadedFile::fake()->create('catatan.pdf', 50, 'application/pdf')])
            ->assertSessionHasErrors('image');
    }

    public function test_metadata_dapat_diubah_tanpa_mengganti_gambar(): void
    {
        Storage::fake('public');
        $admin = $this->admin();

        $this->upload()->assertRedirect(route('admin.galeri.index'));
        $item = Galeri::query()->firstWhere('title', 'Kegiatan Uji');
        $path = $item->image_path;

        $this->actingAs($admin)->put(route('admin.galeri.update', $item), [
            'title' => 'Kegiatan Uji Diubah',
            'caption' => 'Keterangan baru.',
            'category' => 'Kelas',
            'sort_order' => 2,
            'is_published' => '0',
        ])->assertRedirect(route('admin.galeri.index'));

        $item->refresh();

        $this->assertSame('Kegiatan Uji Diubah', $item->title);
        $this->assertSame('Kelas', $item->category);
        $this->assertFalse($item->is_published);
        $this->assertSame($path, $item->image_path);
        Storage::disk('public')->assertExists($path);
    }

    public function test_foto_dan_berkasnya_dihapus(): void
    {
        Storage::fake('public');
        $admin = $this->admin();

        $this->upload()->assertRedirect(route('admin.galeri.index'));
        $item = Galeri::query()->firstWhere('title', 'Kegiatan Uji');
        $path = $item->image_path;

        $this->actingAs($admin)->delete(route('admin.galeri.destroy', $item))
            ->assertRedirect(route('admin.galeri.index'));

        $this->assertDatabaseMissing('galeri', ['id' => $item->getKey()]);
        Storage::disk('public')->assertMissing($path);
    }

    public function test_foto_unpublished_tidak_tampil_di_galeri_publik(): void
    {
        Galeri::factory()->unpublished()->create(['title' => 'Foto Tersembunyi']);

        $this->get('/galeri')->assertOk()->assertDontSee('Foto Tersembunyi');
    }

    public function test_pencarian_galeri_berdasarkan_kategori(): void
    {
        Galeri::factory()->create(['title' => 'Foto Satu', 'category' => 'Lingkungan']);
        Galeri::factory()->create(['title' => 'Foto Dua', 'category' => 'Kelas']);

        $this->actingAs($this->admin())
            ->get(route('admin.galeri.index', ['q' => 'Lingkungan']))
            ->assertOk()
            ->assertSee('Foto Satu')
            ->assertDontSee('Foto Dua');
    }
}
