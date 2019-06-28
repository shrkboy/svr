@extends('layouts.app')

@section('head-styles')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/select2-bootstrap4.min.css') }}">

    <!-- Bootstrap Date Time Picker -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap-datetimepicker.min.css') }}">
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
                    <input name="branch" id="branch" value="{{$dealer->dlname}}" class="form-control" readonly>
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
                    </select>
                </div>
                <div class="form-group">
                    <label for="color">Color</label>
                    <br>
                    <select name="color" id="color" class="form-control" style="width: 100%;" required>
                        <option value="" disabled selected>Select Color</option>
                        @foreach ($colors as $color)
                            <option value="{{$color->id}}">{{$color->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="spec">Specification</label>
                    <br>
                    <select name="spec" id="spec" class="form-control" style="width: 100%;" required>
                        <option value="" disabled selected>Select Specification</option>
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
    <!-- Custom -->
    <script src="{{ asset('js/clock-and-date.js') }}"></script>
    <!-- Select2 -->
    <script src="{{ asset('js/select2.full.min.js') }}"></script>
    <!-- Moment -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.21.0/moment.min.js" type="text/javascript"></script>
    <!--FontAwesome-->
    <script src="https://use.fontawesome.com/094c71b384.js"></script>
    <!-- Bootstrap Date Time Picker -->
    <!-- https://www.jqueryscript.net/time-clock/Date-Time-Picker-Bootstrap-4.html -->
    <script src="{{ asset('js/bootstrap-datetimepicker.min.js') }}"></script>
    <!-- Inline -->
    <script>

        $(document).ready(function () {
            // activate select2 to pick shipment destination
            $('#model').select2({
                width: '100%',
                theme: 'bootstrap4',
                placeholder: 'Select Model',
                minimumInputLength: 1,
                ajax: {
                    url: function (params) {
                        return '{{ url('/model') }}' + '/' + params.term;
                    },
                    delay: 250,
                    cache: true,
                    results: function (data) {
                        return {results: data};
                    },
                    processResults: function (data) {
                        return {
                            results: $.map(data, function (item) {
                                return {
                                    text: item.code,
                                    id: item.code
                                }
                            })
                        };
                    },
                },
            });

        });

    </script>
@endsection
