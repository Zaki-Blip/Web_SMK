<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\FacilityRequest;
use App\Models\Facility;
use App\Support\ImageUploader;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use RuntimeException;

class FacilityController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('q', ''));

        $facilities = Facility::query()
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('name', 'like', '%'.$search.'%')
                        ->orWhere('description', 'like', '%'.$search.'%');
                });
            })
            ->ordered()
            ->paginate(10)
            ->withQueryString();

        return view('admin.facilities.index', [
            'facilities' => $facilities,
            'search' => $search,
        ]);
    }

    public function create(): View
    {
        return view('admin.facilities.create', [
            'facility' => new Facility([
                'is_published' => true,
                'sort_order' => (int) Facility::query()->max('sort_order') + 1,
            ]),
        ]);
    }

    public function store(FacilityRequest $request, ImageUploader $uploader): RedirectResponse
    {
        $data = $request->safe()->except('image');

        try {
            if ($request->hasFile('image')) {
                $data['image_path'] = $uploader->store(
                    $request->file('image'),
                    'facilities',
                    ImageUploader::WIDTH_CARD,
                );
            }
        } catch (RuntimeException $exception) {
            return back()->withInput()->with('error', $exception->getMessage());
        }

        $facility = Facility::create($data);

        return redirect()
            ->route('admin.facilities.index')
            ->with('success', 'Fasilitas "'.$facility->name.'" berhasil ditambahkan.');
    }

    public function edit(Facility $facility): View
    {
        return view('admin.facilities.edit', [
            'facility' => $facility,
        ]);
    }

    public function update(FacilityRequest $request, Facility $facility, ImageUploader $uploader): RedirectResponse
    {
        $data = $request->safe()->except('image');

        try {
            if ($request->hasFile('image')) {
                $newPath = $uploader->store($request->file('image'), 'facilities', ImageUploader::WIDTH_CARD);
                $uploader->delete($facility->image_path);
                $data['image_path'] = $newPath;
            }
        } catch (RuntimeException $exception) {
            return back()->withInput()->with('error', $exception->getMessage());
        }

        $facility->update($data);

        return redirect()
            ->route('admin.facilities.index')
            ->with('success', 'Fasilitas "'.$facility->name.'" berhasil diperbarui.');
    }

    public function destroy(Facility $facility, ImageUploader $uploader): RedirectResponse
    {
        $uploader->delete($facility->image_path);

        $name = $facility->name;
        $facility->delete();

        return redirect()
            ->route('admin.facilities.index')
            ->with('success', 'Fasilitas "'.$name.'" berhasil dihapus.');
    }
}
