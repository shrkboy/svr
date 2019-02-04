@extends('layouts.app')

@section('head-script')
    <!-- Select2 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
@endsection

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
            {{--<h6 id="logs">Log here:</h6>--}}
            <form method="post" action="{{ url('/display') }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="branch">Select branch</label>
                    <br>
                    <select name="branch" id="branch" class="form-control">
                        <option></option>
                        @foreach($branches as $branch)
                            <option value="{{$branch->id}}">{{$branch->name}}</option>
                        @endforeach
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
                    @foreach($models as $model)
                        <tr>
                            <td scope="row">{{$model->name}}</td>
                            <td>
                                <input type="number" min=0 max=999 name="display-qty_{{$model->id}}" class="form-control"
                                       style="width: 100%">
                            </td>
                            <td>
                                <input type="number" min=0 max=999 name="talker_{{$model->id}}" class="form-control"
                                       style="width: 100%">
                            </td>
                            <td>
                                <input type="number" min=0 max=999 name="flyer_{{$model->id}}" class="form-control"
                                       style="width: 100%">
                            </td>
                            <td>
                                <input type="number" min=0 max=999 name="streamer_{{$model->id}}" class="form-control"
                                       style="width: 100%">
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <label for="photo">Photo</label>
                <input type="file" accept="image/*" name="photo" id="photo" class="form-control-file">
                <div class="text-right">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#branch').select2({
                placeholder: 'Select',
            });
        })
    </script>
@endsection