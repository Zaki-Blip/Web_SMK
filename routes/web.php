<?php

use App\Http\Controllers\Admin\AgendaController as AdminAgendaController;
use App\Http\Controllers\Admin\AkunController;
use App\Http\Controllers\Admin\AlurPklController as AdminAlurPklController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\BeritaController as AdminBeritaController;
use App\Http\Controllers\Admin\DasborController;
use App\Http\Controllers\Admin\EkstrakurikulerController as AdminEkstrakurikulerController;
use App\Http\Controllers\Admin\FaqController as AdminFaqController;
use App\Http\Controllers\Admin\FasilitasController as AdminFasilitasController;
use App\Http\Controllers\Admin\GaleriController as AdminGaleriController;
use App\Http\Controllers\Admin\GuruController as AdminGuruController;
use App\Http\Controllers\Admin\JurusanController as AdminJurusanController;
use App\Http\Controllers\Admin\LowonganBkkController as AdminLowonganBkkController;
use App\Http\Controllers\Admin\MitraIndustriController as AdminMitraIndustriController;
use App\Http\Controllers\Admin\PengaturanSitusController;
use App\Http\Controllers\Admin\PrestasiController as AdminPrestasiController;
use App\Http\Controllers\Admin\ProfilSekolahController;
use App\Http\Controllers\Admin\SpmbController as AdminSpmbController;
use App\Http\Controllers\Admin\StrukturOrganisasiController as AdminStrukturOrganisasiController;
use App\Http\Controllers\Admin\TestimoniController as AdminTestimoniController;
use App\Http\Controllers\Admin\UnduhanController as AdminUnduhanController;
use App\Http\Controllers\Public\AgendaController;
use App\Http\Controllers\Public\AlurPklController;
use App\Http\Controllers\Public\BerandaController;
use App\Http\Controllers\Public\BeritaController;
use App\Http\Controllers\Public\BkkController;
use App\Http\Controllers\Public\EkstrakurikulerController;
use App\Http\Controllers\Public\FasilitasController;
use App\Http\Controllers\Public\GaleriController;
use App\Http\Controllers\Public\GuruController;
use App\Http\Controllers\Public\IndustriController;
use App\Http\Controllers\Public\JurusanController;
use App\Http\Controllers\Public\KontakController;
use App\Http\Controllers\Public\PrestasiController;
use App\Http\Controllers\Public\ProfilController;
use App\Http\Controllers\Public\SitemapController;
use App\Http\Controllers\Public\SpmbController;
use App\Http\Controllers\Public\StrukturOrganisasiController;
use App\Http\Controllers\Public\UnduhanController;
use Illuminate\Support\Facades\Route;

/*
| Halaman publik
*/
Route::get('/', BerandaController::class)->name('beranda');
Route::get('/profil', ProfilController::class)->name('profil.index');
Route::get('/jurusan', [JurusanController::class, 'index'])->name('jurusan.index');
Route::get('/jurusan/{slug}', [JurusanController::class, 'show'])->name('jurusan.show');
Route::get('/guru', [GuruController::class, 'index'])->name('guru.index');
Route::get('/fasilitas', FasilitasController::class)->name('fasilitas.index');
Route::get('/industri', [IndustriController::class, 'index'])->name('industri.index');
Route::get('/prestasi', [PrestasiController::class, 'index'])->name('prestasi.index');
Route::get('/ekstrakurikuler', [EkstrakurikulerController::class, 'index'])->name('ekstrakurikuler.index');
Route::get('/ekstrakurikuler/{slug}', [EkstrakurikulerController::class, 'show'])->name('ekstrakurikuler.show');
Route::get('/bkk', [BkkController::class, 'index'])->name('bkk.index');
Route::get('/bkk/{id}', [BkkController::class, 'show'])->name('bkk.show');
Route::get('/berita', [BeritaController::class, 'index'])->name('berita.index');
Route::get('/berita/{slug}', [BeritaController::class, 'show'])->name('berita.show');
Route::get('/galeri', GaleriController::class)->name('galeri.index');
Route::get('/struktur-organisasi', StrukturOrganisasiController::class)->name('struktur.index');
Route::get('/alur-pkl', AlurPklController::class)->name('alur-pkl.index');
Route::get('/agenda', [AgendaController::class, 'index'])->name('agenda.index');
Route::get('/agenda/{agenda}', [AgendaController::class, 'show'])->name('agenda.show');
Route::get('/unduhan', [UnduhanController::class, 'index'])->name('unduhan.index');
Route::get('/unduhan/{unduhan}/unduh', [UnduhanController::class, 'download'])->name('unduhan.download');
Route::get('/spmb', SpmbController::class)->name('spmb.index');
Route::get('/kontak', KontakController::class)->name('kontak.index');

