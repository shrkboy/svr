@extends('layouts.app')

@section('navmenu')
    <ul class="navbar-nav mr-auto">
        @if(auth()->user()->id_role == 4)
            <li class="nav-item">
                <a href="{{ url('/shipments') }}" class="nav-link">Shipments</a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link disabled">Returned Items</a>
            </li>
        @endif
    </ul>
@endsection

@section('content')
    <div class="row mt-3">
        <div class="col-md m-auto">
            <h3 id="date"></h3>
            <h3 id="clock">Loading clock</h3>
        </div>
        <div class="col-md text-right m-auto">
            <a name="new-shipment" id="new-shipment" class="btn btn-primary" href="#" role="button">New shipment</a>
            <a name="return-items" id="return-items" class="btn btn-primary" href="#" role="button">Return items</a>
        </div>
    </div>

    <div class="mt-3 card p-3">
        <h3>Returned items</h3>
        <table class="table table-sm mt-3">
            <thead class="thead-inverse">
            <tr>
                <th>No</th>
                <th>Bike Model</th>
                <th>Engine Number</th>
                <th>From</th>
                <th>Info</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td scope="row"></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
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
@endsection

@section('script')
    <script src="{{ asset('js/clock-and-date.js') }}"></script>
@endsection
