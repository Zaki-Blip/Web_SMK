<?php

namespace Tests\Feature\Admin;

use App\Models\Berita;
use App\Models\Jurusan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_menampilkan_jumlah_konten_dari_database(): void
    {
        Jurusan::factory()->count(3)->create();
        Berita::factory()->count(2)->create();
        Berita::factory()->draft()->create();

        $response = $this->actingAs(User::factory()->admin()->create())
            ->get(route('admin.dasbor'));

        $response->assertOk()
            ->assertSee('Ringkasan konten');

        $response->assertViewHas('jurusanCount', 3);
        $response->assertViewHas('beritaCount', 3);
    }

    public function test_dashboard_aman_saat_database_kosong(): void
    {
        $this->actingAs(User::factory()->admin()->create())
            ->get(route('admin.dasbor'))
            ->assertOk()
            ->assertSee('Belum ada berita.');
    }

    public function test_dashboard_menampilkan_berita_draft_di_daftar_terbaru(): void
    {
        Berita::factory()->draft()->create(['title' => 'Draf Dashboard']);

        $this->actingAs(User::factory()->admin()->create())
            ->get(route('admin.dasbor'))
            ->assertOk()
            ->assertSee('Draf Dashboard')
            ->assertSee('Draft');
    }
}
