@extends('eis.app')

@section('content')
    <div class="row">
        <div class="col-md-5">
            <div class="card">
                <div class="card-header bg-white">
                    <div class="row align-items-center">
                        <div class="col-md-9">
                            <h5 class="card-title text-muted mb-0" style="font-weight: bold">Dealers Status this Month</h5>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="col-md-auto mb-3">
                    <table id="dealers" class="table table-striped table-bordered table-light hover" style="width: 100%">
                        <thead>
                        <tr>
                            <th style="width: 5%;">No</th>
                            <th scope="col">Branch</th>
                            <th scope="col">Name</th>
                            <th scope="col">Date and Time</th>
                            <th scope="col">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php
                            $i = 1;
                        @endphp
                        @foreach($newDealer as $dealer)
                            <tr @if ($dealerStatus[$i-1]) class="bg-success" @endif>
                                <td>
                                    {{$i++}}
                                </td>
                                <td>
                                    {{$dealer->dlname}}
                                </td>
                                <td>@if($dealerStatus[$i-2]) {{$dealerStatus[$i-2]->users->name }} @endif</td>
                                <td>@if($dealerStatus[$i-2]){{ \Carbon\Carbon::parse($dealerStatus[$i-2]->record_date)->format('M d, Y H:i:s') }} @endif</td>
                                <td>
                                    @if ($dealerStatus[$i-2])
                                    <a href="{{ url('/reports/detaildealer/' . $dealer->id) }}"
                                       class="btn btn-outline-primary">See details</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <div class="card">
                <div class="card-header bg-white">
                    <div class="row align-items-center">
                        <div class="col-md-9">
                            <h5 class="card-title text-muted mb-0" style="font-weight: bold">All Report</h5>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="col-md-auto mb-3">
                        <label for="month">Filter by Month</label>
                        <form action="{{ url('/reports') }}" method="get" class="form-inline">
                            <input id="month" name="month" type="month" class="form-control mr-2"
                                   value="{{ $filter }}">
                            <button type="submit" class="btn btn-primary">Filter</button>
                        </form>
                    </div>
                    <div class="col-md-auto mb-3">
                        <table id="reports" class="table table-striped table-bordered table-light hover" style="width: 100%">
                            <thead>
                            <tr>
                                <th style="width: 5%;">No</th>
                                <th scope="col">Branch</th>
                                <th scope="col">Name</th>
                                <th scope="col">Date and Time</th>
                                <th scope="col">Files Count</th>
                                <th scope="col">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php
                                $i = 1;
                            @endphp
                            @foreach($reports as $data)
                                <tr>
                                    <td>
                                        {{$i++}}
                                    </td>
                                    <td>
                                        {{$data->branches->dlname}}
                                    </td>
                                    <td>{{$data->users->name }}</td>
                                    <td>{{ \Carbon\Carbon::parse($data->record_date)->format('M d, Y H:i:s') }}</td>
                                    <td>{{ $data->documents->count() }}</td>
                                    <td>
                                        <a href="{{ url('/reports/detail/' . $data->id) }}"
                                           class="btn btn-outline-primary">See details</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.bundle.js" charset="utf-8"></script>
    <script>
        $(document).ready( function () {
            $('#dealers').DataTable();
            $('#reports').DataTable({
                "searching": false,
            });
        } );
    </script>
@endsection
