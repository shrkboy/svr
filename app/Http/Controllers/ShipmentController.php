<?php

namespace App\Http\Controllers;

use App\BikeModel;
use App\Branch;
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
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $warehouse_id = auth()->user()->warehouse_id;
        $shipments = Shipment::where([
            ['warehouse_id', '=', $warehouse_id],
            ['deleted', '<>', 1],
        ])->orderBy('depart_time', 'asc')->get();
        return view('shipment.shipments', compact('shipments', 'shipments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $branches = Branch::all();
        $bike_models = BikeModel::all();
        return view('shipment.new_shipment', compact('branches', 'bike_models'));
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

            $last_shipment = Shipment::latest('id')->first();
            $counter = $request->input('counter');

            for ($i = 1; $i <= $counter; $i++) {
                $bike_model_id = $request->input('bike-model-' . $i);
                $bike_model_amount = $request->input('amount-' . $i);
                for ($j = 1; $j <= $bike_model_amount; $j++) {
                    $vin = $request->input('vin-' . $i . '-' . $j);
                    $inventory = WarehouseInventory::where([
                        ['bike_model_id', '=', $bike_model_id],
                        ['vin', '=', $vin],
                        ['status', '=', 'IN']])->first();

                    if ($inventory != null) {
                        $shipment_detail = new ShipmentDetail;
                        $shipment_detail->shipment_id = $last_shipment->id;
                        $shipment_detail->inventory_id = $inventory->id;
                        $shipment_detail->save();

                        WarehouseInventory::where('id', $inventory->id)->update(['status' => 'SHIPPED']);
                    }
                }
            }

            return redirect(route('shipments.index'))->with('success', 'Report inserted successfully');
        } catch (\Exception $e) {
            return redirect(route('shipments.index'))->with('failed', 'Failed. something went wrong');
        }
    }

    /**
     * Finishes a shipment
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function finish(Request $request)
    {
        try {
            $id = $request->input('id');
            $number = $request->input('number');
            $received_time = $request->input('received-time');
            $received_by = $request->input('received-by');
            Shipment::where('id', $id)
                ->update([
                    'received_time' => $received_time,
                    'received_by' => $received_by,
                    'status' => 'DONE',
                ]);

            return redirect(route('shipments.index'))->with('success', 'Shipment ' . $number . ' updated successfully');
        } catch (Exception $e) {
            return redirect(route('shipments.index'))->with('failed', 'Failed. Something went wrong');
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
        $shipment = Shipment::with(['warehouse'])->where('id', '=', $id)->first();
        $details = ShipmentDetail::with(['inventory'])->where('shipment_id', '=', $id)->get();
        return view('shipment.shipment_detail', compact('shipment', 'details'));
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
     * @param Request $request
     * @param  int $id
     * @return array
     */
    public function destroy(Request $request, $id)
    {
        $match_key = $request->input('key');
        $key = Warehouse::where('id', auth()->user()->warehouse_id)->get()[0]->auth_key;
        if (Hash::check($match_key, $key)) {
            try {
                $log = new ShipmentLog;
                $log->shipment_id = $id;
                $log->action = 'DELETE';
                $log->warehouse_id = auth()->user()->warehouse_id;
                $log->by = auth()->user()->id;
                $log->save();

                Shipment::where('id', $id)->update([
                    'deleted' => 1
                ]);

                $details = ShipmentDetail::where('shipment_id', $id)->get();
                foreach ($details as $detail) {
                    WarehouseInventory::where('id', $detail->inventory_id)->update([
                        'status' => 'IN'
                    ]);
                }

                return redirect(route('shipments.index'))->with('success', 'Delete success');
            } catch (\Exception $e) {
                return redirect(route('shipments.index'))->with('failed', 'Delete failed. Something went wrong: ' . $e);
            }
        } else {
            return redirect(route('shipments.index'))->with('failed', 'Delete failed. Auth key might be incorrect');
        }
    }

    /**
     * View shipment detail as report to print
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function showAsReport($id)
    {
        $shipment = Shipment::with(['warehouse'])->where('id', '=', $id)->first();
        $details = ShipmentDetail::with(['inventory'])->where('shipment_id', '=', $id)->get();
        return view('shipment.shipment_detail_report', compact('shipment', 'details'));
    }
}
