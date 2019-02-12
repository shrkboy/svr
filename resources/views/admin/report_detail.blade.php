@extends('layouts.app')

@section('navmenu')
    <ul class="navbar-nav mr-auto">
        @if(\Illuminate\Support\Facades\Auth::user()->is_admin)
            <li class="nav-item active">
                <a class="nav-link" href="{{url('/admin')}}">Users</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="{{url('/reports')}}">Reports</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="{{url('/models')}}">Bike Models</a>
            </li>
        @endif
        <li class="nav-item">
            <a class="nav-link" href="{{url('/display')}}">Display</a>
        </li>
    </ul>
@stop

@section('content')
    <div class="container-fluid">
        <div class="col-md-auto">
            <h4>Report Detail</h4>
            <h6>Branch:</h6>
            <h6>{{ $reports->branches->name }}</h6>
            <table class="table table-striped" style="table-layout: fixed">
                <thead>
                <tr>
                    <th scope="col">Models</th>
                    <th scope="col">Display Qty</th>
                    <th scope="col">Talker</th>
                    <th scope="col">Flayer</th>
                    <th scope="col">Streamer</th>
                </tr>
                </thead>
                <tbody>
                @foreach($reports->details as $detail)
                    <tr>
                        <td scope="row">{{$detail->code_model}}</td>
                        <td>{{ $detail->dsp_qty }}</td>
                        <td>{{ $detail->talker }}</td>
                        <td>{{ $detail->flayer }}</td>
                        <td>{{ $detail->streamer }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection