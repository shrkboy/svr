@extends('layouts.app')

@section('head-styles')
    <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('css/select2-bootstrap4.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('css/dropzone.css') }}" rel="stylesheet"/>
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
            <a class="nav-link" href="{{url('/retailreport')}}">Retail</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{url('/display')}}">Calendar</a>
        </li>
        @if(auth()->user()->is_admin)
            <li class="nav-item">
                <a class="nav-link" href="{{url('/users')}}">Users</a>
            </li>
        @endif
    </ul>
@stop

@section('content')
    <div class="container-fluid">
        <div class="col-md-auto">
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
            <h4>Display</h4>
            <form method="post" action="{{ url('/display') }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="branch">Select branch</label>
                    <br>
                    <select name="branch" id="branch" class="form-control">
                    </select>
                </div>
                <div class="table-responsive">
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
                                <td scope="row">{{$model->code}}</td>
                                <td>
                                    <input type="text" name="code[]" value="{{ $model->code }}" readonly hidden>
                                    <input type="number" min=0 max=999 name="display-qty_{{$model->code}}"
                                           class="form-control"
                                           style="width: 100%">
                                </td>
                                <td>
                                    <input type="number" min=0 max=999 name="talker_{{$model->code}}"
                                           class="form-control"
                                           style="width: 100%">
                                </td>
                                <td>
                                    <input type="number" min=0 max=999 name="flyer_{{$model->code}}"
                                           class="form-control"
                                           style="width: 100%">
                                </td>
                                <td>
                                    <input type="number" min=0 max=999 name="streamer_{{$model->code}}"
                                           class="form-control"
                                           style="width: 100%">
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <label class="h5" for="document">Documents</label>
                <input type="file" name="document[]" accept="image/*" id="document-input" class="form-control"
                       multiple>
                <div id="file-list"></div>
                <div class="text-right mt-3">
                    <button type="submit" id="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <!-- Select2 -->
    <script src="{{ asset('js/select2.min.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#branch').select2({
                width: '100%',
                theme: 'bootstrap4',
                placeholder: 'Select',
                minimumInputLength: 1,
                ajax: {
                    url: function (params) {
                        return '{{ url('/branch') }}' + '/' + params.term;
                    },
                    dataType: 'json',
                    type: 'GET',
                    processResults: function (data) {
                        return {
                            results: $.map(data, function (item) {
                                return {
                                    text: item.dlname,
                                    id: item.id
                                }
                            })
                        };
                    }                },
            });
            $('#document-input').change(function () {
                let fileList = $('#file-list');
                let input = $('#document-input');
                fileList.innerHTML = '<ul>';
                for (let i = 0; i < input.files.length; ++i) {
                    fileList.innerHTML += '<li>' + input.files.item(i).name + '</li>';
                }
                fileList.innerHTML += '</ul>';
            });
        });
    </script>
@endsection