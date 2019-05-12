@extends('layouts.app')

@section('navmenu')
    <ul class="navbar-nav mr-auto">
        @if(auth()->user()->id_role == 4)
            <li class="nav-item">
                <a href="{{ url('/shipments') }}" class="nav-link disabled">Shipments</a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">Returned Items</a>
            </li>
        @endif
    </ul>
    <div class="form-inline my-2 my-lg-0">
        <a class="btn btn-link my-2 my-sm-0" href="#">Logout</a>
    </div>
@endsection

@section('content')
    <div class="container-fluid">

        <div class="row mt-3">
            <div class="col-md m-auto">
                <h3 id="date"></h3>
                <h3 id="clock">Loading clock</h3>
            </div>
            <div class="col-md text-right m-auto">
                <a name="new-shipment" id="new-shipment" class="btn btn-primary" href="{{ url('/shipments/new') }}" role="button">New shipment</a>
                <a name="return-items" id="return-items" class="btn btn-primary" href="#" role="button">Return items</a>
            </div>
        </div>

        <div class="mt-3 card p-3">
            <h3>Shipment history</h3>
            <table class="table table-sm mt-3">
                <thead class="thead-inverse">
                <tr>
                    <th>No</th>
                    <th>Departure</th>
                    <th>Destination</th>
                    <th>Status</th>
                    <th>Arrival</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                {{ $i = 1 }}
                @foreach($shipments as $shipment)
                    <tr>
                        <td scope="row">{{ $i }}</td>
                        <td>{{ $shipment->depart_time }}</td>
                        <td>{{ $shipment->dealer()->where('id', $shipment->dealer_id) }}</td>
                        <td>{{ $shipment->status }}</td>
                        <td>{{ $shipment->received_time }}</td>
                        <td><a href="#" class="btn btn-link">Details</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <nav>
                <ul class="pagination" id="pagination">
                    <li class="page-item">
                        <a class="page-link" href="#" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item">
                        <a class="page-link" href="#" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
            </nav>

        </div>

    </div>
@endsection

@section('script')
    <script src="{{ asset('js/clock-and-date.js') }}"></script>
@endsection
