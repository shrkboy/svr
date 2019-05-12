@extends('layouts.app')

@section('head-styles')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/select2-bootstrap4.min.css') }}">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Bootstrap Date Time Picker -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap-datetimepicker.min.css') }}">
@endsection

@section('content')
    <div class="container-fluid">

        <div class="mt-3 card p-3">
            <form method="POST" action="#">
                <h3>New shipment</h3>

                <div class="p-2">
                    <div class="form-group row">
                        <label for="destination" class="col-sm-2 col-form-label">Destination</label>
                        <div class="col-lg-4">
                            <select class="form-control" name="destination" id="destination" required>
                                <option></option>
                                <option value="1">Calamba</option>
                                <option value="2">Manila</option>
                                <option value="3">Nuvali</option>
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

                    <div id="detail" class="container-fluid mt-3">
                        <div id="detail-form">
                            <hr>
                            <div id="detail-1">
                                <div class="row">
                                    <h5 class="col-lg-1">1</h5>
                                    <div id="input-bike-1" class="col-lg row">
                                        <div class="form-group col-lg-3">
                                            <label for="bike-model-1">Bike model</label>
                                            <select class="form-control detail-input" type="select" name="bike-model-1"
                                                    id="bike-model-1">
                                                <option></option>
                                                <option value="1">Type 1</option>
                                                <option value="2">Type 2</option>
                                                <option value="3">Type 3</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-lg-2">
                                            <label for="amount-1">Amount</label>
                                            <input class="form-control" type="number" name="amount-1" id="amount-1"
                                                   min="0" value="0">
                                        </div>
                                        <div id="input-vin" class="col-lg-12 row">
                                            <h6 class="col-lg-1">VINs</h6>
                                            <div id="input-vin-1" class="col-lg row"></div>
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

                    <div class="text-right mt-3">
                        <button type="submit" class="btn btn-lg btn-success">Submit</button>
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
    <script src="{{ asset('js/select2.min.js') }}"></script>
    <!-- Moment -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.21.0/moment.min.js" type="text/javascript"></script>
    <!-- Bootstrap Date Time Picker -->
    <!-- https://www.jqueryscript.net/time-clock/Date-Time-Picker-Bootstrap-4.html -->
    <script src="{{ asset('js/bootstrap-datetimepicker.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            $("#destination").select2({
                placeholder: 'Select branch destination',
                width: '100%',
                theme: 'bootstrap4'
            });

            $("#bike-model-1").select2({
                placeholder: 'Select bike model',
                width: '100%',
                theme: 'bootstrap4'
            });

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

            var counter = 1;

            function detailInputHTML(counter) {
                return '<div id="detail-' + counter + '">' +
                    '<div class="row">' +
                    '<h5 class="col-lg-1">' + counter + '</h5>' +
                    '<div id="input-bike-' + counter + '" class="row col-lg">' +
                    '<div class="form-group col-lg-3">' +
                    '<label for="bike-model-' + counter + '">Bike model</label>' +
                    '<select class="form-control detail-input" type="select" name="bike-model-' + counter + '" id="bike-model-' + counter + '">' +
                    '<option></option><option value="1">Type 1</option><option value="2">Type 2</option><option value="3">Type 3</option>' +
                    '</select>' +
                    '</div>' +
                    '<div class="form-group col-lg-2">' +
                    '<label for="amount-' + counter + '">Amount</label>' +
                    '<input class="form-control" type="number" name="amount-' + counter + '" id="amount-' + counter + '" min="0" value="0">' +
                    '</div>' +
                    '<div class="row col-lg-12">' +
                    '<h6 class="col-lg-1">VINs</h6>' +
                    '<div id="input-vin-' + counter + '" class="col-lg row"></div>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '<hr>' +
                    '</div>'
            }

            $("a#add-detail").click(function () {
                if (counter >= 0) {
                    counter++;
                    $("div#detail-form").append(detailInputHTML(counter));
                    $("input#amount-" + counter).change(function () {
                        console.log(this.value);
                    });

                    $("input#amount-" + counter).change(function () {
                        $("#input-vin-" + counter).empty();
                        for (var i = 0; i < this.value; i++) {
                            $("#input-vin-" + counter).append('<input type="text" name="vin-' + counter + '-' + i + '" class="form-control col-lg-3">');
                        }
                    });
                    $("#bike-model-" + counter).select2({
                        placeholder: 'Select bike model',
                        width: '100%',
                        theme: 'bootstrap4'
                    });
                }
            });

            $("a#remove-detail").click(function () {
                if (counter > 0) {
                    $("div#detail-" + counter).remove();
                    counter--;
                }
            });

            $("input#amount-1").change(function () {
                $("#input-vin-1").empty();
                for (var i = 0; i < this.value; i++) {
                    $("#input-vin-1").append('<input type="text" name="vin-1-' + (i + 1) + '" class="form-control col-lg-3">')
                }
            });
        });
    </script>
@endsection