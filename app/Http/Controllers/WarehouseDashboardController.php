<?php

namespace App\Http\Controllers;

use App\ReturnedItem;
use App\Shipment;
use Carbon\Carbon;
use Illuminate\Http\Request;

class WarehouseDashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $warehouse_id = auth()->user()->warehouse_id;

        $shipmentAmount = Shipment::query()
            ->select(\DB::raw('MONTH(depart_time) as month'), \DB::raw('count(*) as amount'))
            ->where([
                ['warehouse_id', '=', $warehouse_id],
                ['deleted', '=', 0],
                ["depart_time", ">", Carbon::now()->subMonths(6)],
            ])
            ->orderBy('month', 'asc')
            ->groupBy(\DB::raw('MONTH(depart_time)'))
            ->get();

        $bikeShipped = \DB::table(\DB::raw('shipments s, shipment_details sd'))
            ->selectRaw('count(sd.inventory_id) as \'amount\', month(depart_time) as \'month\'')
            ->whereRaw('s.warehouse_id = ?', $warehouse_id)
            ->whereRaw('s.id = sd.shipment_id')
            ->whereRaw('s.deleted = ?', 0)
            ->groupBy(\DB::raw('month(depart_time)'))->orderBy(\DB::raw('month'))
            ->get();

        $returnAmount = ReturnedItem::query()
            ->select(\DB::raw('MONTH(time) as month'), \DB::raw('count(*) as amount'))
            ->where([
                ['warehouse_id', '=', $warehouse_id],
                ["time", ">", Carbon::now()->subMonths(6)],
            ])
            ->orderBy('month', 'asc')
            ->groupBy(\DB::raw('MONTH(time)'))
            ->get();

        $bikeModelShipped = \DB::table(\DB::raw('shipments s, shipment_details sd, bike_models bm, warehouse_inventories wi'))
            ->selectRaw('bm.name, count(bm.id) as \'amount\'')
            ->whereRaw('s.warehouse_id = ?', $warehouse_id)
            ->whereRaw('s.id = sd.shipment_id')
            ->whereRaw('s.deleted = ?', 0)
            ->whereRaw('sd.inventory_id = wi.id')
            ->whereRaw('wi.bike_model_id = bm.id')
            ->groupBy(\DB::raw('bm.name'))
            ->get();

        return \View::make('shipment.manager_dashboard', compact('shipmentAmount', 'bikeShipped', 'returnAmount', 'bikeModelShipped'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
