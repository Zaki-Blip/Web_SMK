<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\GalleryItemRequest;
use App\Models\GalleryItem;
use App\Support\ImageUploader;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use RuntimeException;

class GalleryController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('q', ''));

        $items = GalleryItem::query()
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

        return view('admin.gallery.index', [
            'items' => $items,
            'search' => $search,
        ]);
    }

    public function create(): View
    {
        return view('admin.gallery.create', [
            'item' => new GalleryItem([
                'is_published' => true,
                'sort_order' => (int) GalleryItem::query()->max('sort_order') + 1,
            ]),
        ]);
    }

    public function store(GalleryItemRequest $request, ImageUploader $uploader): RedirectResponse
    {
        $data = $request->safe()->except('image');

        try {
            $data['image_path'] = $uploader->store(
                $request->file('image'),
                'gallery',
                ImageUploader::WIDTH_LARGE,
            );
        } catch (RuntimeException $exception) {
            return back()->withInput()->with('error', $exception->getMessage());
        }

        $item = GalleryItem::create($data);

        return redirect()
            ->route('admin.gallery.index')
            ->with('success', 'Foto "'.$item->title.'" berhasil ditambahkan.');
    }

    public function edit(GalleryItem $gallery): View
    {
        return view('admin.gallery.edit', [
            'item' => $gallery,
        ]);
    }

    public function update(GalleryItemRequest $request, GalleryItem $gallery, ImageUploader $uploader): RedirectResponse
    {
        $data = $request->safe()->except('image');

        try {
            if ($request->hasFile('image')) {
                $newPath = $uploader->store($request->file('image'), 'gallery', ImageUploader::WIDTH_LARGE);
                $uploader->delete($gallery->image_path);
                $data['image_path'] = $newPath;
            }
        } catch (RuntimeException $exception) {
            return back()->withInput()->with('error', $exception->getMessage());
        }

        $gallery->update($data);

        return redirect()
            ->route('admin.gallery.index')
            ->with('success', 'Foto "'.$gallery->title.'" berhasil diperbarui.');
    }

    public function destroy(GalleryItem $gallery, ImageUploader $uploader): RedirectResponse
    {
        $uploader->delete($gallery->image_path);

        $title = $gallery->title;
        $gallery->delete();

        return redirect()
            ->route('admin.gallery.index')
            ->with('success', 'Foto "'.$title.'" berhasil dihapus.');
    }
}
