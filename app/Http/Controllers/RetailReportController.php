<?php

namespace App\Http\Controllers;

use App\BikeModel;
use App\User;
use Illuminate\Http\Request;
use App\Color;
use App\Spec;
use App\RetailReport;
use App\Branch;
use App\UserRole;

class RetailReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function retail_report()
    {
        $user = auth()->user()->dealer_id;

        $role = UserRole::where('id', '=', auth()->user()->role_id)->first();
        $dealer = Branch::where('id', '=', $user)->first();
        $retailreports = RetailReport::
            join('TS_DEALERLIST','retail_reports.dealer_id', '=', 'TS_DEALERLIST.id')
            ->join('colors', 'retail_reports.color_id', '=', 'colors.id')
            ->join('specs', 'retail_reports.spec_id', '=', 'specs.id')
            ->select('retail_reports.id', 'retail_reports.input_date','retail_reports.bikemodel_code','retail_reports.last_inventory', 'retail_reports.restock_amount', 'retail_reports.retail_amount', 'retail_reports.updated_inventory', 'retail_reports.remarks', 'colors.name as cname', 'specs.name as sname', 'TS_DEALERLIST.dlname')
            ->where('dealer_id', '=', $user)
            ->orderBy('input_date', 'DESC')
            ->get();

        $num = 1;
        return view('retail_reports', compact('retailreports', 'dealer','num', 'role'));
    }

    public function add_retail_report()
    {
        $dealer = Branch::where('id', auth()->user()->dealer_id)->first();
        $colors = Color::all();
        $specs = Spec::all();
        $date = date("m/d/Y");
        return view('add_retail_report', compact('colors', 'specs', 'date', 'dealer'));
    }

    public function edit_retail_report($id)
    {
        $report = RetailReport::
            join('TS_DEALERLIST','retail_reports.dealer_id', '=', 'TS_DEALERLIST.id')
            ->join('colors', 'retail_reports.color_id', '=', 'colors.id')
            ->join('specs', 'retail_reports.spec_id', '=', 'specs.id')
            ->select('retail_reports.id', 'retail_reports.input_date','retail_reports.bikemodel_code','retail_reports.last_inventory', 'retail_reports.restock_amount', 'retail_reports.retail_amount', 'retail_reports.updated_inventory', 'retail_reports.remarks', 'colors.name as cname', 'specs.name as sname', 'TS_DEALERLIST.dlname')
            ->where('retail_reports.id', '=', $id)
            ->first();
        return view('edit_retail_report', compact('report'));
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



            $dealer = Branch::where('dlname',$request->input('branch'))->first();
            $retail_report = new RetailReport;
            $retail_report->user_id = auth()->user()->id;
            $retail_report->dealer_id = $dealer->id;
            $retail_report->input_date = $request->input('date');
            $retail_report->bikemodel_code = $request->input('model');
            $retail_report->color_id = $request->input('color');
            $retail_report->spec_id = $request->input('spec');

            $last_amount = RetailReport::select('updated_inventory')->where('bikemodel_code','=', $retail_report->bikemodel_code)->where('user_id', '=', $retail_report->user_id)->where('color_id','=', $retail_report->color_id)->orderBy('input_date', 'DESC')->first();

            $retail_report->restock_amount = 0 + $request->input('in');
            $retail_report->retail_amount = 0 + $request->input('retail');
            $retail_report->last_inventory = 0 + $last_amount;
            $retail_report->updated_inventory = 0 + $last_amount + $retail_report->restock_amount - $retail_report->retail_amount;
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
    public function UpdateReport(Request $request)
    {
        try{
            $report = RetailReport::find($request->input('id'));

            $report->restock_amount = $request->input('in');
            $report->retail_amount = $request->input('retail');
            $report->updated_inventory = $request->input('last_in') + $request->input('in') - $request->input('retail');
            $report->remarks = $request->input('remarks');

            $report->save();
            return redirect('/retailreport')->with('success', 'Model updated successfully');
        }
        catch (Exception $e){
            return redirect('/retailreport')->with('failed', 'Woops, something is wrong!');
        }
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
