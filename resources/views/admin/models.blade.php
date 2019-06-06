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
            <li class="nav-item">
                <a class="nav-link" href="{{url('/reports')}}">Reports</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link active" href="{{url('/models')}}">MC Models</a>
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
                <h4>MC Models</h4>
            </div>
            <div class="col-md-6">
                <a class="btn btn-primary float-right" role="button" href="{{url('/models/add')}}">Add</a>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-sm table-striped" id="data-table">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Code</th>
                    <th scope="col">Color</th>
                    <th scope="col">Specification</th>
                    <th scope="col">Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($models as $key=>$bike_model)
                    <tr>
                        <td scope="row">{{ ++$key }}</td>
                        <td>{{ $bike_model->name }}</td>
                        <td>{{ $bike_model->code }}</td>
                        <td>{{ $bike_model->color }}</td>
                        <td>{{ $bike_model->spec }}</td>
                        {{-- TODO: Add EDIT Url --}}
                        <td>
                            <a href="{{url('/models/edit/'. $bike_model->id)}}"
                               class="btn btn-secondary">Edit</a>
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
                    {orderable: false, searchable: false, targets: 5}
                ],
                responsive: true,
            });
        })
    </script>
@endsection
