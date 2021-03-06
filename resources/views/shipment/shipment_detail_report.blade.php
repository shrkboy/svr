@extends('layouts.report')

@section('content')
    <img src="{{ asset('images/logo.png') }}" alt="logo" width="150px">
    <hr>
    <h1>Shipment Report</h1>
    <table id="metadata">
        <tr>
            <td>Generated at</td>
            <td>: {{ \Carbon\Carbon::now()->format('M d Y, H:i:s') }}</td>
        </tr>
        <tr>
            <td>Generated by</td>
            <td>: {{ auth()->user()->name }}</td>
        </tr>
        <tr>
            <td>Warehouse</td>
            <td>: {{ auth()->user()->warehouse->name }}</td>
        </tr>
        <tr class="blank-row">
            <td colspan="3"></td>
        </tr>
        <tr class="blank-row">
            <td colspan="3"></td>
        </tr>
        <tr>
            <td>Shipment ID</td>
            <td>: {{ sprintf('SHP%08d', $shipment->id) }}</td>
        </tr>
        <tr class="blank-row">
            <td colspan="3"></td>
        </tr>
        <tr>
            <td>Status</td>
            <td>: {{ $shipment->status }}</td>
        </tr>
        <tr>
            <td>Origin</td>
            <td>: {{ $shipment->warehouse->name }}</td>
        </tr>
        <tr>
            <td>Destination</td>
            <td>: {{ $shipment->dealer->dlname }}</td>
        </tr>
        <tr class="blank-row">
            <td colspan="3"></td>
        </tr>
        <tr>
            <td>Departure</td>
            <td>: {{ \Carbon\Carbon::parse($shipment->depart_time)->format('M d Y, H:i:s') }}</td>
        </tr>
        <tr>
            <td>Received at</td>
            <td>: {{ $shipment->received_time != null ? \Carbon\Carbon::parse($shipment->received_time)->format('M d Y, H:i:s') : '-' }}</td>
        </tr>
        <tr>
            <td>Received by</td>
            <td>: {{ $shipment->received_by != null ? $shipment->received_by : '-' }}</td>
        </tr>
    </table>

    <hr>

    <h3>Shipment Detail</h3>
    <table id="data" border="1">
        <thead class="thead-inverse">
        <tr>
            <th>#</th>
            <th>Bike model</th>
            <th>Bike code</th>
            <th>Bike color</th>
            <th>VIN</th>
        </tr>
        </thead>
        <tbody>
        @foreach($details as $key=>$detail)
            <tr>
                <td align="right" scope="row">{{ ++$key }}</td>
                <td>{{ $detail->inventory->bike_model->name }}</td>
                <td>{{ $detail->inventory->bike_model->code }}</td>
                <td>{{ $detail->inventory->bike_model->color }}</td>
                <td align="right">{{ $detail->inventory->vin }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection