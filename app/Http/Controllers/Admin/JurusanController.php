<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\JurusanRequest;
use App\Models\Jurusan;
use App\Support\ImageUploader;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use RuntimeException;

class JurusanController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('q', ''));

        $jurusans = Jurusan::query()
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($sub) use ($search) {
                    $sub->where('nama', 'like', '%'.$search.'%')
                        ->orWhere('ringkasan', 'like', '%'.$search.'%');
                });
            })
            ->ordered()
            ->paginate(10)
            ->withQueryString();

        return view('admin.jurusan.index', [
            'jurusans' => $jurusans,
            'search' => $search,
        ]);
    }

    public function create(): View
    {
        return view('admin.jurusan.create', [
            'jurusan' => new Jurusan(['is_active' => true, 'urutan' => (int) Jurusan::query()->max('urutan') + 1, 'lama_belajar' => '3 tahun']),
        ]);
    }

    public function store(JurusanRequest $request, ImageUploader $uploader): RedirectResponse
    {
        $data = $request->safe()->except('gambar');

        try {
            if ($request->hasFile('gambar')) {
                $data['gambar'] = $uploader->store($request->file('gambar'), 'jurusan', ImageUploader::WIDTH_CARD);
            }
        } catch (RuntimeException $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }

        $jurusan = Jurusan::create($data);

        return redirect()->route('admin.jurusan.index')->with('success', 'Jurusan "'.$jurusan->nama.'" berhasil ditambahkan.');
    }

    public function edit(Jurusan $jurusan): View
    {
        return view('admin.jurusan.edit', ['jurusan' => $jurusan]);
    }

    public function update(JurusanRequest $request, Jurusan $jurusan, ImageUploader $uploader): RedirectResponse
    {
        $data = $request->safe()->except('gambar');

        try {
            if ($request->hasFile('gambar')) {
                $new = $uploader->store($request->file('gambar'), 'jurusan', ImageUploader::WIDTH_CARD);
                $uploader->delete($jurusan->gambar);
                $data['gambar'] = $new;
            }
        } catch (RuntimeException $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }

        $jurusan->update($data);

        return redirect()->route('admin.jurusan.index')->with('success', 'Jurusan "'.$jurusan->nama.'" berhasil diperbarui.');
    }

    public function destroy(Jurusan $jurusan, ImageUploader $uploader): RedirectResponse
    {
        $uploader->delete($jurusan->gambar);
        $name = $jurusan->nama;
        $jurusan->delete();

        return redirect()->route('admin.jurusan.index')->with('success', 'Jurusan "'.$name.'" berhasil dihapus.');
    }
}
