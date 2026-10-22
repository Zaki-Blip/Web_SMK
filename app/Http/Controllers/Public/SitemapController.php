<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\SiteSetting;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function __invoke(): Response
    {
        $site = SiteSetting::current();

        $staticRoutes = [
            ['url' => route('beranda'), 'priority' => '1.0'],
            ['url' => route('profil.index'), 'priority' => '0.8'],
            ['url' => route('jurusan.index'), 'priority' => '0.8'],
            ['url' => route('guru.index'), 'priority' => '0.7'],
            ['url' => route('fasilitas.index'), 'priority' => '0.8'],
            ['url' => route('prestasi.index'), 'priority' => '0.7'],
            ['url' => route('ekstrakurikuler.index'), 'priority' => '0.7'],
            ['url' => route('galeri.index'), 'priority' => '0.7'],
            ['url' => route('struktur.index'), 'priority' => '0.7'],
            ['url' => route('berita.index'), 'priority' => '0.8'],
            ['url' => route('spmb.index'), 'priority' => '0.9'],
            ['url' => route('kontak.index'), 'priority' => '0.7'],
        ];

        $news = Berita::query()->published()->latestFirst()->get(['slug', 'updated_at']);

        $xml = view('public.sitemap', [
            'staticRoutes' => $staticRoutes,
            'news' => $news,
            'siteName' => $site->school_name ?: config('school.fallback.school_name'),
        ])->render();

        return response($xml, 200)->header('Content-Type', 'application/xml');
    }
}
