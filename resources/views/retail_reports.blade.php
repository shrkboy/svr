@extends('layouts.app')

@section('navmenu')
    <ul class="navbar-nav mr-auto">
        <li class="nav-item">
            <a class="nav-link" href="{{url('/display')}}">Home</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{url('/display')}}">Display</a>
        </li>
        <li class="nav-item active">
            <a class="nav-link" href="{{url('/retailreport')}}">Retail</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{url('/display')}}">Calendar</a>
        </li>
        @if(auth()->user()->is_admin)
            <li class="nav-item">
                <a class="nav-link" href="{{url('/users')}}">Users</a>
            </li>
        @endif
    </ul>
@stop

@section('content')
    <div class="container-fluid">
        <div class="col-md-auto">
           <h4>Retail Report</h4>
            <div class="text-right mt-3">
                <a href="{{url('/addretailreport')}}" class="btn btn-primary">Add Retail Report</a>
            </div>
            <br>
            @if(Session::has('success'))
                <div class="alert alert-success mx-auto" role="alert">
                    {{ Session::get('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @elseif (Session::has('failed'))
                <div class="alert alert-danger mx-auto" role="alert">
                    {{ Session::get('failed') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            <div class="table-responsive">
                <table class="table table-striped" style="table-layout: fixed">
                    <thead>
                    <tr>
                        <th scope="col">Dealer</th>
                        <th scope="col">Date</th>
                        <th scope="col">Bike Model</th>
                        <th scope="col">Color</th>
                        <th scope="col">Specification</th>
                        <th scope="col">Last Inventory</th>
                        <th scope="col">Restock</th>
                        <th scope="col">Retail</th>
                        <th scope="col">Updated Inventory</th>
                        <th scope="col">Remarks</th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($retailreports as $retailreport)
                        <tr>
                            <td scope="row">{{$retailreport->dlname}}</td>
                            <td scope="row">{{$retailreport->input_date}}</td>
                            <td scope="row">{{$retailreport->bikemodel_code}}</td>
                            <td scope="row">{{$retailreport->cname}}</td>
                            <td scope="row">{{$retailreport->sname}}</td>
                            <td scope="row">{{$retailreport->last_inventory}}</td>
                            <td scope="row">{{$retailreport->restock_amount}}</td>
                            <td scope="row">{{$retailreport->retail_amount}}</td>
                            <td scope="row">{{$retailreport->updated_inventory}}</td>
                            <td scope="row">{{$retailreport->remarks}}</td>
                            <td scope="row">
                                <div class="text-right">
                                    <a href="{{url('/edit/'.$retailreport->id)}}" class="btn btn-primary">Edit</a>
                                </div>
                            </td>

                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
