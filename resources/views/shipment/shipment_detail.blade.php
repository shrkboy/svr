@extends('layouts.app')

@section('head-styles')
    <!-- Bootstrap Date Time Picker -->
    <link rel="stylesheet" href="{{ asset('css/font-awesome.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-datetimepicker.min.css') }}">
@endsection

@section('navmenu')
    <ul class="navbar-nav mr-auto">
        @if(auth()->user()->role_id == 4)
            <li class="nav-item">
                <a href="{{ url('/shipments') }}" class="nav-link">Shipments</a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">Returned Items</a>
            </li>
        @endif
    </ul>
@endsection

@section('content')
    <div class="card p-3">
        <div class="row">
            <div class="col-sm">
                <h3>Shipment history</h3>
            </div>
            <div class="col-sm-6 text-right">
                <a class="btn btn-secondary" href="{{ url('/shipments/report/'.$shipment->id) }}">Print report</a>
                @if(auth()->user()->role_id == 4 && $shipment->status != 'DONE' && $shipment->status != 'CANCELLED')
                    <div class="btn-group">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Options
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="options">
                            @if($shipment->status == 'ONGOING')
                                <button type="button" class="dropdown-item" data-toggle="modal"
                                        data-target="#finishModal">Mark as Finished
                                </button>
                                <button type="button" class="dropdown-item" data-toggle="modal"
                                        data-target="#statusUpdateModal" data-flag="delay">Mark as Delayed
                                </button>
                            @elseif($shipment->status == 'DELAYED')
                                <button type="button" class="dropdown-item" data-toggle="modal"
                                        data-target="#statusUpdateModal" data-flag="ongoing">Mark as Ongoing
                                </button>
                            @endif
                            <button type="button" class="dropdown-item" data-toggle="modal"
                                    data-target="#statusUpdateModal" data-flag="cancel">Mark as Cancelled
                            </button>
                            <div class="dropdown-divider"></div>
                            <button type="button" class="dropdown-item text-danger" data-toggle="modal"
                                    data-target="#confirmationModal">Delete
                            </button>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3">
                Shipment ID: {{ sprintf('SHP%08d', $shipment->id) }} <br>
                Destination: {{ $shipment->dealer->dlname }} <br>
                Status: <span
                        class="font-weight-bold text-{{ $shipment->status == 'DONE' ? 'success' : ($shipment->status == 'ONGOING' ? 'primary' : ($shipment->status == 'DELAYED' ? 'warning' : 'danger')) }}">{{ $shipment->status }}</span>
                <br>
                @if($shipment->status == 'DELAYED' || $shipment->status == 'CANCELLED')
                    Info: {{ $shipment->info }}
                @endif
            </div>
            <div class=" col-lg">
                Departure: {{ \Carbon\Carbon::parse($shipment->depart_time)->format('M d Y, H:i:s') }} <br>
                Received
                at: {{ $shipment->received_time != null ? \Carbon\Carbon::parse($shipment->received_time)->format('M d Y, H:i:s') : '-' }}
                <br>
                Received by: {{ $shipment->received_by != null ? $shipment->received_by : '-' }}<br>
            </div>
        </div>

        <div class="table-responsive mt-3">
            <table class="table table-sm table-striped">
                <thead class="thead-inverse">
                <tr>
                    <th>No</th>
                    <th>Bike model</th>
                    <th>Bike code</th>
                    <th>Bike color</th>
                    <th>VIN</th>
                </tr>
                </thead>
                <tbody>
                @foreach($details as $key=>$detail)
                    <tr>
                        <td scope="row">{{ ++$key }}</td>
                        <td>{{ $detail->inventory->bike_model->name }}</td>
                        <td>{{ $detail->inventory->bike_model->code }}</td>
                        <td>{{ $detail->inventory->bike_model->color }}</td>
                        <td>{{ $detail->inventory->vin }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{--Modal to confirm shipment deletion--}}
    @if(auth()->user()->role_id == 4)
        <div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLabel">Confirm shipment deletion</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="post" action="{{ url('/shipments/delete') . '/' . $shipment->id }}">
                        {{ csrf_field() }}
                        <div class="modal-body">
                            <h6>Request the authorization key from your warehouse's manager</h6>
                            <div class="form-group">
                                <label for="key" class="col-form-label">Key:</label>
                                <input type="text" class="form-control" id="key" name="key">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Confirm</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    {{--Modal for status update--}}
    @if(auth()->user()->role_id == 4)
        <div class="modal fade" id="statusUpdateModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLabel">Update shipment status</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="post" action="{{ url('/shipments/update') . '/' . $shipment->id }}">
                        {{ csrf_field() }}
                        <div class="modal-body">
                            <input type="text" id="flag" name="flag" readonly hidden>
                            <div class="form-group" id="info-input">
                                <label for="info" class="col-form-label">Enter additional info of status update:</label>
                                <input type="text" class="form-control" id="info" name="info">
                            </div>
                            <div class="form-group" id="departure-input">
                                <label for="departure" class="col-form-label">Enter new departure time:</label>
                                <input type="text" class="form-control" id="departure" name="departure">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Confirm</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    {{--Modal to complete shipment--}}
    @if(auth()->user()->role_id == 4)
        <div class="modal fade" id="finishModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Finish shipment</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="post" action="{{ url('/shipments/finish') }}">
                        @csrf
                        <div class="modal-body">
                            <input type="text" id="id" name="id" value="{{ $shipment->id }}" readonly hidden>
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
    @endif

@endsection

@section('script')
    <!-- Moment -->
    <script src="{{ asset('js/moment.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/bootstrap-datetimepicker.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('input#departure').datetimepicker();
            $('input#received-time').datetimepicker();

            $('#finishModal').on('show.bs.modal', function (event) {
            });

            $('#statusUpdateModal').on('show.bs.modal', function (event) {
                const button = $(event.relatedTarget); // Button that triggered the modal
                const flag = button.data('flag');
                // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
                // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
                const modal = $(this);
                const infoInput = modal.find('.modal-body div#info-input');
                const departureInput = modal.find('.modal-body div#departure-input');
                infoInput.hide();
                departureInput.hide();

                modal.find('.modal-body input#flag').val(flag);

                if (flag === 'cancel') {
                    modal.find('.modal-title').text('Mark shipment as cancelled');
                    infoInput.show();
                } else if (flag === 'delay') {
                    modal.find('.modal-title').text('Mark shipment as delayed');
                    infoInput.show();
                } else if (flag === 'ongoing') {
                    modal.find('.modal-title').text('Mark shipment as ongoing');
                    departureInput.show();
                }
            });
        })
    </script>
@endsection