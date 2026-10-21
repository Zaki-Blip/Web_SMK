<?php

namespace Tests\Feature\Admin;

use App\Models\Fasilitas;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class FacilityManagementTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): User
    {
        return User::factory()->admin()->create();
    }

    public function test_daftar_fasilitas_dan_pencarian(): void
    {
        Fasilitas::factory()->create(['name' => 'Ruang Musik']);
        Fasilitas::factory()->create(['name' => 'Ruang Perpustakaan']);

        $this->actingAs($this->admin())
            ->get(route('admin.fasilitas.index', ['q' => 'Musik']))
            ->assertOk()
            ->assertSee('Ruang Musik')
            ->assertDontSee('Ruang Perpustakaan');
    }

    public function test_fasilitas_dapat_disimpan_diubah_dan_dihapus(): void
    {
        $admin = $this->admin();

        $this->actingAs($admin)->post(route('admin.fasilitas.store'), [
            'name' => 'Ruang Kesenian',
            'description' => 'Keterangan ruang kesenian.',
            'sort_order' => 3,
            'is_published' => '1',
        ])->assertRedirect(route('admin.fasilitas.index'));

        $facility = Fasilitas::query()->firstWhere('name', 'Ruang Kesenian');
        $this->assertSame('ruang-kesenian', $facility->slug);

        $this->actingAs($admin)->put(route('admin.fasilitas.update', $facility), [
            'name' => 'Ruang Kesenian Baru',
            'slug' => $facility->slug,
            'description' => 'Keterangan diperbarui.',
            'sort_order' => 4,
            'is_published' => '0',
        ])->assertRedirect(route('admin.fasilitas.index'));

        $facility->refresh();
        $this->assertSame('Ruang Kesenian Baru', $facility->name);
        $this->assertFalse($facility->is_published);

        $this->actingAs($admin)->delete(route('admin.fasilitas.destroy', $facility))
            ->assertRedirect(route('admin.fasilitas.index'));

        $this->assertDatabaseMissing('fasilitas', ['id' => $facility->getKey()]);
    }

    public function test_nama_fasilitas_wajib_diisi(): void
    {
        $this->actingAs($this->admin())
            ->post(route('admin.fasilitas.store'), ['name' => '', 'sort_order' => 0])
            ->assertSessionHasErrors('name');
    }

    public function test_unggahan_gambar_sah_diterima_dan_diperkecil(): void
    {
        Storage::fake('public');

        $this->actingAs($this->admin())
            ->post(route('admin.fasilitas.store'), [
                'name' => 'Fasilitas Bergambar',
                'sort_order' => 1,
                'is_published' => '1',
                'image' => UploadedFile::fake()->image('besar.jpg', 2000, 1500),
            ])
            ->assertRedirect(route('admin.fasilitas.index'));

        $facility = Fasilitas::query()->firstWhere('name', 'Fasilitas Bergambar');

        Storage::disk('public')->assertExists($facility->image_path);

        $size = getimagesizefromstring(Storage::disk('public')->get($facility->image_path));

        // Kartu fasilitas diperkecil ke lebar maksimal 800 px.
        $this->assertSame(800, $size[0]);
        $this->assertSame(600, $size[1]);
    }

    public function test_unggahan_format_tidak_sah_ditolak(): void
    {
        Storage::fake('public');

        $this->actingAs($this->admin())
            ->post(route('admin.fasilitas.store'), [
                'name' => 'Fasilitas Dokumen',
                'sort_order' => 1,
                'is_published' => '1',
                'image' => UploadedFile::fake()->create('dokumen.pdf', 100, 'application/pdf'),
            ])
            ->assertSessionHasErrors('image');

        $this->assertSame(0, Fasilitas::query()->count());
    }

    public function test_unggahan_melebihi_dua_mb_ditolak(): void
    {
        Storage::fake('public');

        $this->actingAs($this->admin())
            ->post(route('admin.fasilitas.store'), [
                'name' => 'Fasilitas Gambar Besar',
                'sort_order' => 1,
                'is_published' => '1',
                'image' => UploadedFile::fake()->image('besar.jpg')->size(3000),
            ])
            ->assertSessionHasErrors('image');
    }

    public function test_gambar_lama_dihapus_saat_diganti(): void
    {
        Storage::fake('public');
        $admin = $this->admin();

        $this->actingAs($admin)->post(route('admin.fasilitas.store'), [
            'name' => 'Fasilitas Ganti Gambar',
            'sort_order' => 1,
            'is_published' => '1',
            'image' => UploadedFile::fake()->image('awal.jpg', 900, 600),
        ])->assertRedirect(route('admin.fasilitas.index'));

        $facility = Fasilitas::query()->firstWhere('name', 'Fasilitas Ganti Gambar');
        $oldPath = $facility->image_path;

        $this->actingAs($admin)->put(route('admin.fasilitas.update', $facility), [
            'name' => $facility->name,
            'slug' => $facility->slug,
            'description' => $facility->description,
            'sort_order' => 1,
            'is_published' => '1',
            'image' => UploadedFile::fake()->image('pengganti.jpg', 900, 600),
        ])->assertRedirect(route('admin.fasilitas.index'));

        $facility->refresh();

        $this->assertNotSame($oldPath, $facility->image_path);
        Storage::disk('public')->assertMissing($oldPath);
        Storage::disk('public')->assertExists($facility->image_path);
    }
}
