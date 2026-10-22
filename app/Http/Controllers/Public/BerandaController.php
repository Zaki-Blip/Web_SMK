<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\Faq;
use App\Models\Fasilitas;
use App\Models\Galeri;
use App\Models\Jurusan;
use App\Models\Prestasi;
use App\Models\SchoolProfile;
use App\Models\SiteSetting;
use App\Models\Spmb;
use App\Models\Testimoni;
use Illuminate\Contracts\View\View;

class BerandaController extends Controller
{
    public function __invoke(): View
    {
        $jurusans = Jurusan::query()->active()->ordered()->take(4)->get();

        return view('public.beranda', [
            'site' => SiteSetting::current(),
            'profile' => SchoolProfile::current(),
            'spmb' => Spmb::current(),
            'jurusans' => $jurusans,
            'facilities' => Fasilitas::query()->published()->ordered()->take(3)->get(),
            'galleryItems' => Galeri::query()->published()->ordered()->take(4)->get(),
            'newsItems' => Berita::query()->published()->latestFirst()->take(4)->get(),
            'prestasis' => Prestasi::query()->active()->ordered()->take(4)->get(),
            'testimonis' => Testimoni::query()->with('jurusan')->active()->ordered()->take(4)->get(),
            'faqs' => Faq::query()->active()->ordered()->take(6)->get(),
        ]);
    }
}
