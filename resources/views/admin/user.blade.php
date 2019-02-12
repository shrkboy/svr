@extends('layouts.app')

@section('head-script')
    <!-- Select2 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
@endsection

@section('navmenu')
    <ul class="navbar-nav mr-auto">
        @if(\Illuminate\Support\Facades\Auth::user()->is_admin)
            <li class="nav-item active">
                <a class="nav-link" href="{{url('/users')}}">Users</a>
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
            <h4>Users</h4>
            <a class="btn btn-primary" role="button" href="{{url('/register')}}">Add User</a>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
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
                            @if($user->is_admin)
                                <td>{{'Aadmin'}}</td>
                            @else
                                <td>{{'User'}}</td>
                            @endif
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection