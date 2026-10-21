<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\FaqRequest;
use App\Models\Faq;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('q', ''));
        $kategori = (string) $request->query('kategori', '');

        $items = Faq::query()
            ->when($search !== '', fn ($q) => $q->where('pertanyaan', 'like', '%'.$search.'%'))
            ->when($kategori !== '', fn ($q) => $q->where('kategori', $kategori))
            ->ordered()
            ->paginate(12)
            ->withQueryString();

        return view('admin.faq.index', ['items' => $items, 'search' => $search, 'kategori' => $kategori]);
    }

    public function create(): View
    {
        return view('admin.faq.create', ['item' => new Faq(['is_active' => true, 'kategori' => 'umum', 'urutan' => (int) Faq::query()->max('urutan') + 1])]);
    }

    public function store(FaqRequest $request): RedirectResponse
    {
        $item = Faq::create($request->validated());

        return redirect()->route('admin.faq.index')->with('success', 'FAQ berhasil ditambahkan.');
    }

    public function edit(Faq $faq): View
    {
        return view('admin.faq.edit', ['item' => $faq]);
    }

    public function update(FaqRequest $request, Faq $faq): RedirectResponse
    {
        $faq->update($request->validated());

        return redirect()->route('admin.faq.index')->with('success', 'FAQ berhasil diperbarui.');
    }

    public function destroy(Faq $faq): RedirectResponse
    {
        $faq->delete();

        return redirect()->route('admin.faq.index')->with('success', 'FAQ berhasil dihapus.');
    }
}
