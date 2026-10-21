<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\SiteSetting;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class BeritaController extends Controller
{
    /**
     * Daftar berita published dengan pagination.
     */
    public function index(Request $request): View
    {
        $kategori = trim((string) $request->query('kategori', ''));

        $newsItems = Berita::query()
            ->published()
            ->when($kategori !== '', fn ($q) => $q->where('kategori', $kategori))
            ->latestFirst()
            ->select(['id', 'title', 'slug', 'excerpt', 'image_path', 'kategori', 'published_at'])
            ->paginate(6)
            ->withQueryString();

        $kategoris = Berita::query()
            ->published()
            ->whereNotNull('kategori')
            ->where('kategori', '!=', '')
            ->distinct()
            ->orderBy('kategori')
            ->pluck('kategori');

        return view('public.berita.index', [
            'site' => SiteSetting::current(),
            'newsItems' => $newsItems,
            'kategori' => $kategori,
            'kategoris' => $kategoris,
        ]);
    }

    /**
     * Detail berita. Draft dan berita terjadwal di masa depan menghasilkan 404.
     */
    public function show(string $slug): View
    {
        $news = Berita::query()
            ->published()
            ->where('slug', $slug)
            ->first();

        if (! $news) {
            throw new NotFoundHttpException('Berita tidak ditemukan.');
        }

        $related = Berita::query()
            ->published()
            ->whereKeyNot($news->getKey())
            ->latestFirst()
            ->take(3)
            ->get();

        return view('public.berita.show', [
            'site' => SiteSetting::current(),
            'news' => $news,
            'related' => $related,
        ]);
    }
}
