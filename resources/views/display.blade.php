@extends('layouts.app')

@section('head-script')
    <!-- Select2 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script src="{{ asset('js/dropzone.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
@endsection

@section('head-styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet"/>
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
            <a class="nav-link" href="{{url('/display')}}">Retail</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{url('/display')}}">Calendar</a>
        </li>
        @if(\Illuminate\Support\Facades\Auth::user()->is_admin)
            <li class="nav-item">
                <a class="nav-link" href="{{url('/admin')}}">Users</a>
            </li>
        @endif

    </ul>
@stop

@section('content')
    <div class="container-fluid">
        <div class="col-md-auto">
            <h4>Display</h4>
            <form method="post" action="{{ url('/display') }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="branch">Select branch</label>
                    <br>
                    <select name="branch" id="branch" class="form-control" style="width: 100%;">
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
                                <input type="text" name="id[]" value="{{ $model->id }}" readonly hidden>
                                <input type="number" min=0 max=999 name="display-qty_{{$model->id}}"
                                       class="form-control"
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
                <label class="h5" for="document">Documents</label>
                <input type="file" name="document[]" accept="application/pdf, image/*" id="document-input" class="form-control" multiple>
                <div id="file-list"></div>
                {{--TODO: Find alternative for Dropzone--}}
                {{--<div class="dropzone" hidden>--}}
                    {{--<button type="reset" id="clear-dropzone" class="btn btn-danger float-right">Clear</button>--}}
                    {{--<div class="fallback">--}}
                        {{--<input type="file">--}}
                    {{--</div>--}}
                {{--</div>--}}
                <div class="text-right mt-3">
                    <button type="submit" id="submit" class="btn btn-primary">Submit</button>
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

            $('#document-input').change(function() {
                let fileList = $('#file-list');
                let input = $('#document-input');
                fileList.innerHTML = '<ul>';
                for (let i = 0; i < input.files.length; ++i) {
                    fileList.innerHTML += '<li>' + input.files.item(i).name + '</li>';
                }
                fileList.innerHTML += '</ul>';
            });
        });

        {{--Dropzone.autoDiscover = false;--}}
        {{--$('.dropzone').dropzone({--}}
            {{--url: "{{ url('/display') }}",--}}
            {{--headers: {--}}
                {{--'X-CSRF-Token': $('meta[name="token"]').attr('content')--}}
            {{--},--}}
            {{--init: function () {--}}
                {{--let $this = this;--}}
                {{--$("button#clear-dropzone").click(function () {--}}
                    {{--$this.removeAllFiles(true);--}}
                {{--});--}}
            {{--},--}}
            {{--renameFile: function (file) {--}}
                {{--let dt = new Date();--}}
                {{--let time = dt.getTime();--}}
                {{--return time + file.name;--}}
            {{--},--}}
            {{--maxFiles: 20,--}}
            {{--uploadMultiple: true,--}}
            {{--paramName: 'document',--}}
            {{--addRemoveLinks: true,--}}
            {{--timeout: 180000,--}}
            {{--dictDefaultMessage: "<span class='text-primary h5'>Drag images here or click to select files</span> ",--}}
            {{--dictRemoveFile: 'Remove',--}}
            {{--autoProcessQueue: false,--}}
            {{--dictResponseError: 'Error uploading file!',--}}
            {{--acceptedFiles: 'image/*,application/pdf',--}}
            {{--accept: function (file, done) {--}}
                {{--done();--}}
            {{--},--}}
            {{--sending: function (file, xhr, formData) {--}}
                {{--// Pass token. You can use the same method to pass any other values as well such as a id to associate the image with for example.--}}
                {{--formData.append("_token", $('[name=_token]').val()); // Laravel expect the token post value to be named _token by default--}}
            {{--},--}}
            {{--beforeSend: function (request) {--}}
                {{--return request.setRequestHeader('X-CSRF-Token', $("meta[name='token']").attr('content'));--}}
            {{--},--}}
        {{--});--}}
    </script>
@endsection