<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\AdmissionSetting;
use App\Models\SiteSetting;
use Illuminate\Contracts\View\View;

class AdmissionController extends Controller
{
    /**
     * Informasi PPDB: periode, persyaratan, alur, biaya, dan kontak resmi.
     */
    public function __invoke(): View
    {
        return view('public.admission', [
            'admission' => AdmissionSetting::current(),
            'site' => SiteSetting::current(),
        ]);
    }
}
