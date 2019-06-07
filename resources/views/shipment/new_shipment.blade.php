@extends('layouts.app')

@section('head-styles')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/select2-bootstrap4.min.css') }}">

    <!-- Bootstrap Date Time Picker -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap-datetimepicker.min.css') }}">
@endsection

@section('content')
    <div class="card p-3">
        <form method="POST" action="{{ route('shipments.store') }}" enctype="multipart/form-data">
            {{ csrf_field() }}
            <h3 class="mmc-title">New shipment</h3>

            <div class="p-2">
                <div class="form-group row">
                    <label for="destination" class="col-sm-2 col-form-label">Destination</label>
                    <div class="col-lg-4">
                        <select class="form-control" name="destination" id="destination" required>
                            <option></option>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="departure" class="col-sm-2 col-form-label">Departure time</label>
                    <div class="col-lg-4">
                        <input type="text" class="form-control" name="departure" id="departure" required
                               placeholder="Click to select date and time">
                    </div>
                </div>

                <h5>Shipment detail data</h5>

                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="use-spreadsheet" id="use-spreadsheet"
                           name="use-spreadsheet">
                    <label class="form-check-label" for="use-spreadsheet">
                        Use spreadsheet file
                    </label>
                </div>

                <div class="form-group row" id="spreadsheet-upload">
                    <label for="spreadsheet-input" class="col-sm-2 col-form-label">File</label>
                    <div class="col-lg-4">
                        <div class="custom-file">
                            <input type="file" id="spreadsheet" class="custom-file-input" name="spreadsheet"
                                   accept=".csv, application/vnd.ms-excel, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet">
                            <label for="spreadsheet" class="custom-file-label">
                                Choose shipment spreadsheet file (.csv, .xls, or .xlsx)
                            </label>
                        </div>
                    </div>
                </div>

                <div id="detail" class="mt-3">
                    <div id="detail-form">
                        <hr>
                        <div id="detail-1">
                            <div class="row">
                                <h5 class="col-lg-1">1</h5>
                                <div id="input-bike-1" class="col-lg row">
                                    <div class="form-group col-lg-4">
                                        <label for="bike-model-1">Bike model</label>
                                        <select class="form-control detail-input" type="select" name="bike-model-1"
                                                id="bike-model-1">
                                            <option></option>
                                        </select>
                                    </div>
                                    <div class="form-group col-lg-2">
                                        <label for="amount-1">Amount</label>
                                        <input class="form-control" type="number" name="amount-1" id="amount-1"
                                               min="0" value="0">
                                    </div>
                                    <div id="input-vin" class="col-lg-12 row">
                                        <h6 class="col-lg-1">VINs</h6>
                                        <div id="input-vin-1" class="col-lg"></div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                        </div>
                    </div>

                    <div id="add-remove" class=" text-right mt-3">
                        <a id="add-detail" class="mr-2 text-primary " title="Add bike model"><i
                                    class="fa fa-plus-square fa-2x"
                                    aria-hidden="true"></i></a>
                        <a id="remove-detail" class="text-danger" title="Remove bike model"><i
                                    class="fa fa-minus-square fa-2x"
                                    aria-hidden="true"></i></a>
                    </div>
                </div>

                <input type="text" name="counter" id="counter" readonly hidden>

                <div class="text-right mt-3">
                    <button type="submit" class="btn btn-lg btn-success">Submit</button>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('script')
    <!-- Custom -->
    <script src="{{ asset('js/clock-and-date.js') }}"></script>
    <!-- Select2 -->
    <script src="{{ asset('js/select2.full.min.js') }}"></script>
    <!-- Moment -->
    <script src="{{ asset('js/moment.min.js') }}" type="text/javascript"></script>
    <!--FontAwesome-->
    <script src="https://use.fontawesome.com/094c71b384.js"></script>
    {{--<script defer src="https://use.fontawesome.com/releases/v5.8.2/js/all.js"--}}
    {{--integrity="sha384-DJ25uNYET2XCl5ZF++U8eNxPWqcKohUUBUpKGlNLMchM7q4Wjg2CUpjHLaL8yYPH"--}}
    {{--crossorigin="anonymous"></script>--}}
    <!-- Bootstrap Date Time Picker -->
    <!-- https://www.jqueryscript.net/time-clock/Date-Time-Picker-Bootstrap-4.html -->
    <script src="{{ asset('js/bootstrap-datetimepicker.min.js') }}"></script>
    <!-- Inline -->
    <script>
        $(document).ready(function () {
            // activate select2 to pick shipment destination
            $('#destination').select2({
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

            function setBikeModelDropdown(counter) {
                $("#bike-model-" + counter).select2({
                    {{--data: '{{ $bike_models }}',--}}
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
            }

            $("#departure").datetimepicker();
            $("#spreadsheet-upload").hide();
            $("#use-spreadsheet").change(function () {
                if (this.checked) {
                    $("#spreadsheet-upload").show();
                    $("#detail").hide()
                } else {
                    $("#spreadsheet-upload").hide();
                    $("#detail").show()
                }
            });

            function detailInputHTML(counter) {
                return '<div id="detail-' + counter + '">' +
                    '<div class="row">' +
                    '<h5 class="col-lg-1">' + counter + '</h5>' +
                    '<div id="input-bike-' + counter + '" class="row col-lg">' +
                    '<div class="form-group col-lg-4">' +
                    '<label for="bike-model-' + counter + '">Bike model</label>' +
                    '<select class="form-control detail-input" type="select" name="bike-model-' + counter + '" id="bike-model-' + counter + '">' +
                    '<option></option>' +
                    '</select>' +
                    '</div>' +
                    '<div class="form-group col-lg-2">' +
                    '<label for="amount-' + counter + '">Amount</label>' +
                    '<input class="form-control" type="number" name="amount-' + counter + '" id="amount-' + counter + '" min="0" value="0">' +
                    '</div>' +
                    '<div class="row col-lg-12">' +
                    '<h6 class="col-lg-1">VINs</h6>' +
                    '<div id="input-vin-' + counter + '" class="col-lg"></div>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '<hr>' +
                    '</div>'
            }

            function setVINInput(counter) {
                $("input#amount-" + counter).change(function () {
                    const divInputVin = $("div#input-vin-" + counter);
                    divInputVin.empty();
                    for (var i = 0; i < this.value; i++) {
                        divInputVin.append('<div class="row" id="div-vin-' + counter + '-' + (i + 1) + '">' +
                            '<input type="text" name="vin-' + counter + '-' + (i + 1) + '" id="vin-' + counter + '-' + (i + 1) + '" class="form-control col-md-4">' +
                            '<div class="col-md-2">' +
                            '<i class="m-auto fa fa-2x mr-2" id="mark-' + counter + '-' + (i + 1) + '"></i>' +
                            '</div>' +
                            '</div>'
                        );
                        $("input#vin-" + counter + "-" + (i + 1)).on('input',
                            function () {
                                const input = $(this);
                                const mark = $(this).next().children();
                                $.ajax({
                                    url: '{{ url('/inventory/validate') }}' + '/' + $('#bike-model-' + counter).val() + '/' + input.val(),
                                    dataType: "json",
                                    success: function (data) {
                                        if (!$.isEmptyObject(data) && data[0].status === 'IN') {
                                            input.removeClass("is-invalid").addClass("is-valid");
                                            mark.removeClass("fa-times text-danger").addClass("fa-check text-success");
                                        } else {
                                            input.removeClass("is-valid").addClass("is-invalid");
                                            mark.removeClass("fa-check text-success").addClass("fa-times text-danger");
                                        }
                                    },
                                })
                            }
                        )
                    }
                });
            }

            var counter = 1;
            $('#counter').val(counter);
            setBikeModelDropdown(counter);
            setVINInput(counter);

            $("a#add-detail").click(function () {
                if (counter >= 0) {
                    counter++;
                    $('#counter').val(counter);
                    $("div#detail-form").append(detailInputHTML(counter));

                    setBikeModelDropdown(counter);
                    setVINInput(counter)
                }
            });
            $("a#remove-detail").click(function () {
                if (counter > 0) {
                    $("div#detail-" + counter).remove();
                    counter--;
                    $('#counter').val(counter);
                }
            });
        });
    </script>
@endsection