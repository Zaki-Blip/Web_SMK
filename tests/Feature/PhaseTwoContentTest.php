<?php

namespace Tests\Feature;

use App\Models\Agenda;
use App\Models\AlurPkl;
use App\Models\Faq;
use App\Models\SiteSetting;
use App\Models\StrukturOrganisasi;
use App\Models\Testimoni;
use App\Models\Unduhan;
use Database\Seeders\DemoSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
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

    public function test_alur_pkl_hanya_menampilkan_langkah_aktif(): void
    {
        AlurPkl::factory()->create(['judul' => 'Langkah Aktif', 'is_active' => true]);
        AlurPkl::factory()->inactive()->create(['judul' => 'Langkah Nonaktif']);

        $this->get('/alur-pkl')
            ->assertOk()
            ->assertSee('Langkah Aktif')
            ->assertDontSee('Langkah Nonaktif');
    }

    public function test_agenda_hanya_menampilkan_yang_terbit_dan_detail_dapat_dibuka(): void
    {
        $agenda = Agenda::factory()->create([
            'judul' => 'Agenda Terbit',
            'slug' => 'agenda-terbit',
            'is_published' => true,
        ]);
        Agenda::factory()->draft()->create([
            'judul' => 'Agenda Draf',
            'slug' => 'agenda-draf',
        ]);

        $this->get('/agenda')
            ->assertOk()
            ->assertSee('Agenda Terbit')
            ->assertDontSee('Agenda Draf');

        $this->get(route('agenda.show', $agenda))
            ->assertOk()
            ->assertSee('Agenda Terbit');
    }

    public function test_detail_agenda_draf_menghasilkan_404(): void
    {
        $agenda = Agenda::factory()->draft()->create(['slug' => 'agenda-draf-404']);

        $this->get(route('agenda.show', $agenda))->assertNotFound();
    }

    public function test_unduhan_hanya_menampilkan_yang_terbit_dan_dapat_diunduh(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('unduhan/panduan-pkl.pdf', '%PDF-1.4 contoh');

        $unduhan = Unduhan::factory()->create([
            'judul' => 'Panduan PKL',
            'berkas' => 'unduhan/panduan-pkl.pdf',
            'ukuran' => 15,
            'is_published' => true,
        ]);
        Unduhan::factory()->draft()->create([
            'judul' => 'Unduhan Draf',
            'berkas' => 'unduhan/draf.pdf',
        ]);

        $this->get('/unduhan')
            ->assertOk()
            ->assertSee('Panduan PKL')
            ->assertDontSee('Unduhan Draf');

        $this->get(route('unduhan.download', $unduhan))
            ->assertOk()
            ->assertDownload('panduan-pkl.pdf');
    }

    public function test_unduhan_draf_tidak_dapat_diunduh(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('unduhan/draf.pdf', '%PDF-1.4 contoh');

        $unduhan = Unduhan::factory()->draft()->create([
            'berkas' => 'unduhan/draf.pdf',
        ]);

        $this->get(route('unduhan.download', $unduhan))->assertNotFound();
    }

    public function test_halaman_fase_dua_dapat_dirender_dengan_data_demo(): void
    {
        Storage::fake('public');
        $this->seed(DemoSeeder::class);

        foreach (['/', '/struktur-organisasi', '/alur-pkl', '/agenda', '/unduhan', '/spmb', '/kontak'] as $url) {
            $this->get($url)->assertOk();
        }

        $agenda = Agenda::query()->published()->firstOrFail();

        $this->get(route('agenda.show', $agenda))->assertOk();
    }
}
