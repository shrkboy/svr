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
                <a class="nav-link" href="{{url('/models')}}">MC Models</a>
            </li>
        @endif
    </ul>
@stop

@section('content')
    <div class="container-fluid">
        <div class="col-md-auto">
            @if(Session::has('success'))
                <div class="alert alert-success mx-auto" role="alert">
                    {{ Session::get('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @elseif (Session::has('failed'))
                <div class="alert alert-danger mx-auto" role="alert">
                    {{ Session::get('failed') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            <div class="row mb-3">
                <div class="col-md-6">
                    <h4>MC Models</h4>
                </div>
                <div class="col-md-6">
                    <a class="btn btn-primary float-right" role="button" href="{{url('/models/add')}}">Add Model</a>
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
                        <th scope="col">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($models as $bike_model)
                        <tr>
                            <td scope="row">{{ $bike_model->name }}</td>
                            <td scope="row">{{ $bike_model->code }}</td>
                            <td scope="row">{{ $bike_model->color }}</td>
                            <td scope="row">{{ $bike_model->spec }}</td>
                            {{-- TODO: Add EDIT Url --}}
                            <td scope="row">
                                <a href="#" class="btn btn-outline-primary">Edit</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
@endsection