<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StrukturOrganisasiRequest;
use App\Models\StrukturOrganisasi;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class StrukturOrganisasiController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('q', ''));

        $items = StrukturOrganisasi::query()
            ->with('parent')
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('nama', 'like', '%'.$search.'%')
                        ->orWhere('jabatan', 'like', '%'.$search.'%');
                });
            })
            ->ordered()
            ->paginate(20)
            ->withQueryString();

        return view('admin.struktur-organisasi.index', ['items' => $items, 'search' => $search]);
    }

    public function create(): View
    {
        return view('admin.struktur-organisasi.create', [
            'item' => new StrukturOrganisasi(['is_active' => true, 'urutan' => (int) StrukturOrganisasi::query()->max('urutan') + 1]),
            'parents' => StrukturOrganisasi::query()->ordered()->get(),
        ]);
    }

    public function store(StrukturOrganisasiRequest $request): RedirectResponse
    {
        $item = StrukturOrganisasi::create($request->validated());

        return redirect()
            ->route('admin.struktur-organisasi.index')
            ->with('success', 'Struktur organisasi "'.$item->nama.'" berhasil ditambahkan.');
    }

    public function edit(StrukturOrganisasi $struktur): View
    {
        return view('admin.struktur-organisasi.edit', [
            'item' => $struktur,
            'parents' => StrukturOrganisasi::query()->where('id', '!=', $struktur->id)->ordered()->get(),
        ]);
    }

    public function update(StrukturOrganisasiRequest $request, StrukturOrganisasi $struktur): RedirectResponse
    {
        $struktur->update($request->validated());

        return redirect()
            ->route('admin.struktur-organisasi.index')
            ->with('success', 'Struktur organisasi "'.$struktur->nama.'" berhasil diperbarui.');
    }

    public function destroy(StrukturOrganisasi $struktur): RedirectResponse
    {
        $name = $struktur->nama;
        $struktur->delete();

        return redirect()
            ->route('admin.struktur-organisasi.index')
            ->with('success', 'Struktur organisasi "'.$name.'" berhasil dihapus.');
    }
}
