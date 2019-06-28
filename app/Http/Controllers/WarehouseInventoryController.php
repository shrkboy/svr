<?php

namespace App\Http\Controllers;

use App\WarehouseInventory;
use Illuminate\Http\Request;

class WarehouseInventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    public function validateInventoryData($bike_model_id, $vin) {
        return WarehouseInventory::where('bike_model_id','=',$bike_model_id)->where('vin','=',$vin)->get();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function yolo()
    {
        for ($i = 129; $i <= 187; $i++) {
            for ($j = 1; $j <= 10; $j++) {
                $inventory = new WarehouseInventory;
                $inventory->bike_model_id = $i;
                $inventory->vin = $j;
                $inventory->status = 'IN';
                $inventory->warehouse_id = 1;
                $inventory->save();
            }
        }
    }
}
