<?php

namespace Tests\Feature\Admin;

use App\Models\Jurusan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class JurusanManagementTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): User
    {
        return User::factory()->admin()->create();
    }

    public function test_daftar_jurusan_menampilkan_data_dan_butuh_login(): void
    {
        $this->get(route('admin.jurusan.index'))->assertRedirect(route('admin.login'));

        $jurusan = Jurusan::factory()->create(['nama' => 'Jurusan Uji']);

        $this->actingAs($this->admin())
            ->get(route('admin.jurusan.index'))
            ->assertOk()
            ->assertSee('Jurusan Uji');
    }

    public function test_form_tambah_jurusan_dapat_dibuka(): void
    {
        $this->actingAs($this->admin())
            ->get(route('admin.jurusan.create'))
            ->assertOk()
            ->assertSee('Tambah Jurusan');
    }

    public function test_jurusan_baru_dapat_disimpan(): void
    {
        $this->actingAs($this->admin())
            ->post(route('admin.jurusan.store'), [
                'nama' => 'Jurusan Baru',
                'slug' => '',
                'ringkasan' => 'Ringkasan baru.',
                'deskripsi' => 'Deskripsi baru.',
                'urutan' => 2,
                'is_active' => '1',
            ])
            ->assertRedirect(route('admin.jurusan.index'));

        $jurusan = Jurusan::query()->firstWhere('nama', 'Jurusan Baru');

        $this->assertNotNull($jurusan);
        $this->assertSame('jurusan-baru', $jurusan->slug);
        $this->assertTrue($jurusan->is_active);
    }

    public function test_validasi_gagal_menampilkan_pesan(): void
    {
        $this->actingAs($this->admin())
            ->post(route('admin.jurusan.store'), [
                'nama' => '',
                'urutan' => 0,
            ])
            ->assertSessionHasErrors('nama');

        $this->assertSame(0, Jurusan::query()->count());
    }

    public function test_slug_harus_unik(): void
    {
        Jurusan::factory()->create(['slug' => 'jurusan-lama']);

        $this->actingAs($this->admin())
            ->post(route('admin.jurusan.store'), [
                'nama' => 'Jurusan Lain',
                'slug' => 'jurusan-lama',
                'urutan' => 1,
                'is_active' => '0',
            ])
            ->assertSessionHasErrors('slug');
    }

    public function test_jurusan_dapat_diubah(): void
    {
        $jurusan = Jurusan::factory()->create(['nama' => 'Nama Lama', 'slug' => 'nama-lama']);

        $this->actingAs($this->admin())
            ->put(route('admin.jurusan.update', $jurusan), [
                'nama' => 'Nama Baru',
                'slug' => 'nama-lama',
                'ringkasan' => 'Ringkasan baru.',
                'deskripsi' => 'Deskripsi baru.',
                'urutan' => 5,
                'is_active' => '0',
            ])
            ->assertRedirect(route('admin.jurusan.index'));

        $jurusan->refresh();

        $this->assertSame('Nama Baru', $jurusan->nama);
        $this->assertFalse($jurusan->is_active);
    }

    public function test_jurusan_dapat_dihapus_lewat_delete(): void
    {
        $jurusan = Jurusan::factory()->create();

        $this->actingAs($this->admin())
            ->delete(route('admin.jurusan.destroy', $jurusan))
            ->assertRedirect(route('admin.jurusan.index'));

        $this->assertDatabaseMissing('jurusan', ['id' => $jurusan->getKey()]);
    }

    public function test_penghapusan_lewat_get_tidak_diizinkan(): void
    {
        $jurusan = Jurusan::factory()->create();

        $this->actingAs($this->admin())
            ->get(route('admin.jurusan.destroy', $jurusan))
            ->assertMethodNotAllowed();
    }

    public function test_status_publikasi_mempengaruhi_halaman_publik(): void
    {
        $admin = $this->admin();
        $jurusan = Jurusan::factory()->inactive()->create(['nama' => 'Jurusan Tersembunyi']);

        $this->get('/jurusan')->assertOk()->assertDontSee('Jurusan Tersembunyi');

        $this->actingAs($admin)->put(route('admin.jurusan.update', $jurusan), [
            'nama' => $jurusan->nama,
            'slug' => $jurusan->slug,
            'ringkasan' => $jurusan->ringkasan,
            'deskripsi' => $jurusan->deskripsi,
            'urutan' => $jurusan->urutan,
            'is_active' => '1',
        ])->assertRedirect(route('admin.jurusan.index'));

        $this->flushSession();

        $this->get('/jurusan')->assertOk()->assertSee('Jurusan Tersembunyi');
    }

    public function test_pencarian_jurusan(): void
    {
        Jurusan::factory()->create(['nama' => 'Jurusan Menari']);
        Jurusan::factory()->create(['nama' => 'Jurusan Melukis']);

        $this->actingAs($this->admin())
            ->get(route('admin.jurusan.index', ['q' => 'Menari']))
            ->assertOk()
            ->assertSee('Jurusan Menari')
            ->assertDontSee('Jurusan Melukis');
    }

    public function test_pagination_daftar_jurusan(): void
    {
        Jurusan::factory()->count(12)->create();

        $this->actingAs($this->admin())
            ->get(route('admin.jurusan.index'))
            ->assertOk()
            ->assertSee('page=2', false);
    }

    public function test_gambar_jurusan_dapat_diunggah_dan_dihapus(): void
    {
        Storage::fake('public');

        $this->actingAs($this->admin())
            ->post(route('admin.jurusan.store'), [
                'nama' => 'Jurusan Bergambar',
                'urutan' => 1,
                'is_active' => '1',
                'gambar' => UploadedFile::fake()->image('foto.jpg', 1200, 800),
            ])
            ->assertRedirect(route('admin.jurusan.index'));

        $jurusan = Jurusan::query()->firstWhere('nama', 'Jurusan Bergambar');

        $this->assertNotNull($jurusan->gambar);
        Storage::disk('public')->assertExists($jurusan->gambar);

        $oldPath = $jurusan->gambar;

        $this->actingAs($this->admin())
            ->delete(route('admin.jurusan.destroy', $jurusan))
            ->assertRedirect(route('admin.jurusan.index'));

        Storage::disk('public')->assertMissing($oldPath);
    }
}
