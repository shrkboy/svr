@extends('layouts.app')

@section('head-styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
@endsection

@section('navmenu')
    <ul class="navbar-nav mr-auto">
        @if(auth()->user()->role_id == 5)
            <li class="nav-item">
                <a href="{{ route('dashboard.warehouse') }}" class="nav-link">Dashboard</a>
            </li>
        @endif
        @if(auth()->user()->role_id == 4 || auth()->user()->role_id == 5)
            <li class="nav-item">
                <a href="{{ route('shipments.index') }}" class="nav-link">Shipments</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('returned_items.index') }}" class="nav-link active">Returned Items</a>
            </li>
        @endif
    </ul>
@endsection

@section('content')
    <div class="row">
        <div class="col-md m-auto">
            <h3 id="date">Loading date</h3>
            <h3 id="clock">Loading clock</h3>
            <h3>
                Logged in to {{ auth()->user()->warehouse->name }} as {{ auth()->user()->name }}
                <span class="text-primary">{{ auth()->user()->role_id == 5 ? ' (manager)' : '' }}</span>
            </h3>
        </div>
        @if(auth()->user()->role_id == 4)
            <div class="col-md text-right m-auto">
                <a name="new-shipment" id="new-shipment" class="btn btn-lg btn-primary"
                   href="{{ route('shipments.create') }}"
                   role="button">New shipment</a>
                <a name="return-items" id="return-items" class="btn btn-lg btn-primary"
                   href="{{ route('returned_items.create')  }}" role="button">Return items</a>
            </div>
        @endif
    </div>

    <div class="mt-3 card p-3">
        <h3>Returned items</h3>
        <table id="data-table" class="table table-sm table-striped" width="100%">
            <thead class="thead-inverse">
            <tr>
                <th width="2.5%">#</th>
                <th width="15%">Bike Model</th>
                <th>VIN</th>
                <th width="15%">From</th>
                <th width="20%">Return Time</th>
                <th>Info</th>
                {{--<th>Action</th>--}}
            </tr>
            </thead>

            {{--<tbody>--}}
            {{--@foreach($returned_items as $key=>$item)--}}
            {{--<tr>--}}
            {{--<td scope="row">{{ ++$key }}</td>--}}
            {{--<td>{{ $item->inventory->bike_model->name }}</td>--}}
            {{--<td>{{ $item->inventory->vin }}</td>--}}
            {{--<td>{{ $item->dealer->dlname }}</td>--}}
            {{--<td>{{ \Carbon\Carbon::parse($item->time)->format('M d Y, H:i:s') }}</td>--}}
            {{--<td>{{ $item->info }}</td>--}}
            {{--<td></td>--}}
            {{--</tr>--}}
            {{--@endforeach--}}
            {{--</tbody>--}}

            <tfoot class="thead-inverse">
            <tr>
                <th>#</th>
                <th>Bike Model</th>
                <th>VIN</th>
                <th>From</th>
                <th>Return Time</th>
                <th>Info</th>
                {{--<th>Action</th>--}}
            </tr>
            </tfoot>


        </table>

    </div>
@endsection

@section('script')
    <script src="{{ asset('js/clock-and-date.js') }}"></script>
    <script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <!-- Moment -->
    <script src="{{ asset('js/moment.min.js') }}" type="text/javascript"></script>
    <script>
        $(document).ready(function () {
            $("#data-table").DataTable({
                responsive: true,
                ajax: "{{ route('get_returned_item') }}",
                processing: true,
                serverSide: true,
                columns: [
                    {
                        data: 'id',
                        sortable: false,
                        searchable: false,
                        render: function (data, type, row, meta) {
                            return meta.row + 1;
                        }
                    },
                    {data: 'inventory.bike_model.name'},
                    {data: 'inventory.vin'},
                    {data: 'dealer.dlname'},
                    {
                        data: 'time',
                        render: function (data) {
                            if (data != null) {
                                const date = new Date(data);
                                return moment(date).format('MMMM DD, YYYY HH:mm:ss')
                            } else {
                                return ''
                            }
                        }
                    },
                    {
                        data: 'info',
                        sortable: false,
                    },
                ],
            });
        });
    </script>
@endsection
