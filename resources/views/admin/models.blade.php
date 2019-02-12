@extends('layouts.app')

@section('navmenu')
    <ul class="navbar-nav mr-auto">
        @if(auth()->user()->is_admin)
            <li class="nav-item">
                <a class="nav-link" href="{{url('/users')}}">Users</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{url('/reports')}}">Reports</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="{{url('/models')}}">Bike Models</a>
            </li>
        @endif
    </ul>
@stop

@section('content')
    <div class="container-fluid">
        <div class="col-md-auto">
            <div class="row mb-3">
                <div class="col-md-6">
                    <h4>Bike Models</h4>
                </div>
                <div class="col-md-6">
                    <a class="btn btn-primary float-right" role="button" href="{{url('/register')}}">Add Model</a>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-sm table-striped">
                    <thead>
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Code</th>
                        <th scope="col">Color</th>
                        <th scope="col">Specification</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($models as $bike_model)
                        <tr>
                            <td scope="row">{{ $bike_model->name }}</td>
                            <td scope="row">{{ $bike_model->code }}</td>
                            <td scope="row">{{ $bike_model->color }}</td>
                            <td scope="row">{{ $bike_model->spec }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
@endsection