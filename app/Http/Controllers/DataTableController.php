<?php

namespace App\Http\Controllers;

use App\ReturnedItem;
use App\Shipment;
use Yajra\DataTables\DataTables;

class DataTableController extends Controller
{
    /**
     * Return shipment data for Datatable
     *
     * @return array|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     * @throws \Exception
     */
    public function getShipment()
    {
        return DataTables::of(Shipment::query()
            ->with(['dealer'])
            ->where([
                ['warehouse_id', '=', auth()->user()->warehouse_id],
                ['deleted', '<>', 1],
            ])
            ->orderBy('depart_time', 'desc')
            ->get())->make(true);
    }

    /**
     * Return returned item data for Datatable
     *
     * @return array|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     * @throws \Exception
     */
    public function getReturnedItem()
    {
        return DataTables::of(ReturnedItem::query()
            ->with(['warehouse', 'dealer', 'inventory', 'inventory.bike_model'])
            ->where([
                ['warehouse_id', '=', auth()->user()->warehouse_id],
            ])
            ->orderBy('time', 'desc')
            ->get())->make(true);
    }

}