@extends('layouts.app')

@section('head-styles')
    <link rel="stylesheet" href="{{ asset('css/font-awesome.css') }}">
    <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/select2-bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-datetimepicker.min.css') }}">
@endsection

@section('content')
    <div class="card p-3">
        <form method="POST" action="{{ route('returned_items.store') }}">
            {{  csrf_field() }}
            <h3>Return items</h3>

            <div class="p-2">

                <div class="form-group row">
                    <label for="bike-model" class="col-sm-2 col-form-label">Bike Model</label>
                    <div class="col-lg-4">
                        <select class="form-control" name="bike-model" id="bike-model" required>
                            <option></option>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="vin" class="col-sm-2 col-form-label">VIN</label>
                    <div class="col-lg-4">
                        <input type="text" class="form-control" name="vin" id="vin" required placeholder="VIN">
                    </div>
                    <div class="col-lg-2">
                        <i class="m-auto fa fa-2x mr-2" id="mark"></i>
                        <small id="hint"></small>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="dealer" class="col-sm-2 col-form-label">Origin dealer</label>
                    <div class="col-lg-4">
                        <select class="form-control" name="dealer" id="dealer" required>
                            <option></option>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="time" class="col-sm-2 col-form-label">Time</label>
                    <div class="col-lg-4">
                        <input type="text" class="form-control" name="time" id="time" required
                               placeholder="Click to select date and time">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="info" class="col-sm-2 col-form-label">Info</label>
                    <div class="col-lg-4">
                        <textarea class="form-control" name="info" id="info" rows="3" required></textarea>
                    </div>
                </div>


                <!-- <div id="add-remove" class=" text-right mt-3">
                    <a id="add-detail" class="mr-2 text-primary " title="Add bike model"><i
                            class="fa fa-plus-square fa-2x" aria-hidden="true"></i></a>
                    <a id="remove-detail" class="text-danger" title="Remove bike model"><i
                            class="fa fa-minus-square fa-2x" aria-hidden="true"></i></a>
                </div> -->
            </div>

            <div class="text-right mt-3">
                <input type="submit" class="btn btn-success" value="Submit">
                {{--<input type="submit" class="btn btn-primary" value="Submit and enter another">--}}
            </div>

        </form>
    </div>
@endsection

@section('script')
    <script src="{{ asset('js/clock-and-date.js') }}"></script>
    <script src="{{ asset('js/select2.full.min.js') }}"></script>
    <script src="{{ asset('js/moment.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/bootstrap-datetimepicker.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('#dealer').select2({
                width: '100%',
                theme: 'bootstrap4',
                placeholder: 'Select',
                minimumInputLength: 1,
                ajax: {
                    url: function (params) {
                        return '{{ url('/branch') }}' + '/' + params.term;
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
                                    text: item.dlname,
                                    id: item.id
                                }
                            })
                        };
                    },
                },
            });

            $("select#bike-model").select2({
                width: '100%',
                theme: 'bootstrap4',
                placeholder: 'Select bike model',
                minimumInputLength: 1,
                ajax: {
                    url: function (params) {
                        return '{{ url('/bike_model/get') }}' + '/' + params.term;
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
                                    id: item.id,
                                    text: item.name,
                                    code: item.code,
                                    color: item.color,
                                    spec: item.spec
                                }
                            })
                        };
                    },
                },
                escapeMarkup: function (markup) {
                    return markup
                },
                templateResult: function (data) {
                    console.log(data);
                    if (!data.id) {
                        return data.text;
                    }
                    return $('<h5>' + data.text + '</h5>' +
                        '<p>' + data.code +
                        ' || ' + data.color +
                        ' || ' + data.spec + '</p>');
                },
            });

            $("input#vin").on('input',
                function () {
                    const input = $(this);
                    const mark = $('i#mark');
                    const hint = $('small#hint');
                    $.ajax({
                        url: '{{ url('/inventory/validate') }}' + '/' + $('#bike-model').val() + '/' + input.val(),
                        dataType: "json",
                        success: function (data) {
                            console.log(data[0].status);
                            if (!$.isEmptyObject(data) && data[0].status.localeCompare("IN") !== 0) {
                                input.removeClass("is-invalid").addClass("is-valid");
                                mark.removeClass("fa-times text-danger").addClass("fa-check text-success");
                                hint.removeClass('text-danger').addClass('text-success').text('Item found');
                            } else {
                                input.removeClass("is-valid").addClass("is-invalid");
                                mark.removeClass("fa-check text-success").addClass("fa-times text-danger");
                                hint.removeClass('text-success').addClass('text-danger').text('Item not found');
                            }
                        },
                    })
                }
            );

            $("#time").datetimepicker();
        })
    </script>
@endsection