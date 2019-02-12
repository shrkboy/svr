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
                <a class="nav-link" href="{{url('/bike_models')}}">Bike Models</a>
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
            <h4>Reports</h4>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Username</th>
                    <th scope="col">Record Date</th>
                    <th scope="col">Files Count</th>
                    <th scope="col">Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($reports as $report)
                    <tr>
                        <td scope="row">{{$report->user_name }}</td>
                        <td>{{ $report->branch_name }}</td>
                        <td>{{ $report->record_date }}</td>
                        <td>{{ $report->files_count }}</td>
                        <td>
                            <a href="{{ url('/reports/detail/' . $report->id) }}"
                               class="btn btn-default">Details</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection