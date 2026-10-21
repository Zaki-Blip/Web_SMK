<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\GuruRequest;
use App\Models\Guru;
use App\Models\Jurusan;
use App\Support\ImageUploader;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use RuntimeException;

class GuruController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('q', ''));
        $tipe = (string) $request->query('tipe', '');
        $jurusanId = $request->query('jurusan_id');

        $gurus = Guru::query()
            ->with('jurusan')
            ->when($search !== '', fn ($q) => $q->where('nama', 'like', '%'.$search.'%'))
            ->when($tipe !== '', fn ($q) => $q->where('tipe', $tipe))
            ->when($jurusanId, fn ($q) => $q->where('jurusan_id', $jurusanId))
            ->ordered()
            ->paginate(12)
            ->withQueryString();

        return view('admin.guru.index', [
            'gurus' => $gurus,
            'search' => $search,
            'tipe' => $tipe,
            'jurusanId' => $jurusanId,
            'jurusans' => Jurusan::query()->ordered()->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.guru.create', [
            'guru' => new Guru(['is_active' => true, 'tipe' => 'guru', 'urutan' => (int) Guru::query()->max('urutan') + 1]),
            'jurusans' => Jurusan::query()->ordered()->get(),
        ]);
    }

    public function store(GuruRequest $request, ImageUploader $uploader): RedirectResponse
    {
        $data = $request->safe()->except('foto');
        try {
            if ($request->hasFile('foto')) {
                $data['foto'] = $uploader->store($request->file('foto'), 'guru', ImageUploader::WIDTH_CARD);
            }
        } catch (RuntimeException $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
        $guru = Guru::create($data);

        return redirect()->route('admin.guru.index')->with('success', 'Data guru/staf "'.$guru->nama.'" berhasil ditambahkan.');
    }

    public function edit(Guru $guru): View
    {
        return view('admin.guru.edit', ['guru' => $guru, 'jurusans' => Jurusan::query()->ordered()->get()]);
    }

    public function update(GuruRequest $request, Guru $guru, ImageUploader $uploader): RedirectResponse
    {
        $data = $request->safe()->except('foto');
        try {
            if ($request->hasFile('foto')) {
                $new = $uploader->store($request->file('foto'), 'guru', ImageUploader::WIDTH_CARD);
                $uploader->delete($guru->foto);
                $data['foto'] = $new;
            }
        } catch (RuntimeException $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
        $guru->update($data);

        return redirect()->route('admin.guru.index')->with('success', 'Data guru/staf "'.$guru->nama.'" berhasil diperbarui.');
    }

    public function destroy(Guru $guru, ImageUploader $uploader): RedirectResponse
    {
        $uploader->delete($guru->foto);
        $name = $guru->nama;
        $guru->delete();

        return redirect()->route('admin.guru.index')->with('success', 'Data "'.$name.'" berhasil dihapus.');
    }
}
