<?php

namespace App\Http\Controllers;

use App\Shipment;
use Freshbitsweb\Laratables\Laratables;

class DataTableController extends Controller
{
    /**
     * return data of the simple datatables.
     *
     * @return Json
     */
    public function getShipment()
    {
        return Laratables::recordsOf(Shipment::class, function ($query) {
            return $query->where('warehouse_id', auth()->user()->warehouse_id);
        });
    }

}