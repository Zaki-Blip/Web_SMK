<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Ekstrakurikuler;
use App\Models\SiteSetting;
use Illuminate\Contracts\View\View;

class EkstrakurikulerController extends Controller
{
    public function index(): View
    {
        return view('public.ekstrakurikuler.index', [
            'site' => SiteSetting::current(),
            'items' => Ekstrakurikuler::query()->active()->ordered()->paginate(9),
        ]);
    }

    public function show(string $slug): View
    {
        $item = Ekstrakurikuler::query()->active()->where('slug', $slug)->firstOrFail();

        return view('public.ekstrakurikuler.show', [
            'site' => SiteSetting::current(),
            'item' => $item,
        ]);
    }
}
