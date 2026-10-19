<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\NewsRequest;
use App\Models\News;
use App\Support\ImageUploader;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use RuntimeException;

class NewsController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('q', ''));
        $status = (string) $request->query('status', '');

        // Hanya nilai status yang dikenal yang dipakai sebagai filter.
        if (! in_array($status, [News::STATUS_DRAFT, News::STATUS_PUBLISHED], true)) {
            $status = '';
        }

        $newsItems = News::query()
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('title', 'like', '%'.$search.'%')
                        ->orWhere('excerpt', 'like', '%'.$search.'%')
                        ->orWhere('body', 'like', '%'.$search.'%');
                });
            })
            ->when($status !== '', fn ($query) => $query->where('status', $status))
            ->latestFirst()
            ->paginate(10)
            ->withQueryString();

        return view('admin.news.index', [
            'newsItems' => $newsItems,
            'search' => $search,
            'status' => $status,
            'totalCount' => News::query()->count(),
            'draftCount' => News::query()->where('status', News::STATUS_DRAFT)->count(),
            'publishedCount' => News::query()->where('status', News::STATUS_PUBLISHED)->count(),
        ]);
    }

    public function create(): View
    {
        return view('admin.news.create', [
            'news' => new News([
                'status' => News::STATUS_DRAFT,
                'published_at' => now(),
            ]),
        ]);
    }

    public function store(NewsRequest $request, ImageUploader $uploader): RedirectResponse
    {
        $data = $request->safe()->except('image');

        try {
            if ($request->hasFile('image')) {
                $data['image_path'] = $uploader->store(
                    $request->file('image'),
                    'news',
                    ImageUploader::WIDTH_LARGE,
                );
            }
        } catch (RuntimeException $exception) {
            return back()->withInput()->with('error', $exception->getMessage());
        }

        $news = News::create($data);

        return redirect()
            ->route('admin.news.index')
            ->with('success', 'Berita "'.$news->title.'" berhasil disimpan.');
    }

    public function edit(News $news): View
    {
        return view('admin.news.edit', [
            'news' => $news,
        ]);
    }

    public function update(NewsRequest $request, News $news, ImageUploader $uploader): RedirectResponse
    {
        $data = $request->safe()->except('image');

        try {
            if ($request->hasFile('image')) {
                $newPath = $uploader->store($request->file('image'), 'news', ImageUploader::WIDTH_LARGE);
                $uploader->delete($news->image_path);
                $data['image_path'] = $newPath;
            }
        } catch (RuntimeException $exception) {
            return back()->withInput()->with('error', $exception->getMessage());
        }

        $news->update($data);

        return redirect()
            ->route('admin.news.index')
            ->with('success', 'Berita "'.$news->title.'" berhasil diperbarui.');
    }

    public function destroy(News $news, ImageUploader $uploader): RedirectResponse
    {
        $uploader->delete($news->image_path);

        $title = $news->title;
        $news->delete();

        return redirect()
            ->route('admin.news.index')
            ->with('success', 'Berita "'.$title.'" berhasil dihapus.');
    }
}
