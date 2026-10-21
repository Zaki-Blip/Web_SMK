<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UnduhanRequest;
use App\Models\Unduhan;
use App\Support\DocumentUploader;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use RuntimeException;

class UnduhanController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('q', ''));

        $items = Unduhan::query()
            ->when($search !== '', fn ($query) => $query->where('judul', 'like', '%'.$search.'%'))
            ->ordered()
            ->paginate(20)
            ->withQueryString();

        return view('admin.unduhan.index', ['items' => $items, 'search' => $search]);
    }

    public function create(): View
    {
        return view('admin.unduhan.create', [
            'item' => new Unduhan(['is_published' => true, 'urutan' => (int) Unduhan::query()->max('urutan') + 1]),
        ]);
    }

    public function store(UnduhanRequest $request, DocumentUploader $uploader): RedirectResponse
    {
        $data = $request->safe()->except('berkas');

        try {
            $path = $uploader->store($request->file('berkas'));
            $data['berkas'] = $path;
            $data['ukuran'] = $uploader->size($path);
        } catch (RuntimeException $exception) {
            return back()->withInput()->with('error', $exception->getMessage());
        }

        $item = Unduhan::create($data);

        return redirect()
            ->route('admin.unduhan.index')
            ->with('success', 'Unduhan "'.$item->judul.'" berhasil ditambahkan.');
    }

    public function edit(Unduhan $unduhan): View
    {
        return view('admin.unduhan.edit', ['item' => $unduhan]);
    }

    public function update(UnduhanRequest $request, Unduhan $unduhan, DocumentUploader $uploader): RedirectResponse
    {
        $data = $request->safe()->except('berkas');

        try {
            if ($request->hasFile('berkas')) {
                $newPath = $uploader->store($request->file('berkas'));
                $uploader->delete($unduhan->berkas);
                $data['berkas'] = $newPath;
                $data['ukuran'] = $uploader->size($newPath);
            }
        } catch (RuntimeException $exception) {
            return back()->withInput()->with('error', $exception->getMessage());
        }

        $unduhan->update($data);

        return redirect()
            ->route('admin.unduhan.index')
            ->with('success', 'Unduhan "'.$unduhan->judul.'" berhasil diperbarui.');
    }

    public function destroy(Unduhan $unduhan, DocumentUploader $uploader): RedirectResponse
    {
        $uploader->delete($unduhan->berkas);
        $judul = $unduhan->judul;
        $unduhan->delete();

        return redirect()
            ->route('admin.unduhan.index')
            ->with('success', 'Unduhan "'.$judul.'" berhasil dihapus.');
    }
}
