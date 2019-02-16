<?php

namespace App\Http\Controllers;

use App\BikeModel;
use App\DetailReport;
use App\Report;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class AdminController extends Controller
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

    public function user()
    {
        //
        $users = User::all();
        return view('admin.user', compact('users'));
    }

    public function report()
    {
        if ( $filter = Input::get('month'))
        {
            $year = new Carbon($filter);
            $month = new Carbon($filter);
            $reports = Report::with(['users','branches','documents'])->whereMonth('record_date','=',$month->format('m'))->whereYear('record_date','=',$year->format('Y'))->get();
            return view('admin.reports', compact('reports','filter'));
        }
        $year = Carbon::now()->format('Y');
        $month = Carbon::now()->format('m');
        $reports = Report::with(['users','branches','documents'])->whereMonth('record_date','=',$month)->whereYear('record_date','=',$year)->get();

        $filter = Carbon::now()->format('Y-m');
        return view('admin.reports', compact('reports','filter'));
    }

    public function detail_report($id)
    {
        $reports = Report::where('id',$id)->with(['users','branches','documents','details'])->first();
        return view('admin.report_detail', compact('reports'));
    }

    public function model()
    {
        $models = BikeModel::all();
        return view('admin.models', compact('models'));
    }

    public function showInsertModel()
    {
        return view('admin.add_model');
    }

    public function InsertModel(Request $request)
    {
        try{
            $newModel = new BikeModel;
            $newModel->name = $request->name;
            $newModel->code = $request->code;
            $newModel->color = $request->color;
            $newModel->spec = $request->specification;

            $newModel->save();
            return redirect('/models')->with('success', 'New model inserted successfully');
        }
        catch (Exception $e){
            return redirect('/models')->with('failed', 'Woops, something is wrong!');
        }
    }


    /* Update Model Methode */

    public function showUpdateModelForm($id){
        $models = BikeModel::find($id);

        return view('admin.update_model', compact('models'));
    }

    public function UpdateModel(Request $request){

        try{
            $model = BikeModel::find($request->id);

            $model->name = $request->name;
            $model->code = $request->code;
            $model->color = $request->color;
            $model->spec = $request->specification;

            $model->save();
            return redirect('/models')->with('success', 'Model updated successfully');
        }
        catch (Exception $e){
            return redirect('/models')->with('failed', 'Woops, something is wrong!');
        }
    }

}
