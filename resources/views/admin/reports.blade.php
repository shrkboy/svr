@extends('layouts.app')

@section('navmenu')
    <ul class="navbar-nav mr-auto">
        @if(auth()->user()->is_admin)
            <li class="nav-item">
                <a class="nav-link" href="{{url('/users')}}">Users</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="{{url('/reports')}}">Reports</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{url('/models')}}">Bike Models</a>
            </li>
        @endif
    </ul>
@stop

@section('content')
    <div class="container-fluid">
        <div class="col-md-auto">
            <h4>Reports</h4>
            <div class="table-responsive">
                <table class="table table-sm table-striped">
                    <thead>
                    <tr>
                        <th scope="col">Branch</th>
                        <th scope="col">Name</th>
                        <th scope="col">Username</th>
                        <th scope="col">Record Date and Time</th>
                        <th scope="col">Files Count</th>
                        <th scope="col">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($reports as $report)
                        <tr>
                            <td scope="row">{{ $report->branches->name }}</td>
                            <td>{{$report->users->name }}</td>
                            <td>{{ $report->users->username }}</td>
                            <td>{{ \Carbon\Carbon::parse($report->record_date)->format('M d, Y H:i:s') }}</td>
                            <td>{{ $report->documents->count() }}</td>
                            <td>
                                <a href="{{ url('/reports/detail/' . $report->id) }}"
                                   class="btn btn-link">See details</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection