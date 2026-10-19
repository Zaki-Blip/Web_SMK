<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Facility;
use App\Models\GalleryItem;
use App\Models\News;
use App\Models\Program;
use App\Models\SchoolProfile;
use App\Models\SiteSetting;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    /**
     * Beranda: profil singkat, program, fasilitas, galeri pilihan, berita terbaru.
     */
    public function __invoke(): View
    {
        return view('public.home', [
            'site' => SiteSetting::current(),
            'profile' => SchoolProfile::current(),
            'programs' => Program::query()->published()->ordered()->take(3)->get(),
            'facilities' => Facility::query()->published()->ordered()->take(3)->get(),
            'galleryItems' => GalleryItem::query()->published()->ordered()->take(4)->get(),
            'newsItems' => News::query()->published()->latestFirst()->take(3)->get(),
        ]);
    }
}
