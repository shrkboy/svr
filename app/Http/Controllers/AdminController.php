<?php

namespace App\Http\Controllers;

use App\BikeModel;
use App\DetailReport;
use App\Report;
use App\User;
use Illuminate\Http\Request;

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
        $reports = Report::with(['users','branches','documents'])->get();
        return view('admin.reports', compact('reports'));
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

}
