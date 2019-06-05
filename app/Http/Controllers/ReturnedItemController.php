<?php

namespace App\Http\Controllers;

use App\ReturnedItem;
use App\WarehouseInventory;
use Illuminate\Http\Request;

class ReturnedItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $warehouse = session('warehouse_id', null);
        $returned_items = ReturnedItem::with(['warehouse', 'dealer', 'inventory'])->where('warehouse_id', $warehouse)->get();
        return view('shipment.returned_items', compact('returned_items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('shipment.new_returned_item');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /*
         * Method for saving returned item data to db
         * */
        try {
            $bike_model_id = $request->input('bike-model');
            $vin = $request->input('vin');
            $inventory = WarehouseInventory::where([
                ['bike_model_id', '=', $bike_model_id],
                ['vin', '=', $vin],
                ['status', '!=', 'IN']])->first();

            $returned_item = new ReturnedItem;
            $returned_item->warehouse_id = $request->session()->get('warehouse_id', null);
            $returned_item->dealer_id = $request->input('dealer');
            $returned_item->info = $request->input('info');
            $returned_item->inventory_id = $inventory->id;
            $returned_item->time = $request->input('time');

            $returned_item->save();
            WarehouseInventory::where('id', $inventory->id)
                ->update([
                    'status' => 'RETURNED',
                    'warehouse_id' => $request->session()->get('warehouse_id', null)
                ]);

            return redirect(route('returned_items.index'))->with('success', 'Data inserted successfully');
        } catch (\Exception $e) {
            return redirect(route('returned_items.index'))->with('failed', 'Whoops, something went wrong!');
        }
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
