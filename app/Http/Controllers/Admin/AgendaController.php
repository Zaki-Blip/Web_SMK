<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AgendaRequest;
use App\Models\Agenda;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AgendaController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('q', ''));

        $items = Agenda::query()
            ->when($search !== '', fn ($query) => $query->where('judul', 'like', '%'.$search.'%'))
            ->orderByDesc('mulai')
            ->paginate(20)
            ->withQueryString();

        return view('admin.agenda.index', ['items' => $items, 'search' => $search]);
    }

    public function create(): View
    {
        return view('admin.agenda.create', [
            'item' => new Agenda(['is_published' => true]),
        ]);
    }

    public function store(AgendaRequest $request): RedirectResponse
    {
        $item = Agenda::create($request->validated());

        return redirect()
            ->route('admin.agenda.index')
            ->with('success', 'Agenda "'.$item->judul.'" berhasil ditambahkan.');
    }

    public function edit(Agenda $agenda): View
    {
        return view('admin.agenda.edit', ['item' => $agenda]);
    }

    public function update(AgendaRequest $request, Agenda $agenda): RedirectResponse
    {
        $agenda->update($request->validated());

        return redirect()
            ->route('admin.agenda.index')
            ->with('success', 'Agenda "'.$agenda->judul.'" berhasil diperbarui.');
    }

    public function destroy(Agenda $agenda): RedirectResponse
    {
        $judul = $agenda->judul;
        $agenda->delete();

        return redirect()
            ->route('admin.agenda.index')
            ->with('success', 'Agenda "'.$judul.'" berhasil dihapus.');
    }
}
