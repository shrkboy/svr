@extends('layouts.app')

@section('head-styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
@endsection

@section('navmenu')
    <ul class="navbar-nav mr-auto">
        @if(auth()->user()->role_id == 8)
            <li class="nav-item">
                <a class="nav-link" href="{{url('/users')}}">Users</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link active" href="{{url('/reports')}}">Reports</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{url('/models')}}">MC Models</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{url('/warehouses')}}">Warehouses</a>
            </li>
        @endif
    </ul>
@stop

@section('content')
    <div class="card p-3">
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
            <table class="table table-sm table-striped" id="data-table">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Branch</th>
                    <th scope="col">Name</th>
                    <th scope="col">Username</th>
                    <th scope="col">Date and Time</th>
                    <th scope="col">Files Count</th>
                    <th scope="col">Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($reports as $key=>$report)
                    <tr>
                        <td scope="row">{{ ++$key }}</td>
                        <td>{{ $report->branches->dlname }}</td>
                        <td>{{$report->users->name }}</td>
                        <td>{{ $report->users->username }}</td>
                        <td>{{ \Carbon\Carbon::parse($report->record_date)->format('M d, Y H:i:s') }}</td>
                        <td>{{ $report->documents->count() }}</td>
                        <td>
                            <a href="{{ url('/reports/detail/' . $report->id) }}"
                               class="btn btn-primary">Details</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('script')
    <script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function () {
            $("#data-table").DataTable({
                columnDefs: [
                    {orderable: false, searchable: false, targets: 6}
                ],
                responsive: true,
            });
        })
    </script>
@endsection
