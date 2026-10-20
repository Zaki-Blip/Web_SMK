<?php

use App\Http\Controllers\Admin\AccountController;
use App\Http\Controllers\Admin\AdmissionController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FacilityController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\ProgramController;
use App\Http\Controllers\Admin\SchoolProfileController;
use App\Http\Controllers\Admin\SiteSettingController;
use App\Http\Controllers\Public\AdmissionController as PublicAdmissionController;
use App\Http\Controllers\Public\ContactController;
use App\Http\Controllers\Public\FacilityController as PublicFacilityController;
use App\Http\Controllers\Public\GalleryController as PublicGalleryController;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\NewsController as PublicNewsController;
use App\Http\Controllers\Public\ProfileController;
use App\Http\Controllers\Public\ProgramController as PublicProgramController;
use App\Http\Controllers\Public\SitemapController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Halaman publik
|--------------------------------------------------------------------------
*/
Route::get('/', HomeController::class)->name('home');
Route::get('/profil', ProfileController::class)->name('profile.index');
Route::get('/program', PublicProgramController::class)->name('program.index');
Route::get('/fasilitas', PublicFacilityController::class)->name('facility.index');
Route::get('/galeri', PublicGalleryController::class)->name('gallery.index');
Route::get('/berita', [PublicNewsController::class, 'index'])->name('news.index');
Route::get('/berita/{slug}', [PublicNewsController::class, 'show'])->name('news.show');
Route::get('/ppdb', PublicAdmissionController::class)->name('admission.index');
Route::get('/kontak', ContactController::class)->name('contact.index');

/*
|--------------------------------------------------------------------------
| SEO
|--------------------------------------------------------------------------
*/
Route::get('/sitemap.xml', SitemapController::class)->name('sitemap');
Route::get('/robots.txt', function () {
    return response(view('public.robots')->render(), 200)->header('Content-Type', 'text/plain');
})->name('robots');

/*
|--------------------------------------------------------------------------
| Dashboard admin
|--------------------------------------------------------------------------
| Semua route di dalam grup `auth` + `admin` hanya untuk pengguna login
| dengan role admin. Login dibatasi 5 percobaan per menit per email + IP.
*/
Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');
    });

    Route::middleware(['auth', 'admin'])->group(function () {
        // Logout hanya lewat POST agar tidak bisa dipicu dari tautan biasa.
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

        Route::get('/', DashboardController::class)->name('dashboard');

        Route::get('/account', [AccountController::class, 'edit'])->name('account.edit');
        Route::put('/account', [AccountController::class, 'update'])->name('account.update');

        Route::get('/profile', [SchoolProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [SchoolProfileController::class, 'update'])->name('profile.update');

        Route::resource('programs', ProgramController::class)->except('show');
        Route::resource('facilities', FacilityController::class)->except('show');
        Route::resource('gallery', GalleryController::class)->except('show');
        Route::resource('news', NewsController::class)->except('show');

        Route::get('/admission', [AdmissionController::class, 'edit'])->name('admission.edit');
        Route::put('/admission', [AdmissionController::class, 'update'])->name('admission.update');

        Route::get('/settings', [SiteSettingController::class, 'edit'])->name('settings.edit');
        Route::put('/settings', [SiteSettingController::class, 'update'])->name('settings.update');
    });
});
