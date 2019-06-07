@extends('layouts.app')

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
            <div class="col-sm-6">
                <p><a href="javascript:history.go(-1)" title="Return to the previous page" class="btn btn-danger">&laquo;
                        Go
                        back</a></p>
            </div>
            <div class="col-sm-6">
                <div class="dropdown text-right">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Options
                    </button>
                    <div class="dropdown-menu" aria-labelledby="options">
                        <a class="dropdown-item" href="{{ url('/shipments/report/'.$shipment->id) }}"
                           target="_blank">Print report</a>
                        @if(auth()->user()->role_id == 4)
                            <div class="dropdown-divider"></div>
                            @if($shipment->status != 'DONE')
                                <a class="dropdown-item" href="#">Mark as Delayed</a>
                                <a class="dropdown-item" href="#">Mark as Cancelled</a>
                            @endif
                            <button type="button" class="dropdown-item text-danger" data-toggle="modal"
                                    data-target="#confirmationModal">Delete
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <h3>Shipment history</h3>
        <div class="row">
            <div class="col-lg-3">
                Shipment ID: {{ sprintf('SHP%08d', $shipment->id) }} <br>
                Status: <span
                        class="font-weight-bold text-{{ $shipment->status == 'DONE' ? 'success' : ($shipment->status == 'ONGOING' ? 'primary' : ($shipment->status == 'CANCELLED' ? 'warning' : 'danger')) }}">{{ $shipment->status }}</span>
                <br>
                Destination: {{ $shipment->dealer->dlname }} <br>
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
@endsection

@section('script')
    <script src="clock-and-date.js"></script>
    <!--FontAwesome-->
    <script src="https://use.fontawesome.com/094c71b384.js"></script>
@endsection