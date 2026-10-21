<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use App\Models\Unduhan;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\StreamedResponse;

class UnduhanController extends Controller
{
    public function index(): View
    {
        return view('public.unduhan.index', [
            'site' => SiteSetting::current(),
            'items' => Unduhan::query()->published()->ordered()->paginate(12),
        ]);
    }

    public function download(Unduhan $unduhan): StreamedResponse
    {
        abort_unless($unduhan->is_published, 404);

        $disk = Storage::disk(config('filesystems.uploads_disk', 'public'));

        abort_unless($disk->exists($unduhan->berkas), 404);

        $extension = pathinfo($unduhan->berkas, PATHINFO_EXTENSION);
        $name = Str::slug($unduhan->judul).($extension ? '.'.$extension : '');

        return $disk->download($unduhan->berkas, $name);
    }
}
