<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProgramRequest;
use App\Models\Program;
use App\Support\ImageUploader;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use RuntimeException;

class ProgramController extends Controller
{
    /**
     * Daftar program dengan pencarian dan pagination.
     */
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('q', ''));

        $programs = Program::query()
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('name', 'like', '%'.$search.'%')
                        ->orWhere('short_description', 'like', '%'.$search.'%');
                });
            })
            ->ordered()
            ->paginate(10)
            ->withQueryString();

        return view('admin.programs.index', [
            'programs' => $programs,
            'search' => $search,
        ]);
    }

    public function create(): View
    {
        return view('admin.programs.create', [
            'program' => new Program([
                'is_published' => true,
                'sort_order' => (int) Program::query()->max('sort_order') + 1,
            ]),
        ]);
    }

    public function store(ProgramRequest $request, ImageUploader $uploader): RedirectResponse
    {
        $data = $request->safe()->except('image');

        try {
            if ($request->hasFile('image')) {
                $data['image_path'] = $uploader->store(
                    $request->file('image'),
                    'programs',
                    ImageUploader::WIDTH_CARD,
                );
            }
        } catch (RuntimeException $exception) {
            return back()->withInput()->with('error', $exception->getMessage());
        }

        $program = Program::create($data);

        return redirect()
            ->route('admin.programs.index')
            ->with('success', 'Program "'.$program->name.'" berhasil ditambahkan.');
    }

    public function edit(Program $program): View
    {
        return view('admin.programs.edit', [
            'program' => $program,
        ]);
    }

    public function update(ProgramRequest $request, Program $program, ImageUploader $uploader): RedirectResponse
    {
        $data = $request->safe()->except('image');

        try {
            if ($request->hasFile('image')) {
                $newPath = $uploader->store($request->file('image'), 'programs', ImageUploader::WIDTH_CARD);
                $uploader->delete($program->image_path);
                $data['image_path'] = $newPath;
            }
        } catch (RuntimeException $exception) {
            return back()->withInput()->with('error', $exception->getMessage());
        }

        $program->update($data);

        return redirect()
            ->route('admin.programs.index')
            ->with('success', 'Program "'.$program->name.'" berhasil diperbarui.');
    }

    public function destroy(Program $program, ImageUploader $uploader): RedirectResponse
    {
        // File gambar ikut dihapus agar tidak menumpuk di storage.
        $uploader->delete($program->image_path);

        $name = $program->name;
        $program->delete();

        return redirect()
            ->route('admin.programs.index')
            ->with('success', 'Program "'.$name.'" berhasil dihapus.');
    }
}
