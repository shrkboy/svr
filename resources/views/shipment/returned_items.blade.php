@extends('layouts.app')

@section('head-styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
@endsection

@section('navmenu')
    <ul class="navbar-nav mr-auto">
        @if(auth()->user()->role_id == 4)
            <li class="nav-item">
                <a href="{{ route('shipments.index') }}" class="nav-link">Shipments</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('returned_items.index') }}" class="nav-link disabled">Returned Items</a>
            </li>
        @endif
    </ul>
@endsection

@section('content')
    <div class="container-fluid">
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

        <div class="row">
            <div class="col-md m-auto">
                <h3 id="date">Loading date</h3>
                <h3 id="clock">Loading clock</h3>
                <h3>Logged in to {{ auth()->user()->warehouse->name }} as {{ auth()->user()->name }}</h3>
            </div>
            <div class="col-md text-right m-auto">
                <a name="new-shipment" id="new-shipment" class="btn btn-lg btn-primary"
                   href="{{ route('shipments.create') }}"
                   role="button">New shipment</a>
                <a name="return-items" id="return-items" class="btn btn-lg btn-primary"
                   href="{{ route('returned_items.create') }}" role="button">Return items</a>
            </div>
        </div>

        <div class="mt-3 card p-3">
            <h3>Returned items</h3>
            <table id="data-table" class="table table-sm mt-3">
                <thead class="thead-inverse">
                <tr>
                    <th>No</th>
                    <th>Bike Model</th>
                    <th>VIN</th>
                    <th>From</th>
                    <th>Return Time</th>
                    <th>Info</th>
                    {{--<th>Action</th>--}}
                </tr>
                </thead>
                <tbody>
                @foreach($returned_items as $key=>$item)
                    <tr>
                        <td scope="row">{{ ++$key }}</td>
                        <td>{{ $item->inventory->bike_model->name }}</td>
                        <td>{{ $item->inventory->vin }}</td>
                        <td>{{ $item->dealer->dlname }}</td>
                        <td>{{ $item->time }}</td>
                        <td>{{ $item->info }}</td>
                        {{--<td></td>--}}
                    </tr>
                @endforeach
                </tbody>
            </table>

        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('js/clock-and-date.js') }}"></script>
    <script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function () {
            $("#data-table").DataTable({
                columnDefs: [
                    // {orderable: false, targets: 6}
                ],
            });
        });
    </script>
@endsection
