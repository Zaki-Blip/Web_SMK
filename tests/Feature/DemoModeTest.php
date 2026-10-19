<?php

namespace Tests\Feature;

use App\Models\Facility;
use App\Models\GalleryItem;
use App\Models\News;
use App\Models\Program;
use Database\Seeders\DemoSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Memastikan data demo ([CONTOH]) tampil dan seeder aman dijalankan berulang.
 */
class DemoModeTest extends TestCase
{
    use RefreshDatabase;

    public function test_data_demo_tampil_di_halaman_publik(): void
    {
        config(['school.demo_mode' => true]);

        $this->seed(DemoSeeder::class);

        $this->get('/')
            ->assertOk()
            ->assertSee('Versi demo', false)
            ->assertSee('[CONTOH]');

        $this->get('/program')->assertOk()->assertSee('[CONTOH]');
        $this->get('/fasilitas')->assertOk()->assertSee('[CONTOH]');
        $this->get('/galeri')->assertOk()->assertSee('[CONTOH]');
        $this->get('/berita')->assertOk()->assertSee('[CONTOH]');
        $this->get('/ppdb')->assertOk()->assertSee('[CONTOH]');
    }

    public function test_berita_draf_tidak_tampil_di_data_demo(): void
    {
        $this->seed(DemoSeeder::class);

        $this->get('/berita')->assertDontSee('Contoh Berita Draf');

        $this->get('/berita/contoh-berita-4')->assertNotFound();
    }

    public function test_seeder_demo_dapat_dijalankan_berulang_tanpa_duplikasi(): void
    {
        $this->seed(DemoSeeder::class);
        $this->seed(DemoSeeder::class);

        $this->assertSame(4, Program::query()->count());
        $this->assertSame(3, Facility::query()->count());
        $this->assertSame(6, GalleryItem::query()->count());
        $this->assertSame(4, News::query()->count());
    }
}
