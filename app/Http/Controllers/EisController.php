<?php

namespace App\Http\Controllers;

use App\Report;
use App\Shipment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Branch;
use Illuminate\Support\Facades\Input;

class EisController extends Controller
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

    public function all()
    {
        //
        $dealers = Branch::all();

        $newDealer = array();
        $dealerStatus = array();
        $year = Carbon::now()->format('Y');
        $month = Carbon::now()->format('m');

        foreach ($dealers as $dealer){
            $newDealer[] = $dealer;
            $dealerStatus[] = Report::with('users')->where('id_branch','=',$dealer->id)->whereMonth('record_date','=',
                $month)->whereYear('record_date','=',$year)->orderBy('record_date', 'desc')->first();
        }

        if ( $filter = Input::get('month'))
        {
            /*sub setting filter to year and month variable*/
            $year = new Carbon($filter);
            $month = new Carbon($filter);

            /*Get reports data filtered by month*/
            $reports = Report::with(['users','branches','documents'])->whereMonth('record_date','=',
                $month->format('m'))->whereYear('record_date','=',$year->format('Y'))->get();
            return view('Eis.salesreport', compact('reports','filter','newDealer','dealerStatus'));
        }
        /*if there isn't any filter variable yet*/
        $year = Carbon::now()->format('Y');
        $month = Carbon::now()->format('m');

        /*Get reports data filtered by this month*/
        $reports = Report::with(['users','branches','documents'])->whereMonth('record_date',
            '=',$month)->whereYear('record_date','=',$year)->get();
        $filter = Carbon::now()->format('Y-m');

        return view('Eis.salesreport', compact('reports','filter','newDealer','dealerStatus'));
    }

    public function chartPerMonth()
    {
        //Get Data Sales Report Each Month
        $result = Branch::all();
        return response()->json($result);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function detailDealer($id){
        $reports = Report::where('id_branch',$id)->with(['users','branches','documents','details.model'])->first();
//        return $reports;
        return view('Eis.dealer', compact('reports'));
    }

    public function detail($id){
        $reports = Report::where('id',$id)->with(['users','branches','documents','details.model'])->first();
//        return $reports;
        return view('Eis.details', compact('reports'));
    }

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
     * @param  \App\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function show(Report $report)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function edit(Report $report)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Report $report)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function destroy(Report $report)
    {
        //
    }
}
