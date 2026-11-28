<?php

namespace App\Http\Controllers;

use App\Services\DemoEquipmentCatalog;
use Illuminate\Contracts\View\View;

final class EquipmentCatalogController extends Controller
{
    public function __invoke(DemoEquipmentCatalog $catalog): View
    {
        return view('equipment.index', ['equipment' => $catalog->items()]);
    }
}
