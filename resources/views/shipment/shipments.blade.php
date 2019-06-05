@extends('layouts.app')

@section('head-styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-datetimepicker.min.css') }}">
@endsection

@section('navmenu')
    <ul class="navbar-nav mr-auto">
        @if(auth()->user()->role_id == 4)
            <li class="nav-item">
                <a href="{{ route('shipments.index') }}" class="nav-link disabled">Shipments</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('returned_items.index') }}" class="nav-link">Returned Items</a>
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
                   href="{{ route('returned_items.create')  }}" role="button">Return items</a>
            </div>
        </div>

        <div class="mt-3 card p-3">
            <h3>Shipment history</h3>
            <div class="table-responsive">
                <table id="data-table" class="table table-sm mt-3">

                    <thead class="thead-inverse">
                    <tr>
                        <th>No</th>
                        <th>ID</th>
                        <th>Departure</th>
                        <th>Destination</th>
                        <th>Status</th>
                        <th>Arrival</th>
                        <th>Action</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($shipments as $key=>$shipment)
                        <tr>
                            <td scope="row">{{ ++$key }}</td>
                            <td>{{ sprintf('SHP%08d', $shipment->id) }}</td>
                            <td>{{ \Carbon\Carbon::parse($shipment->depart_time)->format('M d Y, H:i:s') }}</td>
                            <td>{{ $shipment->dealer->dlname }}</td>
                            <td>
                                <span class="font-weight-bold text-{{ $shipment->status == 'DONE' ? 'success' : ($shipment->status == 'ONGOING' ? 'primary' : ($shipment->status == 'CANCELLED' ? 'warning' : 'danger')) }}">
                                    {{ $shipment->status }}
                                </span>
                            </td>
                            <td>{{ $shipment->received_time == null ? '' : \Carbon\Carbon::parse($shipment->received_time)->format('M d Y, H:i:s') }}</td>
                            <td>
                                <a href="{{ route('shipments.show', $shipment->id) }}"
                                   class="btn btn-primary">Details</a>
                                @if($shipment->status == 'ONGOING')
                                    <button type="button" class="btn btn-success" data-toggle="modal"
                                            data-target="#finishModal" data-id="{{ $shipment->id }}"
                                            data-number="{{ $key }}">Finish
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>

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
                                <input type="text" class="form-control" id="number" name="number" readonly hidden>
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
                    {orderable: false, searchable: false, targets: 5}
                ],
                responsive: true,
                {{--serverSide: true,--}}
                {{--processing: true,--}}
                {{--responsive: true,--}}
                {{--ajax: "{{ route('get_shipment') }}",--}}
                {{--columns: [--}}
                {{--{name: 'no'},--}}
                {{--{name: 'id'},--}}
                {{--{name: 'departure_time'},--}}
                {{--{name: 'dealer.dlname'},--}}
                {{--{name: 'status'},--}}
                {{--{name: 'received_time'},--}}
                {{--{name: 'action', sortable: false, searchable: false},--}}
                {{--],--}}
            });

            $('#received-time').datetimepicker();
            $('#finishModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget); // Button that triggered the modal
                var id = button.data('id'); // Extract info from data-* attributes
                var number = button.data('number');
                // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
                // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
                var modal = $(this);
                modal.find('.modal-title').text('Finish shipment number ' + number);
                modal.find('.modal-body input#id').val(id);
                modal.find('.modal-body input#number').val(number);
                modal.find('.modal-body input#received-time').val('');
                modal.find('.modal-body input#received-by').val('');
            });
        })
    </script>
@endsection
