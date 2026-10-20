<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Facility;
use App\Models\GalleryItem;
use App\Models\News;
use App\Models\Program;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    /**
     * Ringkasan jumlah konten dan akses cepat menambah konten.
     * Semua angka diambil dari database.
     */
    public function __invoke(): View
    {
        return view('admin.dashboard', [
            'programCount' => Program::query()->count(),
            'publishedProgramCount' => Program::query()->where('is_published', true)->count(),
            'facilityCount' => Facility::query()->count(),
            'publishedFacilityCount' => Facility::query()->where('is_published', true)->count(),
            'galleryCount' => GalleryItem::query()->count(),
            'publishedGalleryCount' => GalleryItem::query()->where('is_published', true)->count(),
            'newsPublishedCount' => News::query()->where('status', News::STATUS_PUBLISHED)->count(),
            'newsDraftCount' => News::query()->where('status', News::STATUS_DRAFT)->count(),
            'recentNews' => News::query()->latestFirst()->take(5)->get(),
        ]);
    }
}
