<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PrestasiRequest;
use App\Models\Prestasi;
use App\Support\ImageUploader;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use RuntimeException;

class PrestasiController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('q', ''));
        $tingkat = (string) $request->query('tingkat', '');

        $prestasis = Prestasi::query()
            ->when($search !== '', fn ($q) => $q->where('judul', 'like', '%'.$search.'%'))
            ->when($tingkat !== '', fn ($q) => $q->where('tingkat', $tingkat))
            ->ordered()
            ->paginate(12)
            ->withQueryString();

        return view('admin.prestasi.index', ['prestasis' => $prestasis, 'search' => $search, 'tingkat' => $tingkat]);
    }

    public function create(): View
    {
        return view('admin.prestasi.create', ['prestasi' => new Prestasi(['is_active' => true, 'tingkat' => 'sekolah', 'tahun' => (int) now()->year])]);
    }

    public function store(PrestasiRequest $request, ImageUploader $uploader): RedirectResponse
    {
        $data = $request->safe()->except('gambar');
        try {
            if ($request->hasFile('gambar')) {
                $data['gambar'] = $uploader->store($request->file('gambar'), 'prestasi', ImageUploader::WIDTH_LARGE);
            }
        } catch (RuntimeException $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
        $prestasi = Prestasi::create($data);

        return redirect()->route('admin.prestasi.index')->with('success', 'Prestasi "'.$prestasi->judul.'" berhasil ditambahkan.');
    }

    public function edit(Prestasi $prestasi): View
    {
        return view('admin.prestasi.edit', ['prestasi' => $prestasi]);
    }

    public function update(PrestasiRequest $request, Prestasi $prestasi, ImageUploader $uploader): RedirectResponse
    {
        $data = $request->safe()->except('gambar');
        try {
            if ($request->hasFile('gambar')) {
                $new = $uploader->store($request->file('gambar'), 'prestasi', ImageUploader::WIDTH_LARGE);
                $uploader->delete($prestasi->gambar);
                $data['gambar'] = $new;
            }
        } catch (RuntimeException $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
        $prestasi->update($data);

        return redirect()->route('admin.prestasi.index')->with('success', 'Prestasi "'.$prestasi->judul.'" berhasil diperbarui.');
    }

    public function destroy(Prestasi $prestasi, ImageUploader $uploader): RedirectResponse
    {
        $uploader->delete($prestasi->gambar);
        $title = $prestasi->judul;
        $prestasi->delete();

        return redirect()->route('admin.prestasi.index')->with('success', 'Prestasi "'.$title.'" berhasil dihapus.');
    }
}
