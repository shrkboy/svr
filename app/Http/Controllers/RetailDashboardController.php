<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\RetailReport;
use App\UserRole;
use App\Branch;

class RetailDashboardController extends Controller
{

    public function dashboard()
    {
        $month = date('m');
        $year = date('Y');

        $dealer_id = auth()->user()->dealer_id;

        $role = UserRole::where('id', '=', auth()->user()->role_id)->first();
        $dealer = Branch::where('id', '=', $dealer_id)->first();

        $soldthismonth = RetailReport::
            select(\DB::raw('sum(retail_amount) as amount'))
            ->where('dealer_id','=',$dealer_id)
            ->where(\DB::raw('month(input_date)'),'=',$month)
            ->where(\DB::raw('year(input_date)'),'=',$year)
            ->get();

        $restockedthismonth = RetailReport::
        select(\DB::raw('sum(restock_amount) as amount'))
            ->where('dealer_id','=',$dealer_id)
            ->where(\DB::raw('month(input_date)'),'=',$month)
            ->where(\DB::raw('year(input_date)'),'=',$year)
            ->get();

        $purchasedthismonth = RetailReport::
        select(\DB::raw('count(bikemodel_code) as amount'))
            ->where('dealer_id','=',$dealer_id)
            ->where(\DB::raw('month(input_date)'),'=',$month)
            ->where(\DB::raw('year(input_date)'),'=',$year)
            ->get();

        $last_updated = RetailReport::
            select('input_date')
            ->where('dealer_id','=',$dealer_id)
            ->orderBy('input_date', 'des')
            ->first();

        $modelsSold = RetailReport::
            select(\DB::raw('bikemodel_code as name, sum(retail_amount) as amount'))
            ->where('dealer_id','=',$dealer_id)
            ->where(\DB::raw('month(input_date)'),'=',$month)
            ->where(\DB::raw('year(input_date)'),'=',$year)
            ->groupBy('bikemodel_code')
            ->get();

        $monthlySold = RetailReport::
        select(\DB::raw('month(input_date) as month, sum(retail_amount) as amount'))
            ->where('dealer_id','=',$dealer_id)
            ->where(\DB::raw('year(input_date)'),'=',$year)
            ->groupBy(\DB::raw('month(input_date)'))
            ->get();

        $modelsStock = RetailReport::
        select(\DB::raw('bikemodel_code as name, sum(updated_inventory) as amount'))
            ->where('dealer_id','=',$dealer_id)
            ->where(\DB::raw('month(input_date)'),'=',$month)
            ->where(\DB::raw('year(input_date)'),'=',$year)
            ->groupBy('bikemodel_code')
            ->get();


        return view('salesmanager_dashboard', compact('modelsSold', 'monthlySold', 'role', 'dealer', 'modelsStock','modelsRestock',
            'soldthismonth', 'restockedthismonth', 'purchasedthismonth','last_updated'));
    }

    public function index()
    {

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
