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
            <div class="col-md-4 mb-3">
                <label for="month">Filter by Month</label>
                <form action="{{ url('/reports') }}" method="get" class="form-inline">
                    <input id="month" name="month" type="month" class="form-control mr-2"
                           value="{{ $filter }}">
                    <button type="submit" class="btn btn-primary">Filter</button>
                </form>
            </div>
            <div class="table-responsive">
                <table class="table table-sm table-striped">
                    <thead>
                    <tr>
                        <th scope="col">Branch</th>
                        <th scope="col">Name</th>
                        <th scope="col">Username</th>
                        <th scope="col">Date and Time</th>
                        <th scope="col">Files Count</th>
                        <th scope="col">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($reports as $report)
                        <tr>
                            <td scope="row">{{ $report->branches->dlname }}</td>
                            <td>{{$report->users->name }}</td>
                            <td>{{ $report->users->username }}</td>
                            <td>{{ \Carbon\Carbon::parse($report->record_date)->format('M d, Y H:i:s') }}</td>
                            <td>{{ $report->documents->count() }}</td>
                            <td>
                                <a href="{{ url('/reports/detail/' . $report->id) }}"
                                   class="btn btn-outline-primary">See details</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection