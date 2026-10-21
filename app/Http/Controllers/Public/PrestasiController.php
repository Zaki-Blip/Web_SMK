<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Prestasi;
use App\Models\SiteSetting;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class PrestasiController extends Controller
{
    public function index(Request $request): View
    {
        $tingkat = (string) $request->query('tingkat', '');
        $tahun = $request->query('tahun');

        $items = Prestasi::query()
            ->active()
            ->when($tingkat !== '', fn ($q) => $q->where('tingkat', $tingkat))
            ->when($tahun, fn ($q) => $q->where('tahun', $tahun))
            ->ordered()
            ->paginate(12)
            ->withQueryString();

        return view('public.prestasi.index', [
            'site' => SiteSetting::current(),
            'items' => $items,
            'tingkat' => $tingkat,
            'tahun' => $tahun,
        ]);
    }
}
