<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MitraIndustriRequest;
use App\Models\MitraIndustri;
use App\Support\ImageUploader;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use RuntimeException;

class MitraIndustriController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('q', ''));

        $mitras = MitraIndustri::query()
            ->when($search !== '', fn ($q) => $q->where('nama', 'like', '%'.$search.'%'))
            ->ordered()
            ->paginate(12)
            ->withQueryString();

        return view('admin.mitra.index', ['mitras' => $mitras, 'search' => $search]);
    }

    public function create(): View
    {
        return view('admin.mitra.create', ['mitra' => new MitraIndustri(['is_active' => true, 'urutan' => (int) MitraIndustri::query()->max('urutan') + 1])]);
    }

    public function store(MitraIndustriRequest $request, ImageUploader $uploader): RedirectResponse
    {
        $data = $request->safe()->except('logo');
        try {
            if ($request->hasFile('logo')) {
                $data['logo'] = $uploader->store($request->file('logo'), 'mitra', ImageUploader::WIDTH_LOGO);
            }
        } catch (RuntimeException $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
        $mitra = MitraIndustri::create($data);

        return redirect()->route('admin.mitra-industri.index')->with('success', 'Mitra "'.$mitra->nama.'" berhasil ditambahkan.');
    }

    public function edit(MitraIndustri $mitra): View
    {
        return view('admin.mitra.edit', ['mitra' => $mitra]);
    }

    public function update(MitraIndustriRequest $request, MitraIndustri $mitra, ImageUploader $uploader): RedirectResponse
    {
        $data = $request->safe()->except('logo');
        try {
            if ($request->hasFile('logo')) {
                $new = $uploader->store($request->file('logo'), 'mitra', ImageUploader::WIDTH_LOGO);
                $uploader->delete($mitra->logo);
                $data['logo'] = $new;
            }
        } catch (RuntimeException $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
        $mitra->update($data);

        return redirect()->route('admin.mitra-industri.index')->with('success', 'Mitra "'.$mitra->nama.'" berhasil diperbarui.');
    }

    public function destroy(MitraIndustri $mitra, ImageUploader $uploader): RedirectResponse
    {
        $uploader->delete($mitra->logo);
        $name = $mitra->nama;
        $mitra->delete();

        return redirect()->route('admin.mitra-industri.index')->with('success', 'Mitra "'.$name.'" berhasil dihapus.');
    }
}
