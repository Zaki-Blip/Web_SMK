<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\FasilitasRequest;
use App\Models\Fasilitas;
use App\Support\ImageUploader;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use RuntimeException;

class FasilitasController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('q', ''));

        $facilities = Fasilitas::query()
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('name', 'like', '%'.$search.'%')
                        ->orWhere('description', 'like', '%'.$search.'%');
                });
            })
            ->ordered()
            ->paginate(10)
            ->withQueryString();

        return view('admin.fasilitas.index', [
            'facilities' => $facilities,
            'search' => $search,
        ]);
    }

    public function create(): View
    {
        return view('admin.fasilitas.create', [
            'facility' => new Fasilitas([
                'is_published' => true,
                'sort_order' => (int) Fasilitas::query()->max('sort_order') + 1,
            ]),
        ]);
    }

    public function store(FasilitasRequest $request, ImageUploader $uploader): RedirectResponse
    {
        $data = $request->safe()->except('image');

        try {
            if ($request->hasFile('image')) {
                $data['image_path'] = $uploader->store(
                    $request->file('image'),
                    'fasilitas',
                    ImageUploader::WIDTH_CARD,
                );
            }
        } catch (RuntimeException $exception) {
            return back()->withInput()->with('error', $exception->getMessage());
        }

        $fasilitas = Fasilitas::create($data);

        return redirect()
            ->route('admin.fasilitas.index')
            ->with('success', 'Fasilitas "'.$fasilitas->name.'" berhasil ditambahkan.');
    }

    public function edit(Fasilitas $fasilitas): View
    {
        return view('admin.fasilitas.edit', [
            'facility' => $fasilitas,
        ]);
    }

    public function update(FasilitasRequest $request, Fasilitas $fasilitas, ImageUploader $uploader): RedirectResponse
    {
        $data = $request->safe()->except('image');

        try {
            if ($request->hasFile('image')) {
                $newPath = $uploader->store($request->file('image'), 'fasilitas', ImageUploader::WIDTH_CARD);
                $uploader->delete($fasilitas->image_path);
                $data['image_path'] = $newPath;
            }
        } catch (RuntimeException $exception) {
            return back()->withInput()->with('error', $exception->getMessage());
        }

        $fasilitas->update($data);

        return redirect()
            ->route('admin.fasilitas.index')
            ->with('success', 'Fasilitas "'.$fasilitas->name.'" berhasil diperbarui.');
    }

    public function destroy(Fasilitas $fasilitas, ImageUploader $uploader): RedirectResponse
    {
        $uploader->delete($fasilitas->image_path);

        $name = $fasilitas->name;
        $fasilitas->delete();

        return redirect()
            ->route('admin.fasilitas.index')
            ->with('success', 'Fasilitas "'.$name.'" berhasil dihapus.');
    }
}
