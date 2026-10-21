<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\GaleriRequest;
use App\Models\Galeri;
use App\Support\ImageUploader;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use RuntimeException;

class GaleriController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('q', ''));

        $items = Galeri::query()
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('title', 'like', '%'.$search.'%')
                        ->orWhere('caption', 'like', '%'.$search.'%')
                        ->orWhere('category', 'like', '%'.$search.'%');
                });
            })
            ->ordered()
            ->paginate(12)
            ->withQueryString();

        return view('admin.galeri.index', [
            'items' => $items,
            'search' => $search,
        ]);
    }

    public function create(): View
    {
        return view('admin.galeri.create', [
            'item' => new Galeri([
                'is_published' => true,
                'sort_order' => (int) Galeri::query()->max('sort_order') + 1,
            ]),
        ]);
    }

    public function store(GaleriRequest $request, ImageUploader $uploader): RedirectResponse
    {
        $data = $request->safe()->except('image');

        try {
            $data['image_path'] = $uploader->store(
                $request->file('image'),
                'galeri',
                ImageUploader::WIDTH_LARGE,
            );
        } catch (RuntimeException $exception) {
            return back()->withInput()->with('error', $exception->getMessage());
        }

        $item = Galeri::create($data);

        return redirect()
            ->route('admin.galeri.index')
            ->with('success', 'Foto "'.$item->title.'" berhasil ditambahkan.');
    }

    public function edit(Galeri $galeri): View
    {
        return view('admin.galeri.edit', [
            'item' => $galeri,
        ]);
    }

    public function update(GaleriRequest $request, Galeri $galeri, ImageUploader $uploader): RedirectResponse
    {
        $data = $request->safe()->except('image');

        try {
            if ($request->hasFile('image')) {
                $newPath = $uploader->store($request->file('image'), 'galeri', ImageUploader::WIDTH_LARGE);
                $uploader->delete($galeri->image_path);
                $data['image_path'] = $newPath;
            }
        } catch (RuntimeException $exception) {
            return back()->withInput()->with('error', $exception->getMessage());
        }

        $galeri->update($data);

        return redirect()
            ->route('admin.galeri.index')
            ->with('success', 'Foto "'.$galeri->title.'" berhasil diperbarui.');
    }

    public function destroy(Galeri $galeri, ImageUploader $uploader): RedirectResponse
    {
        $uploader->delete($galeri->image_path);

        $title = $galeri->title;
        $galeri->delete();

        return redirect()
            ->route('admin.galeri.index')
            ->with('success', 'Foto "'.$title.'" berhasil dihapus.');
    }
}
