<?php

namespace App\Http\Controllers;

use App\BikeModel;
use App\WarehouseInventory;
use Illuminate\Http\Request;

class BikeModelController extends Controller
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
     * @param  string $code
     * @return \Illuminate\Http\Response
     */
    public function show($code)
    {
        return BikeModel::distinct()->select('code')->where('code', 'like', $code . '%')->groupBy('code')->get();
    }

    /**
     * Display full data of resource for shipment entry ajax
     *
     * @param string param
     * @return \Illuminate\Http\Response
     */
    public function get($param)
    {
        return BikeModel::where('name', 'like', $param . '%')
            ->orWhere('code', 'like', $param . '%')
            ->orWhere('color', 'like', $param . '%')
            ->get();
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
