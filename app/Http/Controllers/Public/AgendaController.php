<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Agenda;
use App\Models\SiteSetting;
use Illuminate\Contracts\View\View;

class AgendaController extends Controller
{
    public function index(): View
    {
        return view('public.agenda.index', [
            'site' => SiteSetting::current(),
            'items' => Agenda::query()->published()->ordered()->paginate(9),
        ]);
    }

    public function show(Agenda $agenda): View
    {
        abort_unless($agenda->is_published, 404);

        return view('public.agenda.show', [
            'site' => SiteSetting::current(),
            'item' => $agenda,
        ]);
    }
}
