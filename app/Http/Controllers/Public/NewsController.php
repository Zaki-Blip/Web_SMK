<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\SiteSetting;
use Illuminate\Contracts\View\View;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class NewsController extends Controller
{
    /**
     * Daftar berita published dengan pagination.
     */
    public function index(): View
    {
        return view('public.news.index', [
            'site' => SiteSetting::current(),
            'newsItems' => News::query()
                ->published()
                ->latestFirst()
                ->select(['id', 'title', 'slug', 'excerpt', 'image_path', 'published_at'])
                ->paginate(6),
        ]);
    }

    /**
     * Detail berita. Draft dan berita terjadwal di masa depan menghasilkan 404.
     */
    public function show(string $slug): View
    {
        $news = News::query()
            ->published()
            ->where('slug', $slug)
            ->first();

        if (! $news) {
            throw new NotFoundHttpException('Berita tidak ditemukan.');
        }

        $related = News::query()
            ->published()
            ->whereKeyNot($news->getKey())
            ->latestFirst()
            ->take(3)
            ->get();

        return view('public.news.show', [
            'site' => SiteSetting::current(),
            'news' => $news,
            'related' => $related,
        ]);
    }
}
