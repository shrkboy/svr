<?php

namespace App\Http\Controllers;

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

    public function model()
    {

    }


}
