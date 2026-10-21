<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Models\SiteSetting;
use App\Models\Spmb;
use Illuminate\Contracts\View\View;

class SpmbController extends Controller
{
    public function __invoke(): View
    {
        return view('public.spmb', [
            'site' => SiteSetting::current(),
            'spmb' => Spmb::current(),
            'faqs' => Faq::query()->active()->where('kategori', 'spmb')->ordered()->get(),
        ]);
    }
}
