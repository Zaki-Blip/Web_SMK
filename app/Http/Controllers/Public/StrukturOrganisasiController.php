<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use App\Models\StrukturOrganisasi;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;

class StrukturOrganisasiController extends Controller
{
    public function __invoke(): View
    {
        $items = StrukturOrganisasi::query()->active()->ordered()->get();
        $grouped = $items->groupBy(fn (StrukturOrganisasi $item) => $item->parent_id ?? 0);

        $build = function (int $parentId) use (&$build, $grouped): Collection {
            return $grouped->get($parentId, collect())->map(function (StrukturOrganisasi $item) use (&$build) {
                $item->setRelation('children', $build($item->id));

                return $item;
            });
        };

        return view('public.struktur.index', [
            'site' => SiteSetting::current(),
            'tree' => $build(0),
        ]);
    }
}
