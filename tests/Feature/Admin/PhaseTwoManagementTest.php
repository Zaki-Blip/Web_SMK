<?php

namespace Tests\Feature\Admin;

use App\Models\Agenda;
use App\Models\SiteSetting;
use App\Models\StrukturOrganisasi;
use App\Models\Unduhan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PhaseTwoManagementTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): User
    {
        return User::factory()->admin()->create();
    }

    public function test_admin_dapat_menambah_struktur_organisasi_dan_alur_pkl(): void
    {
        $admin = $this->admin();

        $this->actingAs($admin)
            ->post(route('admin.struktur-organisasi.store'), [
                'nama' => 'Kepala Uji',
                'jabatan' => 'Kepala Sekolah',
                'parent_id' => '',
                'urutan' => 1,
                'is_active' => '1',
            ])
            ->assertRedirect(route('admin.struktur-organisasi.index'));

        $kepala = StrukturOrganisasi::query()->where('nama', 'Kepala Uji')->firstOrFail();

        $this->actingAs($admin)
            ->post(route('admin.struktur-organisasi.store'), [
                'nama' => 'Wakil Uji',
                'jabatan' => 'Wakil Kepala',
                'parent_id' => $kepala->id,
                'urutan' => 2,
                'is_active' => '1',
            ])
            ->assertRedirect(route('admin.struktur-organisasi.index'));

        $this->assertDatabaseHas('struktur_organisasi', [
            'nama' => 'Wakil Uji',
            'parent_id' => $kepala->id,
        ]);

        $this->actingAs($admin)
            ->post(route('admin.alur-pkl.store'), [
                'judul' => 'Langkah Uji',
                'deskripsi' => 'Deskripsi langkah uji.',
                'urutan' => 1,
                'is_active' => '1',
            ])
            ->assertRedirect(route('admin.alur-pkl.index'));

        $this->assertDatabaseHas('alur_pkl', ['judul' => 'Langkah Uji']);
    }

    public function test_admin_dapat_menambah_agenda_dengan_slug_otomatis(): void
    {
        $this->actingAs($this->admin())
            ->post(route('admin.agenda.store'), [
                'judul' => 'Agenda Uji Sekolah',
                'slug' => '',
                'deskripsi' => 'Deskripsi agenda uji.',
                'mulai' => '2026-11-01T09:00',
                'selesai' => '2026-11-01T11:00',
                'lokasi' => 'Aula Sekolah',
                'is_published' => '1',
            ])
            ->assertRedirect(route('admin.agenda.index'));

        $agenda = Agenda::query()->firstOrFail();

        $this->assertSame('agenda-uji-sekolah', $agenda->slug);
        $this->assertTrue($agenda->is_published);

        $this->get(route('agenda.show', $agenda))
            ->assertOk()
            ->assertSee('Agenda Uji Sekolah');
    }

    public function test_admin_dapat_mengunggah_dan_menghapus_berkas_unduhan(): void
    {
        Storage::fake('public');
        $admin = $this->admin();

        $this->actingAs($admin)
            ->post(route('admin.unduhan.store'), [
                'judul' => 'Panduan Uji',
                'deskripsi' => 'Berkas panduan uji.',
                'berkas' => UploadedFile::fake()->create('panduan.pdf', 100, 'application/pdf'),
                'urutan' => 1,
                'is_published' => '1',
            ])
            ->assertRedirect(route('admin.unduhan.index'));

        $unduhan = Unduhan::query()->firstOrFail();
        $path = $unduhan->berkas;

        Storage::disk('public')->assertExists($path);

        $this->get(route('unduhan.download', $unduhan))
            ->assertOk()
            ->assertDownload('panduan-uji.pdf');

        $this->actingAs($admin)
            ->delete(route('admin.unduhan.destroy', $unduhan))
            ->assertRedirect(route('admin.unduhan.index'));

        Storage::disk('public')->assertMissing($path);
        $this->assertDatabaseMissing('unduhan', ['id' => $unduhan->id]);
    }

    public function test_tautan_media_sosial_dapat_disimpan_dari_pengaturan(): void
    {
        $this->actingAs($this->admin())
            ->put(route('admin.pengaturan.update'), [
                'school_name' => 'SMK Sosial Uji',
                'facebook_url' => 'https://www.facebook.com/sekolah-uji',
                'instagram_url' => 'https://www.instagram.com/sekolah-uji',
                'youtube_url' => 'https://www.youtube.com/@sekolah-uji',
                'tiktok_url' => 'https://www.tiktok.com/@sekolah-uji',
            ])
            ->assertRedirect(route('admin.pengaturan.edit'));

        $settings = SiteSetting::current();

        $this->assertSame('https://www.facebook.com/sekolah-uji', $settings->facebook_url);
        $this->assertCount(4, $settings->socialLinks());

        $this->get('/kontak')
            ->assertOk()
            ->assertSee('www.instagram.com/sekolah-uji', false)
            ->assertSee('www.tiktok.com/@sekolah-uji', false);
    }

    public function test_url_media_sosial_tidak_sah_ditolak(): void
    {
        $this->actingAs($this->admin())
            ->put(route('admin.pengaturan.update'), [
                'school_name' => 'SMK Uji',
                'facebook_url' => 'bukan-url',
            ])
            ->assertSessionHasErrors('facebook_url');
    }
}
