<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\EkstrakurikulerRequest;
use App\Models\Ekstrakurikuler;
use App\Support\ImageUploader;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use RuntimeException;

class EkstrakurikulerController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('q', ''));

        $items = Ekstrakurikuler::query()
            ->when($search !== '', fn ($q) => $q->where('nama', 'like', '%'.$search.'%'))
            ->ordered()
            ->paginate(12)
            ->withQueryString();

        return view('admin.ekstrakurikuler.index', ['items' => $items, 'search' => $search]);
    }

    public function create(): View
    {
        return view('admin.ekstrakurikuler.create', ['item' => new Ekstrakurikuler(['is_active' => true, 'urutan' => (int) Ekstrakurikuler::query()->max('urutan') + 1])]);
    }

    public function store(EkstrakurikulerRequest $request, ImageUploader $uploader): RedirectResponse
    {
        $data = $request->safe()->except('gambar');
        try {
            if ($request->hasFile('gambar')) {
                $data['gambar'] = $uploader->store($request->file('gambar'), 'ekstrakurikuler', ImageUploader::WIDTH_CARD);
            }
        } catch (RuntimeException $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
        $item = Ekstrakurikuler::create($data);

        return redirect()->route('admin.ekstrakurikuler.index')->with('success', 'Ekstrakurikuler "'.$item->nama.'" berhasil ditambahkan.');
    }

    public function edit(Ekstrakurikuler $ekstrakurikuler): View
    {
        return view('admin.ekstrakurikuler.edit', ['item' => $ekstrakurikuler]);
    }

    public function update(EkstrakurikulerRequest $request, Ekstrakurikuler $ekstrakurikuler, ImageUploader $uploader): RedirectResponse
    {
        $data = $request->safe()->except('gambar');
        try {
            if ($request->hasFile('gambar')) {
                $new = $uploader->store($request->file('gambar'), 'ekstrakurikuler', ImageUploader::WIDTH_CARD);
                $uploader->delete($ekstrakurikuler->gambar);
                $data['gambar'] = $new;
            }
        } catch (RuntimeException $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
        $ekstrakurikuler->update($data);

        return redirect()->route('admin.ekstrakurikuler.index')->with('success', 'Ekstrakurikuler "'.$ekstrakurikuler->nama.'" berhasil diperbarui.');
    }

    public function destroy(Ekstrakurikuler $ekstrakurikuler, ImageUploader $uploader): RedirectResponse
    {
        $uploader->delete($ekstrakurikuler->gambar);
        $name = $ekstrakurikuler->nama;
        $ekstrakurikuler->delete();

        return redirect()->route('admin.ekstrakurikuler.index')->with('success', 'Ekstrakurikuler "'.$name.'" berhasil dihapus.');
    }
}
