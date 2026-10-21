<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TestimoniRequest;
use App\Models\Jurusan;
use App\Models\Testimoni;
use App\Support\ImageUploader;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use RuntimeException;

class TestimoniController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('q', ''));

        $items = Testimoni::query()
            ->with('jurusan')
            ->when($search !== '', fn ($q) => $q->where('nama', 'like', '%'.$search.'%'))
            ->ordered()
            ->paginate(12)
            ->withQueryString();

        return view('admin.testimoni.index', ['items' => $items, 'search' => $search]);
    }

    public function create(): View
    {
        return view('admin.testimoni.create', ['item' => new Testimoni(['is_active' => true]), 'jurusans' => Jurusan::query()->ordered()->get()]);
    }

    public function store(TestimoniRequest $request, ImageUploader $uploader): RedirectResponse
    {
        $data = $request->safe()->except('foto');
        try {
            if ($request->hasFile('foto')) {
                $data['foto'] = $uploader->store($request->file('foto'), 'testimoni', ImageUploader::WIDTH_CARD);
            }
        } catch (RuntimeException $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
        $item = Testimoni::create($data);

        return redirect()->route('admin.testimoni.index')->with('success', 'Testimoni "'.$item->nama.'" berhasil ditambahkan.');
    }

    public function edit(Testimoni $testimoni): View
    {
        return view('admin.testimoni.edit', ['item' => $testimoni, 'jurusans' => Jurusan::query()->ordered()->get()]);
    }

    public function update(TestimoniRequest $request, Testimoni $testimoni, ImageUploader $uploader): RedirectResponse
    {
        $data = $request->safe()->except('foto');
        try {
            if ($request->hasFile('foto')) {
                $new = $uploader->store($request->file('foto'), 'testimoni', ImageUploader::WIDTH_CARD);
                $uploader->delete($testimoni->foto);
                $data['foto'] = $new;
            }
        } catch (RuntimeException $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
        $testimoni->update($data);

        return redirect()->route('admin.testimoni.index')->with('success', 'Testimoni "'.$testimoni->nama.'" berhasil diperbarui.');
    }

    public function destroy(Testimoni $testimoni, ImageUploader $uploader): RedirectResponse
    {
        $uploader->delete($testimoni->foto);
        $name = $testimoni->nama;
        $testimoni->delete();

        return redirect()->route('admin.testimoni.index')->with('success', 'Testimoni "'.$name.'" berhasil dihapus.');
    }
}
