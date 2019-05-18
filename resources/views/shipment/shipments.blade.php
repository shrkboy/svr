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
                <h3 id="date"></h3>
                <h3 id="clock">Loading clock</h3>
            </div>
            <div class="col-md text-right m-auto">
                <a name="new-shipment" id="new-shipment" class="btn btn-primary" href="{{ url('/shipments/new') }}"
                   role="button">New shipment</a>
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
                @foreach($shipments as $key=>$shipment)
                    <tr>
                        <td scope="row">{{ ++$key }}</td>
                        <td>{{ $shipment->depart_time }}</td>
                        <td>{{ $shipment->dealer->dlname }}</td>
                        <td>{{ $shipment->status }}</td>
                        <td>{{ $shipment->received_time }}</td>
                        <td><a href="{{ url('/shipments/detail/'.$shipment->id) }}" class="btn btn-link">Details</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <nav class="align-self-center mt-3">
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
