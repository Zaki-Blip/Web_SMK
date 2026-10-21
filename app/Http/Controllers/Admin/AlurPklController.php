<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AlurPklRequest;
use App\Models\AlurPkl;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AlurPklController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('q', ''));

        $items = AlurPkl::query()
            ->when($search !== '', fn ($query) => $query->where('judul', 'like', '%'.$search.'%'))
            ->ordered()
            ->paginate(20)
            ->withQueryString();

        return view('admin.alur-pkl.index', ['items' => $items, 'search' => $search]);
    }

    public function create(): View
    {
        return view('admin.alur-pkl.create', [
            'item' => new AlurPkl(['is_active' => true, 'urutan' => (int) AlurPkl::query()->max('urutan') + 1]),
        ]);
    }

    public function store(AlurPklRequest $request): RedirectResponse
    {
        $item = AlurPkl::create($request->validated());

        return redirect()
            ->route('admin.alur-pkl.index')
            ->with('success', 'Langkah alur PKL "'.$item->judul.'" berhasil ditambahkan.');
    }

    public function edit(AlurPkl $alur): View
    {
        return view('admin.alur-pkl.edit', ['item' => $alur]);
    }

    public function update(AlurPklRequest $request, AlurPkl $alur): RedirectResponse
    {
        $alur->update($request->validated());

        return redirect()
            ->route('admin.alur-pkl.index')
            ->with('success', 'Langkah alur PKL "'.$alur->judul.'" berhasil diperbarui.');
    }

    public function destroy(AlurPkl $alur): RedirectResponse
    {
        $judul = $alur->judul;
        $alur->delete();

        return redirect()
            ->route('admin.alur-pkl.index')
            ->with('success', 'Langkah alur PKL "'.$judul.'" berhasil dihapus.');
    }
}
