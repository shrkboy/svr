<?php

namespace App\Http\Controllers;

use App\BikeModel;
use Illuminate\Http\Request;
use App\Color;
use App\Spec;
use App\RetailReport;

class RetailReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function retail_report()
    {
        $user = auth()->user()->id;
        $retailreports = RetailReport::
            join('TS_DEALERLIST','retail_reports.dealer_id', '=', 'TS_DEALERLIST.id')
            ->join('colors', 'retail_reports.color_id', '=', 'colors.id')
            ->join('specs', 'retail_reports.spec_id', '=', 'specs.id')
            ->select('retail_reports.input_date','retail_reports.bikemodel_code','retail_reports.last_inventory', 'retail_reports.restock_amount', 'retail_reports.retail_amount', 'retail_reports.updated_inventory', 'retail_reports.remarks', 'colors.name as cname', 'specs.name as sname', 'TS_DEALERLIST.dlname')
            ->where('user_id', '=', $user)
            ->get();
        return view('retail_reports', compact('retailreports'));
    }

    public function add_retail_report()
    {
        $colors = Color::all();
        $specs = Spec::all();
        $date = date("Y-m-d");
        $models = BikeModel::distinct()->select('code')->groupBy('code')->get();
        return view('add_retail_report', compact('branches', 'colors', 'specs', 'date', 'models'));
    }
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
        try {

            $retail_report = new RetailReport;
            $retail_report->user_id = auth()->user()->id;
            $retail_report->dealer_id = $request->input('branch');
            $retail_report->input_date = $request->input('date');
            $retail_report->bikemodel_code = $request->input('model');
            $retail_report->color_id = $request->input('color');
            $retail_report->spec_id = $request->input('spec');
            $retail_report->restock_amount = 0 + $request->input('in');
            $retail_report->retail_amount = 0 + $request->input('retail');
            $retail_report->last_inventory = 0;
            $retail_report->updated_inventory = 0 + $retail_report->restock_amount - $retail_report->retail_amount;
            $retail_report->remarks = $request->input('remarks');

            $retail_report->save();

            return redirect('/retailreport')->with('success', 'Report inserted successfully');
        }
        catch (Exception $e){
            return redirect('/retailreport')->with('failed', 'Woops, something is wrong!');
        }
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
}
