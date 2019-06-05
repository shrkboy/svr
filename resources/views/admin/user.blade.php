@extends('layouts.app')

@section('head-script')
    <!-- Select2 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
@endsection

@section('head-styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
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
    <div class="container-fluid">
        <div class="card p-3">
            <div class="col-md-auto">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <h4>Users</h4>
                    </div>
                    <div class="col-md-6">
                        <a class="btn btn-primary float-right" role="button" href="{{url('/register')}}">Add User</a>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-sm mt-3" id="data-table">

                        <thead class="thead-inverse">
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Username</th>
                            <th scope="col">Role</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td scope="row">{{$user->name}}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->username }}</td>
                                <td>{{ $user->role->name }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('js/clock-and-date.js') }}"></script>
    <script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <!-- Moment -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.21.0/moment.min.js" type="text/javascript"></script>
    <!--FontAwesome-->
    <script src="https://use.fontawesome.com/094c71b384.js"></script>
    <!-- Bootstrap Date Time Picker -->
    <!-- https://www.jqueryscript.net/time-clock/Date-Time-Picker-Bootstrap-4.html -->
    <script src="{{ asset('js/bootstrap-datetimepicker.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            $("#data-table").DataTable({
                columnDefs: [
                    // {orderable: false, searchable: false, targets: 5}
                ],
                responsive: true,
            });
        })
    </script>
@endsection
