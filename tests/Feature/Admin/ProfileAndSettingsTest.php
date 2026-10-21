<?php

namespace Tests\Feature\Admin;

use App\Models\SchoolProfile;
use App\Models\SiteSetting;
use App\Models\Spmb;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProfileAndSettingsTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): User
    {
        return User::factory()->admin()->create();
    }

    public function test_profil_sekolah_dapat_diperbarui_dan_tampil_di_publik(): void
    {
        $this->actingAs($this->admin())
            ->put(route('admin.profil.update'), [
                'school_name' => 'SMK Uji',
                'history' => 'Sejarah sekolah uji.',
                'vision' => 'Visi sekolah uji.',
                'mission' => 'Misi sekolah uji.',
                'description' => 'Deskripsi sekolah uji.',
            ])
            ->assertRedirect(route('admin.profil.edit'));

        $this->assertSame('Sejarah sekolah uji.', SchoolProfile::current()->history);

        $this->get('/profil')
            ->assertOk()
            ->assertSee('Sejarah sekolah uji.')
            ->assertSee('Visi sekolah uji.');
    }

    public function test_spmb_dapat_diperbarui(): void
    {
        $this->actingAs($this->admin())
            ->put(route('admin.spmb.update'), [
                'tahun_ajaran' => '2026/2027',
                'syarat' => 'Fotokopi ijazah',
                'is_open' => '1',
            ])
            ->assertRedirect(route('admin.spmb.edit'));

        $spmb = Spmb::current();

        $this->assertTrue($spmb->is_open);
        $this->assertSame('Fotokopi ijazah', $spmb->syarat);

        $this->get('/spmb')
            ->assertOk()
            ->assertSee('Fotokopi ijazah');
    }

    public function test_spmb_nonaktif_menampilkan_pesan_netral(): void
    {
        Spmb::current()->update([
            'syarat' => 'Syarat rahasia',
            'is_open' => false,
        ]);

        $this->get('/spmb')
            ->assertOk()
            ->assertSee('Informasi pendaftaran akan diperbarui oleh pihak sekolah')
            ->assertDontSee('Syarat rahasia');
    }

    public function test_tautan_pendaftaran_tidak_sah_ditolak(): void
    {
        $this->actingAs($this->admin())
            ->put(route('admin.spmb.update'), [
                'tautan_pendaftaran' => 'bukan-url',
                'is_open' => '1',
            ])
            ->assertSessionHasErrors('tautan_pendaftaran');
    }

    public function test_pengaturan_situs_dapat_diperbarui(): void
    {
        $this->actingAs($this->admin())
            ->put(route('admin.pengaturan.update'), [
                'school_name' => 'SMK Pengaturan Uji',
                'address' => 'Jl. Uji No. 1',
                'phone' => '021-0000000',
                'email' => 'info@contoh.test',
                'opening_hours' => 'Senin-Jumat, 07.00-14.00 WIB',
                'whatsapp_number' => '+62 812 0000 1111',
                'maps_url' => 'https://maps.app.goo.gl/contoh',
                'meta_title' => 'Judul Meta Uji',
                'meta_description' => 'Deskripsi meta uji.',
            ])
            ->assertRedirect(route('admin.pengaturan.edit'));

        $settings = SiteSetting::current();

        $this->assertSame('6281200001111', $settings->whatsapp_number);
        $this->assertSame('https://maps.app.goo.gl/contoh', $settings->maps_url);

        $this->get('/kontak')->assertOk()->assertSee('Jl. Uji No. 1');
    }

    public function test_url_maps_tidak_sah_ditolak(): void
    {
        $this->actingAs($this->admin())
            ->put(route('admin.pengaturan.update'), [
                'school_name' => 'SMK Uji',
                'maps_url' => 'bukan-url',
            ])
            ->assertSessionHasErrors('maps_url');
    }

    public function test_logo_sekolah_dapat_diunggah_dan_diganti(): void
    {
        Storage::fake('public');
        $admin = $this->admin();

        $this->actingAs($admin)->put(route('admin.pengaturan.update'), [
            'school_name' => 'SMK Logo Uji',
            'logo' => UploadedFile::fake()->image('logo.png', 800, 800),
        ])->assertRedirect(route('admin.pengaturan.edit'));

        $settings = SiteSetting::current();
        $firstLogo = $settings->logo_path;

        Storage::disk('public')->assertExists($firstLogo);

        $size = getimagesizefromstring(Storage::disk('public')->get($firstLogo));

        // Logo diperkecil ke lebar maksimal 400 px.
        $this->assertSame(400, $size[0]);

        $this->actingAs($admin)->put(route('admin.pengaturan.update'), [
            'school_name' => 'SMK Logo Uji',
            'logo' => UploadedFile::fake()->image('logo-baru.png', 600, 600),
        ])->assertRedirect(route('admin.pengaturan.edit'));

        $settings->refresh();

        $this->assertNotSame($firstLogo, $settings->logo_path);
        Storage::disk('public')->assertMissing($firstLogo);
        Storage::disk('public')->assertExists($settings->logo_path);
    }

    public function test_nama_tampilan_sekolah_wajib_diisi(): void
    {
        $this->actingAs($this->admin())
            ->put(route('admin.pengaturan.update'), ['school_name' => ''])
            ->assertSessionHasErrors('school_name');
    }

    public function test_meta_seo_dari_pengaturan_dipakai_halaman_beranda(): void
    {
        SiteSetting::current()->update([
            'school_name' => 'SMK Meta Uji',
            'meta_title' => 'Judul Beranda Uji',
            'meta_description' => 'Deskripsi beranda uji.',
        ]);

        $this->get('/')
            ->assertOk()
            ->assertSee('Judul Beranda Uji')
            ->assertSee('Deskripsi beranda uji.');
    }
}
