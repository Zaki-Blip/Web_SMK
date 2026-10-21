<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Galeri;
use App\Models\SiteSetting;
use Illuminate\Contracts\View\View;

class GaleriController extends Controller
{
    /**
     * Galeri foto dengan pagination dan lightbox Bootstrap.
     */
    public function __invoke(): View
    {
        return view('public.galeri', [
            'site' => SiteSetting::current(),
            'items' => Galeri::query()
                ->published()
                ->ordered()
                ->select(['id', 'title', 'caption', 'image_path', 'category', 'sort_order'])
                ->paginate(12),
        ]);
    }
}
