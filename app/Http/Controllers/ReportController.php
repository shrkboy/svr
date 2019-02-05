<?php

namespace App\Http\Controllers;

use App\Branch;
use App\BikeModel;
use App\Report;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ReportController extends Controller
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
        //
        $branches = Branch::all();
        $models = BikeModel::all();
        return view('display', compact('branches','models'));
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

        //return $request;
        $last = Report::all()->last();
        if ($last === null){
            $last = new Report();
            $last->id_report = '1';
        }
        if ($file = $request->file('photo'))
        {
            $name = 'REPORT'.$last->id_report.'.'.$file->extension();
            $file->move('images',$name);
        }

        foreach($request->input('id') as $i){
            $qty = $request->input('display-qty_'.$i);
            $talker = $request->input('talker_'.$i);
            $flyer = $request->input('flyer_'.$i);
            $streamer = $request->input('streamer_'.$i);

            $current_time = Carbon::now()->toDateTimeString();
            $data=array("id_user"=> auth()->user()->id, "id_branch"=> 1, "id_model"=> $i,"dsp_qty"=>$qty,"talker"=>$talker,"flayer"=>$flyer,
                "streamer"=>$streamer, 'record_date'=>$current_time, 'pic_path' => $name);
            DB::table('reports')->insert($data);
        }

        return redirect('/display');

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
