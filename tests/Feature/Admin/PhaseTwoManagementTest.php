<?php

namespace Tests\Feature\Admin;

use App\Models\SiteSetting;
use App\Models\StrukturOrganisasi;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PhaseTwoManagementTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): User
    {
        return User::factory()->admin()->create();
    }

    public function test_admin_dapat_menambah_struktur_organisasi(): void
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
