<?php

namespace Tests\Feature;

use App\Models\Berita;
use App\Models\Fasilitas;
use App\Models\Galeri;
use App\Models\Jurusan;
use Database\Seeders\DemoSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DemoModeTest extends TestCase
{
    use RefreshDatabase;

    public function test_data_demo_tampil_di_halaman_publik(): void
    {
        config(['school.demo_mode' => true]);

        $this->seed(DemoSeeder::class);

        $this->get('/')
            ->assertOk()
            ->assertSee('Versi demo', false);

        $this->get('/jurusan')->assertOk();
        $this->get('/fasilitas')->assertOk();
        $this->get('/galeri')->assertOk();
        $this->get('/berita')->assertOk();
        $this->get('/spmb')->assertOk();
    }

    public function test_berita_draf_tidak_tampil_di_data_demo(): void
    {
        $this->seed(DemoSeeder::class);

        $this->get('/berita')->assertDontSee('Berita Draf');

        $this->get('/berita/berita-draf')->assertNotFound();
    }

    public function test_seeder_demo_dapat_dijalankan_berulang_tanpa_duplikasi(): void
    {
        $this->seed(DemoSeeder::class);
        $this->seed(DemoSeeder::class);

        $this->assertSame(2, Jurusan::query()->count());
        $this->assertSame(8, Fasilitas::query()->count());
        $this->assertSame(6, Galeri::query()->count());
        $this->assertSame(9, Berita::query()->where('status', 'published')->count() + Berita::query()->where('status', 'draft')->count());
    }
}
