<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\SiteSetting;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    /**
     * Sitemap XML dinamis: halaman publik statis + berita yang sudah published.
     */
    public function __invoke(): Response
    {
        $site = SiteSetting::current();

        $staticRoutes = [
            ['url' => route('home'), 'priority' => '1.0'],
            ['url' => route('profile.index'), 'priority' => '0.8'],
            ['url' => route('program.index'), 'priority' => '0.8'],
            ['url' => route('facility.index'), 'priority' => '0.8'],
            ['url' => route('gallery.index'), 'priority' => '0.7'],
            ['url' => route('news.index'), 'priority' => '0.8'],
            ['url' => route('admission.index'), 'priority' => '0.9'],
            ['url' => route('contact.index'), 'priority' => '0.7'],
        ];

        $news = News::query()->published()->latestFirst()->get(['slug', 'updated_at']);

        $xml = view('public.sitemap', [
            'staticRoutes' => $staticRoutes,
            'news' => $news,
            'siteName' => $site->school_name ?: config('school.fallback.school_name'),
        ])->render();

        return response($xml, 200)->header('Content-Type', 'application/xml');
    }
}
