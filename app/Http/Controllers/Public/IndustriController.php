<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\MitraIndustri;
use App\Models\SiteSetting;
use Illuminate\Contracts\View\View;

class IndustriController extends Controller
{
    public function index(): View
    {
        return view('public.industri.index', [
            'site' => SiteSetting::current(),
            'mitras' => MitraIndustri::query()->active()->ordered()->get(),
        ]);
    }
}
