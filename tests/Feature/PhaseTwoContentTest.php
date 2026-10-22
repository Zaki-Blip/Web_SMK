<?php

namespace Tests\Feature;

use App\Models\Faq;
use App\Models\SiteSetting;
use App\Models\StrukturOrganisasi;
use App\Models\Testimoni;
use Database\Seeders\DemoSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PhaseTwoContentTest extends TestCase
{
    use RefreshDatabase;

    public function test_beranda_menampilkan_testimoni_dan_faq_yang_aktif(): void
    {
        Testimoni::factory()->create(['nama' => 'Alumni Aktif', 'isi' => 'Testimoni aktif.', 'is_active' => true]);
        Testimoni::factory()->create(['nama' => 'Alumni Nonaktif', 'isi' => 'Testimoni nonaktif.', 'is_active' => false]);
        Faq::factory()->create(['pertanyaan' => 'Pertanyaan aktif?', 'jawaban' => 'Jawaban aktif.', 'is_active' => true]);
        Faq::factory()->create(['pertanyaan' => 'Pertanyaan nonaktif?', 'jawaban' => 'Jawaban nonaktif.', 'is_active' => false]);

        $this->get('/')
            ->assertOk()
            ->assertSee('Alumni Aktif')
            ->assertDontSee('Alumni Nonaktif')
            ->assertSee('Pertanyaan aktif?')
            ->assertDontSee('Pertanyaan nonaktif?');
    }

    public function test_halaman_spmb_menampilkan_faq_kategori_spmb(): void
    {
        Faq::factory()->create(['pertanyaan' => 'Kapan SPMB dibuka?', 'kategori' => 'spmb', 'is_active' => true]);
        Faq::factory()->create(['pertanyaan' => 'Pertanyaan umum?', 'kategori' => 'umum', 'is_active' => true]);

        $this->get('/spmb')
            ->assertOk()
            ->assertSee('Kapan SPMB dibuka?')
            ->assertDontSee('Pertanyaan umum?');
    }

    public function test_tautan_media_sosial_tampil_dan_masuk_json_ld(): void
    {
        SiteSetting::current()->update([
            'facebook_url' => 'https://www.facebook.com/sekolah-contoh',
            'instagram_url' => 'https://www.instagram.com/sekolah-contoh',
        ]);

        $this->get('/')
            ->assertOk()
            ->assertSee('www.facebook.com/sekolah-contoh', false)
            ->assertSee('www.instagram.com/sekolah-contoh', false)
            ->assertSee('"sameAs"', false);
    }

    public function test_struktur_organisasi_menampilkan_hierarki_aktif(): void
    {
        $root = StrukturOrganisasi::factory()->create([
            'nama' => 'Kepala Sekolah Uji',
            'jabatan' => 'Kepala Sekolah',
            'parent_id' => null,
            'is_active' => true,
        ]);
        StrukturOrganisasi::factory()->create([
            'nama' => 'Wakil Uji',
            'jabatan' => 'Wakil Kepala',
            'parent_id' => $root->id,
            'is_active' => true,
        ]);
        StrukturOrganisasi::factory()->inactive()->create(['nama' => 'Struktur Nonaktif']);

        $this->get('/struktur-organisasi')
            ->assertOk()
            ->assertSee('Kepala Sekolah Uji')
            ->assertSee('Wakil Uji')
            ->assertDontSee('Struktur Nonaktif');
    }

    public function test_halaman_fase_dua_dapat_dirender_dengan_data_demo(): void
    {
        $this->seed(DemoSeeder::class);

        foreach (['/', '/struktur-organisasi', '/spmb', '/kontak'] as $url) {
            $this->get($url)->assertOk();
        }
    }
}
