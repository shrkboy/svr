@extends('layouts.app')

@section('head-styles')
    <link rel="stylesheet" href="{{ asset('css/font-awesome.css') }}">
    <link rel="stylesheet" href="{{ asset('css/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
@endsection

@section('navmenu')
    <ul class="navbar-nav mr-auto">
        @if(auth()->user()->role_id == 8)
            <li class="nav-item active">
                <a class="nav-link" href="{{url('/users')}}">Users</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{url('/reports')}}">Reports</a>
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
        <div class="row mb-3">
            <div class="col-md-6">
                <h4>Users</h4>
            </div>
            <div class="col-md-6">
                <a class="btn btn-primary float-right" role="button" href="{{url('/register')}}">Add User</a>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-sm table-striped" id="data-table">

                <thead class="thead-inverse">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Username</th>
                    <th scope="col">Role</th>
                </tr>
                </thead>

                <tbody>
                @foreach($users as $key=>$user)
                    <tr>
                        <td scope="row">{{ ++$key }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->username }}</td>
                        <td>{{ $user->role->name }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('js/clock-and-date.js') }}"></script>
    <script src="{{ asset('js/select2.full.min.js') }}"></script>
    <script src="{{ asset('js/datatables.min.js') }}"></script>
    <script src="{{ asset('js/moment.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap-datetimepicker.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            $("#data-table").DataTable();
        })
    </script>
@endsection
