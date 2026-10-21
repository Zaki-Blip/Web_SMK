<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BeritaRequest;
use App\Models\Berita;
use App\Support\ImageUploader;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use RuntimeException;

class BeritaController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('q', ''));
        $status = (string) $request->query('status', '');

        // Hanya nilai status yang dikenal yang dipakai sebagai filter.
        if (! in_array($status, [Berita::STATUS_DRAFT, Berita::STATUS_PUBLISHED], true)) {
            $status = '';
        }

        $newsItems = Berita::query()
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('title', 'like', '%'.$search.'%')
                        ->orWhere('excerpt', 'like', '%'.$search.'%')
                        ->orWhere('kategori', 'like', '%'.$search.'%')
                        ->orWhere('body', 'like', '%'.$search.'%');
                });
            })
            ->when($status !== '', fn ($query) => $query->where('status', $status))
            ->latestFirst()
            ->paginate(10)
            ->withQueryString();

        return view('admin.berita.index', [
            'newsItems' => $newsItems,
            'search' => $search,
            'status' => $status,
            'totalCount' => Berita::query()->count(),
            'draftCount' => Berita::query()->where('status', Berita::STATUS_DRAFT)->count(),
            'publishedCount' => Berita::query()->where('status', Berita::STATUS_PUBLISHED)->count(),
        ]);
    }

    public function create(): View
    {
        return view('admin.berita.create', [
            'news' => new Berita([
                'status' => Berita::STATUS_DRAFT,
                'published_at' => now(),
            ]),
        ]);
    }

    public function store(BeritaRequest $request, ImageUploader $uploader): RedirectResponse
    {
        $data = $request->safe()->except('image');

        try {
            if ($request->hasFile('image')) {
                $data['image_path'] = $uploader->store(
                    $request->file('image'),
                    'berita',
                    ImageUploader::WIDTH_LARGE,
                );
            }
        } catch (RuntimeException $exception) {
            return back()->withInput()->with('error', $exception->getMessage());
        }

        $berita = Berita::create($data);

        return redirect()
            ->route('admin.berita.index')
            ->with('success', 'Berita "'.$berita->title.'" berhasil disimpan.');
    }

    public function edit(Berita $berita): View
    {
        return view('admin.berita.edit', [
            'news' => $berita,
        ]);
    }

    public function update(BeritaRequest $request, Berita $berita, ImageUploader $uploader): RedirectResponse
    {
        $data = $request->safe()->except('image');

        try {
            if ($request->hasFile('image')) {
                $newPath = $uploader->store($request->file('image'), 'berita', ImageUploader::WIDTH_LARGE);
                $uploader->delete($berita->image_path);
                $data['image_path'] = $newPath;
            }
        } catch (RuntimeException $exception) {
            return back()->withInput()->with('error', $exception->getMessage());
        }

        $berita->update($data);

        return redirect()
            ->route('admin.berita.index')
            ->with('success', 'Berita "'.$berita->title.'" berhasil diperbarui.');
    }

    public function destroy(Berita $berita, ImageUploader $uploader): RedirectResponse
    {
        $uploader->delete($berita->image_path);

        $title = $berita->title;
        $berita->delete();

        return redirect()
            ->route('admin.berita.index')
            ->with('success', 'Berita "'.$title.'" berhasil dihapus.');
    }
}
