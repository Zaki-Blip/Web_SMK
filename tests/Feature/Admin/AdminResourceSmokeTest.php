<?php

namespace Tests\Feature\Admin;

use App\Models\Berita;
use App\Models\Ekstrakurikuler;
use App\Models\Faq;
use App\Models\Fasilitas;
use App\Models\Galeri;
use App\Models\Guru;
use App\Models\Jurusan;
use App\Models\Prestasi;
use App\Models\StrukturOrganisasi;
use App\Models\Testimoni;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class AdminResourceSmokeTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return array<string, array{string, class-string}>
     */
    public static function resourceRoutes(): array
    {
        return [
            'jurusan' => ['admin.jurusan', Jurusan::class],
            'guru' => ['admin.guru', Guru::class],
            'prestasi' => ['admin.prestasi', Prestasi::class],
            'ekstrakurikuler' => ['admin.ekstrakurikuler', Ekstrakurikuler::class],
            'testimoni' => ['admin.testimoni', Testimoni::class],
            'faq' => ['admin.faq', Faq::class],
            'fasilitas' => ['admin.fasilitas', Fasilitas::class],
            'galeri' => ['admin.galeri', Galeri::class],
            'berita' => ['admin.berita', Berita::class],
            'struktur organisasi' => ['admin.struktur-organisasi', StrukturOrganisasi::class],
        ];
    }

    #[DataProvider('resourceRoutes')]
    public function test_halaman_utama_resource_admin_dapat_dibuka(string $routePrefix, string $modelClass): void
    {
        $admin = User::factory()->admin()->create();

        $model = $modelClass::factory()->create();

        $this->actingAs($admin)->get(route($routePrefix.'.index'))->assertOk();
        $this->actingAs($admin)->get(route($routePrefix.'.create'))->assertOk();
        $this->actingAs($admin)->get(route($routePrefix.'.edit', $model))->assertOk();
    }

    public function test_halaman_pengaturan_dan_akun_admin_dapat_dibuka(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)->get(route('admin.dasbor'))->assertOk();
        $this->actingAs($admin)->get(route('admin.akun.edit'))->assertOk();
        $this->actingAs($admin)->get(route('admin.profil.edit'))->assertOk();
        $this->actingAs($admin)->get(route('admin.spmb.edit'))->assertOk();
        $this->actingAs($admin)->get(route('admin.pengaturan.edit'))->assertOk();
    }
}
