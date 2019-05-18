@extends('layouts.app')

@section('head-script')
    <!-- Select2 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
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
        <li class="nav-item">
            <a class="nav-link" href="{{url('/display')}}">Display</a>
        </li>
        <li class="nav-item active">
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
    <div class="container">
        <div class="col-md-auto">
            <h4>Add Retail Report</h4>
            <form method="post" action="{{ url('/retail') }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="branch">Branch</label>
                    <br>
                    <select name="branch" id="branch" class="form-control" style="width: 100%;" required>
                    </select>
                </div>
                <div class="form-group">
                    <label for="date">Date</label>
                    <br>
                    <input name="date" id="date" value="{{$date}}" class="form-control" readonly>
                </div>
                <div class="form-group">
                    <label for="model">Model</label>
                    <br>
                    <select name="model" id="model" class="form-control" style="width: 100%;" required>
                        <option value="" disabled selected>Selct Model</option>
                        @foreach ($models as $model)
                            <option value={{$model->code}}>{{$model->code}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="color">Color</label>
                    <br>
                    <select name="color" id="color" class="form-control" style="width: 100%;" required>
                        <option value="" disabled selected>Selct Color</option>
                        @foreach ($colors as $color)
                            <option value="{{$color->id}}">{{$color->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="spec">Specification</label>
                    <br>
                    <select name="spec" id="spec" class="form-control" style="width: 100%;" required>
                        <option value="" disabled selected>Selct Specification</option>
                        @foreach ($specs as $spec)
                            <option value="{{$spec->id}}">{{$spec->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="in">In</label>
                    <br>
                    <input type="number" id="in" name="in" min="0" max="10000" class="form-control">
                </div>
                <div class="form-group">
                    <label for="retail">Retail</label>
                    <br>
                    <input type="number" id="retail" name="retail" min="0" max="10000" class="form-control">
                </div>
                <div class="form-group">
                    <label for="remarks">Remarks</label>
                    <br>
                    <textarea id="remarks" name="remarks" class="form-control"></textarea>
                </div>
                <div class="form-group">
                    <div class="text-right mt-3">
                        <button type="submit" id="submit read" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#branch').select2({
                placeholder: 'Select Branch',
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

        $(document).ready(function(){

            // Initialize select2
            $("#model").select2();

            // Read selected option
            $('#read').click(function(){
                var code = $('#model option:selected').text();
                var id = $('#model option:selected').text();


            });
        });
    </script>
@endsection
