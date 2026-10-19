<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Facility;
use App\Models\SiteSetting;
use Illuminate\Contracts\View\View;

class FacilityController extends Controller
{
    /**
     * Daftar fasilitas yang sudah dipublikasikan.
     */
    public function __invoke(): View
    {
        return view('public.facility', [
            'site' => SiteSetting::current(),
            'facilities' => Facility::query()
                ->published()
                ->ordered()
                ->select(['id', 'name', 'slug', 'description', 'image_path', 'sort_order'])
                ->paginate(9),
        ]);
    }
}
