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
@endsection

@section('content')
    <div class="container-fluid">
        <div class="card p-3">
            <p>
                <a href="javascript:history.go(-1)" title="Return to the previous page" class="btn btn-danger">&laquo;
                    Go
                    back</a>
            </p>
            <h3>Shipment history</h3>
            <div class="row">
                <div class="col-lg-3">
                    Shipment ID: {{ sprintf('%08d', $shipment->id) }} <br>
                    Status: <span
                            class="{{ $shipment->status == 'DONE' ? 'text-success' : $shipment->status == 'ONGOING' ? 'text-primary' : 'text-danger' }}">{{ $shipment->status }}</span>
                    <br>
                    Destination: {{ $shipment->warehouse->name }} <br>
                </div>
                <div class="col-lg">
                    Departure: {{ $shipment->depart_time }} <br>
                    Received at: {{ $shipment->received_time ? $shipment->received_time : '-' }} <br>
                    Received by: {{ $shipment->received_by ? $shipment->received_by : '-' }}<br>
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
    </div>
@endsection

@section('script')
    <script src="clock-and-date.js"></script>
@endsection