// Redirect permanen untuk URL lama. Jangan menambahkan alias route lama.
Route::permanentRedirect('/ppdb', '/spmb')->name('redirect.ppdb');
Route::permanentRedirect('/program', '/jurusan')->name('redirect.program');
Route::permanentRedirect('/program/{slug}', '/jurusan/{slug}')->name('redirect.program.show');

/*
| SEO
*/
Route::get('/sitemap.xml', SitemapController::class)->name('sitemap');

Route::get('/robots.txt', function () {
    return response(view('public.robots')->render(), 200)->header('Content-Type', 'text/plain');
})->name('robots');

/*
| Dasbor admin
*/
Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');
    });

    Route::middleware(['auth', 'admin'])->group(function () {
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

        Route::get('/', DasborController::class)->name('dasbor');

        Route::get('/akun', [AkunController::class, 'edit'])->name('akun.edit');
        Route::put('/akun', [AkunController::class, 'update'])->name('akun.update');

        Route::get('/profil', [ProfilSekolahController::class, 'edit'])->name('profil.edit');
        Route::put('/profil', [ProfilSekolahController::class, 'update'])->name('profil.update');

        Route::resource('jurusan', AdminJurusanController::class)->except('show');
        Route::resource('guru', AdminGuruController::class)->except('show');
        Route::resource('mitra-industri', AdminMitraIndustriController::class)
            ->except('show')
            ->parameters(['mitra-industri' => 'mitra']);
        Route::resource('prestasi', AdminPrestasiController::class)->except('show');
        Route::resource('ekstrakurikuler', AdminEkstrakurikulerController::class)->except('show');
        Route::resource('lowongan-bkk', AdminLowonganBkkController::class)
            ->except('show')
            ->parameters(['lowongan-bkk' => 'bkk']);
        Route::resource('testimoni', AdminTestimoniController::class)->except('show');
        Route::resource('faq', AdminFaqController::class)->except('show');
        Route::resource('struktur-organisasi', AdminStrukturOrganisasiController::class)
            ->except('show')
            ->parameters(['struktur-organisasi' => 'struktur']);
        Route::resource('alur-pkl', AdminAlurPklController::class)
            ->except('show')
            ->parameters(['alur-pkl' => 'alur']);
        Route::resource('agenda', AdminAgendaController::class)->except('show');
        Route::resource('unduhan', AdminUnduhanController::class)->except('show');
        Route::resource('fasilitas', AdminFasilitasController::class)
            ->except('show')
            ->parameters(['fasilitas' => 'fasilitas']);
        Route::resource('galeri', AdminGaleriController::class)
            ->except('show')
            ->parameters(['galeri' => 'galeri']);
        Route::resource('berita', AdminBeritaController::class)
            ->except('show')
            ->parameters(['berita' => 'berita']);

        Route::get('/spmb', [AdminSpmbController::class, 'edit'])->name('spmb.edit');
        Route::put('/spmb', [AdminSpmbController::class, 'update'])->name('spmb.update');

        Route::get('/pengaturan', [PengaturanSitusController::class, 'edit'])->name('pengaturan.edit');
        Route::put('/pengaturan', [PengaturanSitusController::class, 'update'])->name('pengaturan.update');
    });
});
