<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\Jurusan;
use App\Models\SiteSetting;
use Illuminate\Contracts\View\View;

class JurusanController extends Controller
{
    public function index(): View
    {
        return view('public.jurusan.index', [
            'site' => SiteSetting::current(),
            'jurusans' => Jurusan::query()->active()->ordered()->paginate(9),
        ]);
    }

    public function show(string $slug): View
    {
        $jurusan = Jurusan::query()->active()->where('slug', $slug)->firstOrFail();
        $gurus = Guru::query()->active()->where('jurusan_id', $jurusan->id)->ordered()->get();

        return view('public.jurusan.show', [
            'site' => SiteSetting::current(),
            'jurusan' => $jurusan,
            'gurus' => $gurus,
        ]);
    }
}
