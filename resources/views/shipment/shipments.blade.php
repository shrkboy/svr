@extends('layouts.app')

@section('head-styles')
    <link rel="stylesheet" href="{{ asset('css/font-awesome.css') }}">
    <link rel="stylesheet" href="{{ asset('css/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-datetimepicker.min.css') }}">
@endsection

@section('navmenu')
    <ul class="navbar-nav mr-auto">
        @if(auth()->user()->role_id == 5)
            <li class="nav-item">
                <a href="{{ route('dashboard.warehouse') }}" class="nav-link">Dashboard</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('dashboard.warehouse.auth_key') }}" class="nav-link">Auth key</a>
            </li>
        @endif
        @if(auth()->user()->role_id == 4 || auth()->user()->role_id == 5)
            <li class="nav-item">
                <a href="{{ route('shipments.index') }}" class="nav-link active">Shipments</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('returned_items.index') }}" class="nav-link">Returned Items</a>
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
        <h3>Shipment history</h3>
        <div class="table-responsive">
            <table id="data-table" class="table table-sm table-striped" width="100%">

                <thead class="thead-inverse">
                <tr>
                    <th width="2.5%">#</th>
                    <th width="10%">ID</th>
                    <th>Departure</th>
                    <th>Destination</th>
                    <th>Status</th>
                    <th>Arrival</th>
                    <th width="12.5%">Action</th>
                </tr>
                </thead>

                {{--<tbody>--}}
                {{--@foreach($shipments as $key=>$shipment)--}}
                {{--<tr>--}}
                {{--<td scope="row">{{ ++$key }}</td>--}}
                {{--<td>{{ sprintf('SHP%08d', $shipment->id) }}</td>--}}
                {{--<td>{{ \Carbon\Carbon::parse($shipment->depart_time)->format('M d Y, H:i:s') }}</td>--}}
                {{--<td>{{ $shipment->dealer->dlname }}</td>--}}
                {{--<td>--}}
                {{--<span class="font-weight-bold text-{{ $shipment->status == 'DONE' ? 'success' : ($shipment->status == 'ONGOING' ? 'primary' : ($shipment->status == 'CANCELLED' ? 'warning' : 'danger')) }}">--}}
                {{--{{ $shipment->status }}--}}
                {{--</span>--}}
                {{--</td>--}}
                {{--<td>{{ $shipment->received_time == null ? '' : \Carbon\Carbon::parse($shipment->received_time)->format('M d Y, H:i:s') }}</td>--}}
                {{--<td>--}}
                {{--<a href="{{ route('shipments.show', $shipment->id) }}"--}}
                {{--class="btn btn-primary">Details</a>--}}
                {{--@if(auth()->user()->role_id == 4)--}}
                {{--@if($shipment->status == 'ONGOING')--}}
                {{--<button type="button" class="btn btn-success" data-toggle="modal"--}}
                {{--data-target="#finishModal" data-id="{{ $shipment->id }}"--}}
                {{--data-number="{{ $key }}">Finish--}}
                {{--</button>--}}
                {{--@endif--}}
                {{--@endif--}}
                {{--</td>--}}
                {{--</tr>--}}
                {{--@endforeach--}}
                {{--</tbody>--}}

                <tfoot>
                <tr>
                    <th>#</th>
                    <th>ID</th>
                    <th>Departure</th>
                    <th>Destination</th>
                    <th>Status</th>
                    <th>Arrival</th>
                    <th>Action</th>
                </tr>
                </tfoot>

            </table>
        </div>


        {{--Modal to complete shipment--}}
        <div class="modal fade" id="finishModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">New message</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="post" action="{{ url('/shipments/finish') }}">
                        {{ csrf_field() }}
                        <div class="modal-body">
                            <input type="text" class="form-control" id="id" name="id" readonly hidden>
                            <div class="form-group">
                                <label for="received-time" class="col-form-label">Received time:</label>
                                <input type="text" class="form-control" id="received-time" name="received-time"
                                       required>
                            </div>
                            <div class="form-group">
                                <label for="received-by" class="col-form-label">Received by:</label>
                                <input type="text" class="form-control" id="received-by" name="received-by"
                                       required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


    </div>
@endsection

@section('script')
    <script src="{{ asset('js/clock-and-date.js') }}"></script>
    <script src="{{ asset('js/datatables.min.js') }}"></script>
    <!-- Moment -->
    <script src="{{ asset('js/moment.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/bootstrap-datetimepicker.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            $("#data-table").DataTable({
                responsive: true,
                ajax: "{{ auth()->user()->role_id == 4 ? route('get_shipment') : route('get_shipment_full') }}",
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
                    {
                        data: 'id',
                        render: function (data) {
                            return 'SHP' + String('00000000' + data).slice(-8)
                        }
                    },
                    {
                        data: 'depart_time',
                        render: function (data) {
                            return moment(data).format('MMMM DD, YYYY HH:mm')
                        }
                    },
                    {data: 'dealer.dlname'},
                    {
                        data: 'status',
                        render: function (data) {
                            switch (data) {
                                case 'DONE':
                                    return '<span class="text-success font-weight-bold">' + data + '</span>';
                                case 'ONGOING':
                                    return '<span class="text-primary font-weight-bold">' + data + '</span>';
                                case 'DELAYED':
                                    return '<span class="text-warning font-weight-bold">' + data + '</span>';
                                case 'CANCELLED':
                                    return '<span class="text-danger font-weight-bold">' + data + '</span>';
                                case 'DELETED':
                                    return '<span class="text-danger font-weight-bold">' + data + '</span>';
                            }
                        }
                    },
                    {
                        data: 'received_time',
                        render: function (data) {
                            if (data != null) {
                                return moment(data).format('MMMM DD, YYYY HH:mm')
                            } else {
                                return '-'
                            }
                        }
                    },
                    {
                        data: 'id',
                        sortable: false,
                        searchable: false,
                        render: function (data, type, row, meta) {
                            let returnValue = '<a href="{{ url('shipments') }}/' + data + '" class="btn btn-primary">Details</a>';
                            if ('{{ auth()->user()->role_id }}' === '4') {
                                if (row.status === 'ONGOING') {
                                    returnValue = returnValue + '<button type="button" class="btn btn-success ml-1" data-toggle="modal"\n' +
                                        'data-target="#finishModal" data-id="' + data + '"\n' +
                                        'data-number="' + (meta.row + 1) + '">Finish\n' +
                                        '</button>\n'
                                }
                            }
                            return returnValue;
                        }
                    },
                ],
            });

            $('#received-time').datetimepicker();
            $('#finishModal').on('show.bs.modal', function (event) {
                const button = $(event.relatedTarget); // Button that triggered the modal
                const id = button.data('id'); // Extract info from data-* attributes
                const number = button.data('number');
                // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
                // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
                const modal = $(this);
                modal.find('.modal-title').text('Finish shipment number ' + number);
                modal.find('.modal-body input#id').val(id);
                modal.find('.modal-body input#number').val(number);
                modal.find('.modal-body input#received-time').val('');
                modal.find('.modal-body input#received-by').val('');
            });
        })
    </script>
@endsection
