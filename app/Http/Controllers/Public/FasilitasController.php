<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Fasilitas;
use App\Models\SiteSetting;
use Illuminate\Contracts\View\View;

class FasilitasController extends Controller
{
    /**
     * Daftar fasilitas yang sudah dipublikasikan.
     */
    public function __invoke(): View
    {
        return view('public.fasilitas', [
            'site' => SiteSetting::current(),
            'facilities' => Fasilitas::query()
                ->published()
                ->ordered()
                ->select(['id', 'name', 'slug', 'description', 'image_path', 'sort_order'])
                ->paginate(9),
        ]);
    }
}
