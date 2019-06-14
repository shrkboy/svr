<?php

namespace App\Http\Controllers;

use App\Shipment;
use App\ShipmentDetail;
use App\ShipmentLog;
use App\Warehouse;
use App\WarehouseInventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ShipmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Views the main page of shipments
     * Shows all shipment data
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
//        $warehouse_id = auth()->user()->warehouse_id;
//        $shipments = Shipment::query()->where([
//            ['warehouse_id', '=', $warehouse_id],
//            ['deleted', '<>', 1],
//        ])->orderBy('depart_time', 'desc')->get();

        return \View::make('shipment.shipments');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return \View::make('shipment.new_shipment');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        /*
         * Method for saving shipments to db
         * */
        try {
            $shipment = new Shipment;
            $shipment->depart_time = $request->input('departure');
            $shipment->warehouse_id = $request->session()->get('warehouse_id', null);
            $shipment->dealer_id = $request->input('destination');
            $shipment->status = 'ONGOING';
            $shipment->deleted = 0;
            $shipment->save();

            $last_shipment = Shipment::query()->latest('id')->first();
            $counter = $request->input('counter');

            for ($i = 1; $i <= $counter; $i++) {
                $bike_model_id = $request->input('bike-model-' . $i);
                $bike_model_amount = $request->input('amount-' . $i);
                for ($j = 1; $j <= $bike_model_amount; $j++) {
                    $vin = $request->input('vin-' . $i . '-' . $j);
                    $inventory = WarehouseInventory::query()->where([
                        ['bike_model_id', '=', $bike_model_id],
                        ['vin', '=', $vin],
                        ['status', '=', 'IN']])->first();

                    if ($inventory != null) {
                        $shipment_detail = new ShipmentDetail;
                        $shipment_detail->shipment_id = $last_shipment->id;
                        $shipment_detail->inventory_id = $inventory->id;
                        $shipment_detail->save();

                        WarehouseInventory::query()->where('id', $inventory->id)->update(['status' => 'SHIPPED']);
                    }
                }
            }

            return \Redirect::route('shipments.index')->with('success', 'Report inserted successfully');
        } catch (\Exception $e) {
            return \Redirect::route('shipments.index')->with('failed', 'Failed. something went wrong');
        }
    }

    /**
     * Finishes a shipment
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function finish(Request $request)
    {
        try {
            $id = $request->input('id');
            $received_time = $request->input('received-time');
            $received_by = $request->input('received-by');
            Shipment::query()->where('id', $id)
                ->update([
                    'received_time' => $received_time,
                    'received_by' => $received_by,
                    'status' => 'DONE',
                ]);

            return \Redirect::route('shipments.show', $id)->with('success', 'Shipment status updated successfully');
        } catch (\Exception $e) {
            return \Redirect::route('shipments.show', $id)->with('failed', 'Shipment status update failed. Something went wrong');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $shipment = Shipment::with(['warehouse'])->where('id', '=', $id)->first();
        $details = ShipmentDetail::with(['inventory'])->where('shipment_id', '=', $id)->get();
        return \View::make('shipment.shipment_detail', compact('shipment', 'details'));
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
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        try {
            $flag = $request->input('flag');
            $info = $request->input('info');
            $departure_time = $request->input('departure');

            if ($flag == 'cancel') {
                Shipment::query()->where('id', $id)->update([
                    'status' => 'CANCELLED',
                    'info' => $info,
                ]);

                // revert inventory statuses
                $details = ShipmentDetail::query()->where('shipment_id', $id)->get();
                foreach ($details as $detail) {
                    WarehouseInventory::query()->where('id', $detail->inventory_id)->update([
                        'status' => 'IN'
                    ]);
                }
            } else if ($flag == 'delay') {
                Shipment::query()->where('id', $id)->update([
                    'status' => 'DELAYED',
                    'info' => $info,
                ]);
            } else if ($flag == 'ongoing') {
                Shipment::query()->where('id', $id)->update([
                    'status' => 'ONGOING',
                    'depart_time' => $departure_time,
                ]);
            }

            return \Redirect::route('shipments.show', $id)->with('success', 'Shipment status updated successfully');
        } catch (\Exception $e) {
            return \Redirect::route('shipments.show', $id)->with('failed', 'Shipment status update failed. Something went wrong');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param  int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request, $id)
    {
        $match_key = $request->input('key');
        $key = Warehouse::query()->where('id', auth()->user()->warehouse_id)->get()[0]->auth_key;
        if (Hash::check($match_key, $key)) {
            try {
                $log = new ShipmentLog;
                $log->shipment_id = $id;
                $log->action = 'DELETE';
                $log->by = auth()->user()->id;
                $log->save();

                Shipment::query()->where('id', $id)->update([
                    'deleted' => 1
                ]);

                $details = ShipmentDetail::query()->where('shipment_id', $id)->get();
                foreach ($details as $detail) {
                    WarehouseInventory::query()->where('id', $detail->inventory_id)->update([
                        'status' => 'IN'
                    ]);
                }

                return \Redirect::route('shipments.index')->with('success', 'Delete success');
            } catch (\Exception $e) {
                return \Redirect::route('shipments.index')->with('failed', 'Delete failed. Something went wrong: ' . $e);
            }
        } else {
            return \Redirect::route('shipments.index')->with('failed', 'Delete failed. Auth key is incorrect');
        }
    }

    /**
     * View shipment detail as report to print
     *
     * @param int $id
     * @return \Illuminate\Contracts\View\View
     */
    public function showAsReport($id)
    {
        $shipment = Shipment::with(['warehouse'])->where('id', '=', $id)->first();
        $details = ShipmentDetail::with(['inventory'])->where('shipment_id', '=', $id)->get();
        return \View::make('shipment.shipment_detail_report', compact('shipment', 'details'));
    }
}
