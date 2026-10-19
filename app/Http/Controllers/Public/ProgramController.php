<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Program;
use App\Models\SiteSetting;
use Illuminate\Contracts\View\View;

class ProgramController extends Controller
{
    /**
     * Daftar program yang sudah dipublikasikan, urut sort_order.
     */
    public function __invoke(): View
    {
        return view('public.program', [
            'site' => SiteSetting::current(),
            // Kolom ringkas dipilih agar tidak memuat deskripsi panjang di daftar.
            'programs' => Program::query()
                ->published()
                ->ordered()
                ->select(['id', 'name', 'slug', 'short_description', 'image_path', 'sort_order'])
                ->paginate(9),
        ]);
    }
}
