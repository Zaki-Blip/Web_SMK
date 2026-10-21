<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LowonganBkkRequest;
use App\Models\LowonganBkk;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LowonganBkkController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('q', ''));
        $status = (string) $request->query('status', '');

        $items = LowonganBkk::query()
            ->when($search !== '', fn ($q) => $q->where('judul', 'like', '%'.$search.'%')->orWhere('perusahaan', 'like', '%'.$search.'%'))
            ->when($status === 'published', fn ($q) => $q->where('is_published', true))
            ->when($status === 'draft', fn ($q) => $q->where('is_published', false))
            ->ordered()
            ->paginate(12)
            ->withQueryString();

        return view('admin.lowongan.index', ['items' => $items, 'search' => $search, 'status' => $status]);
    }

    public function create(): View
    {
        return view('admin.lowongan.create', ['item' => new LowonganBkk(['is_published' => true, 'tipe' => 'penuh_waktu'])]);
    }

    public function store(LowonganBkkRequest $request): RedirectResponse
    {
        $item = LowonganBkk::create($request->validated());

        return redirect()->route('admin.lowongan-bkk.index')->with('success', 'Lowongan "'.$item->judul.'" berhasil ditambahkan.');
    }

    public function edit(LowonganBkk $bkk): View
    {
        return view('admin.lowongan.edit', ['item' => $bkk]);
    }

    public function update(LowonganBkkRequest $request, LowonganBkk $bkk): RedirectResponse
    {
        $bkk->update($request->validated());

        return redirect()->route('admin.lowongan-bkk.index')->with('success', 'Lowongan "'.$bkk->judul.'" berhasil diperbarui.');
    }

    public function destroy(LowonganBkk $bkk): RedirectResponse
    {
        $title = $bkk->judul;
        $bkk->delete();

        return redirect()->route('admin.lowongan-bkk.index')->with('success', 'Lowongan "'.$title.'" berhasil dihapus.');
    }
}
