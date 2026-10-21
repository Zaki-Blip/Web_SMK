<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\AlurPkl;
use App\Models\SiteSetting;
use Illuminate\Contracts\View\View;

class AlurPklController extends Controller
{
    public function __invoke(): View
    {
        return view('public.alur-pkl.index', [
            'site' => SiteSetting::current(),
            'items' => AlurPkl::query()->active()->ordered()->get(),
        ]);
    }
}
