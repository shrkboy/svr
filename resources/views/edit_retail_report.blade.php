@extends('layouts.app')

@section('head-styles')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/select2-bootstrap4.min.css') }}">

    <!-- Bootstrap Date Time Picker -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap-datetimepicker.min.css') }}">
@endsection

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
    <div class="container">
        <div class="col-md-auto">
            <h4>Edit Retail Report</h4>
            <form method="post" action="{{ url('/edit') }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="form-group row">
                    <div class="col-md-4">
                        <label for="branch">Branch</label>
                        <br>
                        <input name="branch" id="branch" value="{{$report->dlname}}" class="form-control" readonly>
                    </div>
                    <div class="col-md-4">
                        <label for="date">Date</label>
                        <br>
                        <input name="date" id="date" value="{{$report->input_date}}" class="form-control" readonly>
                    </div>
                    <div class="col-md-4">
                        <label for="model">Bike Model</label>
                        <br>
                        <input name="model" id="model" value="{{$report->bikemodel_code}}" class="form-control" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-4">
                        <label for="color">Color</label>
                        <br>
                        <input name="color" id="color" value="{{$report->cname}}" class="form-control" readonly>
                    </div>
                    <div class="col-md-4">
                        <label for="spec">Specification</label>
                        <br>
                        <input name="spec" id="spec" value="{{$report->sname}}" class="form-control" readonly>
                    </div>
                    <div class="col-md-4">
                        <input type="hidden" name="id" id="id" value="{{$report->id}}" class="form-control" readonly>
                    </div>
                </div>
                <input type="hidden" name="last_in" id="last_in" value="{{$report->last_inventory}}" class="form-control" readonly>
                <div class="form-group">
                    <label for="in">In</label>
                    <br>
                    <input type="number" id="in" name="in" min="0" max="10000" value="{{$report->restock_amount}}" class="form-control">
                </div>
                <div class="form-group">
                    <label for="retail">Retail</label>
                    <br>
                    <input type="number" id="retail" name="retail" min="0" max="10000" value="{{$report->retail_amount}}" class="form-control">
                </div>
                <div class="form-group">
                    <label for="remarks">Remarks</label>
                    <br>
                    <textarea id="remarks" name="remarks" class="form-control">{{$report->remarks}}</textarea>
                </div>
                <div class="form-group">
                    <div class="text-right mt-3">
                        <button type="submit" id="submit read" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

