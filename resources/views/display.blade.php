@extends('layouts.app')

@section('navmenu')
    <ul class="navbar-nav mr-auto">
        <li class="nav-item">
            <a class="nav-link" href="{{url('/display')}}">Home</a>
        </li>
        <li class="nav-item active">
            <a class="nav-link" href="{{url('/display')}}">Display</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{url('/display')}}">Retail</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{url('/display')}}">Calendar</a>
        </li>
    </ul>
@stop

@section('content')
    <div class="container-fluid">
        <div class="col-md-auto">
            <h4>Display</h4>
            <form>
                <div class="form-group">
                    <label for="branch">Select branch</label>
                    <select name="branch" id="branch" class="form-control">
                        <option hidden selected value="null">Select...</option>
                        <option value="">Branch #1</option>
                        <option value="">Branch #2</option>
                        <option value="">Branch #3</option>
                    </select>
                </div>
                <table class="table table-striped" style="table-layout: fixed">
                    <thead>
                    <tr>
                        <th scope="col">Models</th>
                        <th scope="col">Display Qty</th>
                        <th scope="col">Talker</th>
                        <th scope="col">Flyer</th>
                        <th scope="col">Streamer</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td scope="row">Model name</td>
                        <td>
                            <input type="number" min=0 max=999 name="display-qty" class="form-control" style="width: 100%">
                        </td>
                        <td>
                            <input type="number" min=0 max=999 name="talker" class="form-control" style="width: 100%">
                        </td>
                        <td>
                            <input type="number" min=0 max=999 name="flyer" class="form-control" style="width: 100%">
                        </td>
                        <td>
                            <input type="number" min=0 max=999 name="streamer" class="form-control" style="width: 100%">
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="text-right">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection
