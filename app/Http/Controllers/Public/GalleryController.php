<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\GalleryItem;
use App\Models\SiteSetting;
use Illuminate\Contracts\View\View;

class GalleryController extends Controller
{
    /**
     * Galeri foto dengan pagination dan lightbox Bootstrap.
     */
    public function __invoke(): View
    {
        return view('public.gallery', [
            'site' => SiteSetting::current(),
            'items' => GalleryItem::query()
                ->published()
                ->ordered()
                ->select(['id', 'title', 'caption', 'image_path', 'category', 'sort_order'])
                ->paginate(12),
        ]);
    }
}
