<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\LowonganBkk;
use App\Models\SiteSetting;
use Illuminate\Contracts\View\View;

class BkkController extends Controller
{
    public function index(): View
    {
        $items = LowonganBkk::query()->published()->open()->ordered()->paginate(9);

        return view('public.bkk.index', [
            'site' => SiteSetting::current(),
            'items' => $items,
        ]);
    }

    public function show(int $id): View
    {
        $item = LowonganBkk::query()->published()->open()->findOrFail($id);

        return view('public.bkk.show', [
            'site' => SiteSetting::current(),
            'item' => $item,
        ]);
    }
}
