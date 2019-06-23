<?php

namespace App\Http\Controllers;

use App\Warehouse;
use Illuminate\Http\Request;
use function PHPSTORM_META\type;

class WarehouseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $warehouses = Warehouse::with(['manager_detail'])->get();
        return view('admin.warehouses', compact('warehouses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.new_warehouse');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $name = $request->input('name');
            $manager = $request->input('manager');
            $phone = $request->input('phone');

            $warehouse = new Warehouse;
            $warehouse->name = $name;
            $warehouse->manager = $manager;
            $warehouse->phone = $phone;
            $warehouse->save();

            return redirect(route('warehouses.index'))->with('success', 'Data inserted successfully');
        } catch (\Exception $e) {
            return redirect(route('warehouses.index'))->with('failed', 'Data insert failed. Something went wrong');
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
        $warehouse = Warehouse::query()->with(['manager_detail'])->where('id', $id)->first();
        return view('admin.edit_warehouse', compact('warehouse'));
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
        try {
            $name = $request->input('name');
            $manager = $request->input('manager');
            $phone = $request->input('phone');

            Warehouse::where('id', $id)->update([
                'name' => $name,
                'manager' => $manager,
                'phone' => $phone,
            ]);

            return redirect(route('warehouses.index'))->with('success', 'Data updated successfully');
        } catch (\Exception $e) {
            return redirect(route('warehouses.index'))->with('failed', 'Data update failed. Something went wrong');
        }
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
