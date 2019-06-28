@extends('layouts.app')

@section('head-styles')

@endsection

@section('navmenu')
    <ul class="navbar-nav mr-auto">
        @if(auth()->user()->role_id == 3)
        <li class="nav-item">
            <a class="nav-link" href="{{url('/display')}}">Home</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{url('/display')}}">Display</a>
        </li>
        @endif
        @if(auth()->user()->role_id == 2)
        <li class="nav-item">
            <a class="nav-link" href="{{url('/retaildashboard')}}">Dashboard</a>
        </li>
        @endif
        <li class="nav-item active">
            <a class="nav-link" href="{{url('/retailreport')}}">Retail</a>
        </li>
        @if(auth()->user()->is_admin)
            <li class="nav-item">
                <a class="nav-link" href="{{url('/users')}}">Users</a>
            </li>
        @endif
    </ul>
@stop

@section('content')
    <div class="row">
        <div class="col-md m-auto">
            <h3 id="date">Loading date</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-md m-auto">
            <h3 id="clock">Loading clock</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 m-auto">
            <h3>
                Logged in from {{$dealer->dlname}} as {{auth()->user()->name}} ({{$role->name}})
            </h3>
        </div>
        <div class="col-md-6 text-right m-auto">
            @if(auth()->user()->role_id == 3)
            <a href="{{url('/addretailreport')}}" class="btn btn-primary">Add Retail Report</a>
            @endif
        </div>
    </div>

    <div class="mt-3 card p-3">
        <div class="col-md-auto">
           <h3>Retail Monthly Report</h3>

            <div class="table-responsive mt-3">
                <table id="report-table" class="table table-striped table-sm display" style="table-layout: fixed">
                    <thead class="thead-inverse">
                    <tr>
                        <th width="2.5%">#</th>
                        <th scope="col">ID</th>
                        <th scope="col">Date</th>
                        <th scope="col">Bike Model</th>
                        <th scope="col">Color</th>
                        <th scope="col">Specification</th>
                        <th scope="col">Restock</th>
                        <th scope="col">Sold</th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($retailreports as $retailreport)
                        <tr>
                            <td>{{$num++}}</td>
                            <td>{{sprintf('REP%08d', $retailreport->id)}}</td>
                            <td>{{date("m/d/Y", strtotime($retailreport->input_date))}}</td>
                            <td>{{$retailreport->bikemodel_code}}</td>
                            <td>{{$retailreport->cname}}</td>
                            <td>{{$retailreport->sname}}</td>
                            <td>{{$retailreport->restock_amount}}</td>
                            <td>{{$retailreport->retail_amount}}</td>
                            <td scope="row">
                                <div class="text-right">
                                    <a href="#ex{{$num}}" rel="modal:open" class="btn btn-primary">Detail</a>
                                    @if(auth()->user()->role_id == 3)
                                    <a href="{{url('/edit/'.$retailreport->id)}}" class="btn btn-secondary">Edit</a>
                                    @endif
                                </div>
                            </td>
                        </tr>

                        <!-- Modal -->
                        <div id="ex{{$num}}" class="modal">
                            <form>
                                <h4>Report Detail</h4>
                                <div class="form-group">
                                    <label for="retail">ID</label>
                                    <br>
                                    <input value="{{sprintf('REP%08d', $retailreport->id)}}" class="form-control" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="retail">Date Created</label>
                                    <br>
                                    <input value="{{date("m/d/Y", strtotime($retailreport->input_date))}}" class="form-control" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="retail">Model Type</label>
                                    <br>
                                    <input value="{{$retailreport->bikemodel_code}}" class="form-control" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="retail">Color</label>
                                    <br>
                                    <input value="{{$retailreport->cname}}" class="form-control" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="retail">Specification</label>
                                    <br>
                                    <input value="{{$retailreport->sname}}" class="form-control" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="retail">Last Inventory</label>
                                    <br>
                                    <input value="{{$retailreport->last_inventory}}" class="form-control" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="retail">Restock</label>
                                    <br>
                                    <input value="{{$retailreport->restock_amount}}" class="form-control" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="retail">Sold</label>
                                    <br>
                                    <input value="{{$retailreport->retail_amount}}" class="form-control" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="retail">Updated Inventory</label>
                                    <br>
                                    <input value="{{$retailreport->updated_inventory}}" class="form-control" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="retail">Remarks</label>
                                    <br>
                                    <input value="{{$retailreport->remarks}}" class="form-control" readonly>
                                </div>
                                <div class="form-group">
                                    <div class="text-right">
                                        <a href="#" rel="modal:close" class="btn btn-primary">Close</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>



@endsection

@section('script')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css"/>

    <script src="http://code.jquery.com/jquery-2.0.3.min.js" data-semver="2.0.3" data-require="jquery"></script>

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
    <link rel="stylesheet" type="text/css" href="/DataTables/datatables.css">
    <script type="text/javascript" charset="utf8" src="/DataTables/datatables.js"></script>

    <script src="{{ asset('js/clock-and-date.js') }}"></script>

    <script type="text/javascript">
        $(document).ready( function () {
            $('#report-table').DataTable({
                "paging": true,
                "pageLength": 10
            });

        } );
    </script>
@endsection
