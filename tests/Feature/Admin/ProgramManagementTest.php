<?php

namespace Tests\Feature\Admin;

use App\Models\Program;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProgramManagementTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): User
    {
        return User::factory()->admin()->create();
    }

    public function test_daftar_program_menampilkan_data_dan_butuh_login(): void
    {
        $this->get(route('admin.programs.index'))->assertRedirect(route('admin.login'));

        $program = Program::factory()->create(['name' => 'Program Uji']);

        $this->actingAs($this->admin())
            ->get(route('admin.programs.index'))
            ->assertOk()
            ->assertSee('Program Uji');
    }

    public function test_form_tambah_program_dapat_dibuka(): void
    {
        $this->actingAs($this->admin())
            ->get(route('admin.programs.create'))
            ->assertOk()
            ->assertSee('Tambah program');
    }

    public function test_program_baru_dapat_disimpan(): void
    {
        $this->actingAs($this->admin())
            ->post(route('admin.programs.store'), [
                'name' => 'Program Baru',
                'slug' => '',
                'short_description' => 'Ringkasan program baru.',
                'description' => 'Deskripsi program baru.',
                'sort_order' => 2,
                'is_published' => '1',
            ])
            ->assertRedirect(route('admin.programs.index'));

        $program = Program::query()->firstWhere('name', 'Program Baru');

        $this->assertNotNull($program);
        $this->assertSame('program-baru', $program->slug);
        $this->assertTrue($program->is_published);
    }

    public function test_validasi_gagal_menampilkan_pesan(): void
    {
        $this->actingAs($this->admin())
            ->post(route('admin.programs.store'), [
                'name' => '',
                'sort_order' => 0,
            ])
            ->assertSessionHasErrors('name');

        $this->assertSame(0, Program::query()->count());
    }

    public function test_slug_harus_unik(): void
    {
        Program::factory()->create(['slug' => 'program-lama']);

        $this->actingAs($this->admin())
            ->post(route('admin.programs.store'), [
                'name' => 'Program Lain',
                'slug' => 'program-lama',
                'sort_order' => 1,
                'is_published' => '0',
            ])
            ->assertSessionHasErrors('slug');
    }

    public function test_program_dapat_diubah(): void
    {
        $program = Program::factory()->create(['name' => 'Nama Lama', 'slug' => 'nama-lama']);

        $this->actingAs($this->admin())
            ->put(route('admin.programs.update', $program), [
                'name' => 'Nama Baru',
                'slug' => 'nama-lama',
                'short_description' => 'Ringkasan baru.',
                'description' => 'Deskripsi baru.',
                'sort_order' => 5,
                'is_published' => '0',
            ])
            ->assertRedirect(route('admin.programs.index'));

        $program->refresh();

        $this->assertSame('Nama Baru', $program->name);
        $this->assertFalse($program->is_published);
    }

    public function test_program_dapat_dihapus_lewat_delete(): void
    {
        $program = Program::factory()->create();

        $this->actingAs($this->admin())
            ->delete(route('admin.programs.destroy', $program))
            ->assertRedirect(route('admin.programs.index'));

        $this->assertDatabaseMissing('programs', ['id' => $program->getKey()]);
    }

    public function test_penghapusan_lewat_get_tidak_diizinkan(): void
    {
        $program = Program::factory()->create();

        $this->actingAs($this->admin())
            ->get(route('admin.programs.destroy', $program))
            ->assertMethodNotAllowed();
    }

    public function test_status_publikasi_mempengaruhi_halaman_publik(): void
    {
        $admin = $this->admin();
        $program = Program::factory()->unpublished()->create(['name' => 'Program Tersembunyi']);

        $this->get('/program')->assertOk()->assertDontSee('Program Tersembunyi');

        $this->actingAs($admin)->put(route('admin.programs.update', $program), [
            'name' => $program->name,
            'slug' => $program->slug,
            'short_description' => $program->short_description,
            'description' => $program->description,
            'sort_order' => $program->sort_order,
            'is_published' => '1',
        ])->assertRedirect(route('admin.programs.index'));

        // Pesan sukses dibersihkan agar hasil pemeriksaan benar-benar dari halaman publik.
        $this->flushSession();

        $this->get('/program')->assertOk()->assertSee('Program Tersembunyi');
    }

    public function test_pencarian_program(): void
    {
        Program::factory()->create(['name' => 'Program Menari']);
        Program::factory()->create(['name' => 'Program Melukis']);

        $this->actingAs($this->admin())
            ->get(route('admin.programs.index', ['q' => 'Menari']))
            ->assertOk()
            ->assertSee('Program Menari')
            ->assertDontSee('Program Melukis');
    }

    public function test_pagination_daftar_program(): void
    {
        Program::factory()->count(12)->create();

        $this->actingAs($this->admin())
            ->get(route('admin.programs.index'))
            ->assertOk()
            ->assertSee('page=2', false);
    }

    public function test_gambar_program_dapat_diunggah_dan_dihapus(): void
    {
        Storage::fake('public');

        $this->actingAs($this->admin())
            ->post(route('admin.programs.store'), [
                'name' => 'Program Bergambar',
                'sort_order' => 1,
                'is_published' => '1',
                'image' => UploadedFile::fake()->image('foto.jpg', 1200, 800),
            ])
            ->assertRedirect(route('admin.programs.index'));

        $program = Program::query()->firstWhere('name', 'Program Bergambar');

        $this->assertNotNull($program->image_path);
        Storage::disk('public')->assertExists($program->image_path);

        $oldPath = $program->image_path;

        $this->actingAs($this->admin())
            ->delete(route('admin.programs.destroy', $program))
            ->assertRedirect(route('admin.programs.index'));

        Storage::disk('public')->assertMissing($oldPath);
    }
}
