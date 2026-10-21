<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\Jurusan;
use App\Models\SiteSetting;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class GuruController extends Controller
{
    public function index(Request $request): View
    {
        $tipe = (string) $request->query('tipe', '');
        $jurusanId = $request->query('jurusan_id');

        $gurus = Guru::query()
            ->active()
            ->when($tipe !== '', fn ($q) => $q->where('tipe', $tipe))
            ->when($jurusanId, fn ($q) => $q->where('jurusan_id', $jurusanId))
            ->ordered()
            ->paginate(12)
            ->withQueryString();

        return view('public.guru.index', [
            'site' => SiteSetting::current(),
            'gurus' => $gurus,
            'tipe' => $tipe,
            'jurusanId' => $jurusanId,
            'jurusans' => Jurusan::query()->active()->ordered()->get(),
        ]);
    }
}
