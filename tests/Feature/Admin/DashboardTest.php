<?php

namespace Tests\Feature\Admin;

use App\Models\Facility;
use App\Models\GalleryItem;
use App\Models\News;
use App\Models\Program;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_menampilkan_jumlah_konten_dari_database(): void
    {
        Program::factory()->count(3)->create();
        Facility::factory()->count(2)->create();
        GalleryItem::factory()->count(4)->create();
        News::factory()->count(2)->create();
        News::factory()->draft()->create();

        $response = $this->actingAs(User::factory()->admin()->create())
            ->get(route('admin.dashboard'));

        $response->assertOk()
            ->assertSee('Ringkasan konten')
            ->assertSee('Akses cepat');

        // Nilai diambil dari view agar tidak bergantung pada format HTML tertentu.
        $response->assertViewHas('programCount', 3);
        $response->assertViewHas('facilityCount', 2);
        $response->assertViewHas('galleryCount', 4);
        $response->assertViewHas('newsPublishedCount', 2);
        $response->assertViewHas('newsDraftCount', 1);
    }

    public function test_dashboard_aman_saat_database_kosong(): void
    {
        $this->actingAs(User::factory()->admin()->create())
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('Belum ada berita.');
    }

    public function test_dashboard_menampilkan_berita_draft_di_daftar_terbaru(): void
    {
        News::factory()->draft()->create(['title' => 'Draf Dashboard']);

        $this->actingAs(User::factory()->admin()->create())
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('Draf Dashboard')
            ->assertSee('Draft');
    }
}
