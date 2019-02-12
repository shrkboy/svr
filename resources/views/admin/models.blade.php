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
            <h4>Bike Models</h4>
            <a class="btn btn-primary" role="button" href="#">Add Model</a>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Code</th>
                    <th scope="col">Color</th>
                    <th scope="col">Specification</th>
                </tr>
                </thead>
                <tbody>
                @foreach($bike_models as $bike_model)
                    <tr>
                        <td scope="row">{{ $bike_model->user_name }}</td>
                        <td scope="row">{{ $bike_model->code }}</td>
                        <td scope="row">{{ $bike_model->color }}</td>
                        <td scope="row">{{ $bike_model->spec }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection