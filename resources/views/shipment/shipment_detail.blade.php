@extends('layouts.app')

@section('navmenu')
    <ul class="navbar-nav mr-auto">
        @if(auth()->user()->id_role == 4)
            <li class="nav-item">
                <a href="{{ url('/shipments') }}" class="nav-link">Shipments</a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">Returned Items</a>
            </li>
        @endif
    </ul>
    <div class="form-inline my-2 my-lg-0">
        <a class="btn btn-link my-2 my-sm-0" href="#">Logout</a>
    </div>
@endsection

@section('content')
    <div class="mt-3 card p-3">
        <p>
            <a href="javascript:history.go(-1)" title="Return to the previous page" class="btn btn-danger">&laquo; Go
                back</a>
        </p>
        <h3>Shipment history</h3>
        <div class="row">
            <div class="col-lg-3">
                Shipment ID: 123 <br>
                Status: <span class="text-success">DONE</span> <br>
                Destination: Manila <br>
            </div>
            <div class="col-lg">
                Departure: May 01, 2019 22:00 <br>
                Received at: May 02, 2019 03:00 <br>
                Received by: Anthony<br>
            </div>
        </div>

        <table class="table table-sm mt-3">
            <thead class="thead-inverse">
            <tr>
                <th>No</th>
                <th>Bike model</th>
                <th>Qty</th>
                <th>Engine Numbers</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td scope="row"></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            </tbody>
        </table>
    </div>
@endsection

@section('script')
    <script src="clock-and-date.js"></script>
@endsection