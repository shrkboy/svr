@extends('layouts.app')

@section('head-styles')
    <link rel="stylesheet" href="{{ asset('css/font-awesome.css') }}">
@endsection

@section('navmenu')
    <ul class="navbar-nav mr-auto">
        @if(auth()->user()->role_id == 5)
            <li class="nav-item">
                <a href="{{ route('dashboard.warehouse') }}" class="nav-link">Dashboard</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('dashboard.warehouse.auth_key') }}" class="nav-link active">Auth key</a>
            </li>
        @endif
        @if(auth()->user()->role_id == 4 || auth()->user()->role_id == 5)
            <li class="nav-item">
                <a href="{{ route('shipments.index') }}" class="nav-link">Shipments</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('returned_items.index') }}" class="nav-link">Returned Items</a>
            </li>
        @endif
    </ul>
@endsection


@section('content')
    <div class="row">
        <div class="col-md m-auto">
            <h3 id="date">Loading date</h3>
            <h3 id="clock">Loading clock</h3>
            <h3>
                Logged in to {{ auth()->user()->warehouse->name }} as {{ auth()->user()->name }}
                <span class="text-primary">{{ auth()->user()->role_id == 5 ? ' (manager)' : '' }}</span>
            </h3>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-xl-4 m-auto" id="authKey">
            <div class="card">
                <div class="card-header">
                    Manager auth key
                </div>
                <div class="card-body text-center">
                    <div id="result">
                        <div class="input-group">
                            <input type="text" class="form-control" id="key" readonly>
                            <div class="input-group-append">
                                <button type="button" class="btn btn-primary" id="copy">
                                    <span class="fa fa-copy"></span>
                                </button>
                                <button type="button" class="btn btn-secondary" id="auth-key-btn">
                                    <span class="fa fa-redo"></span>
                                </button>
                            </div>
                        </div>
                        <small class="form-text text-muted text-left" id="info-text"></small>
                    </div>
                    <h5 id="error-message"></h5>
                    <div class="spinner-border text-primary" id="spinner" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('js/clock-and-date.js') }}"></script>
    <script src="{{ asset('js/moment.min.js') }}"></script>
    <script>

        // auth key card
        $(document).ready(function () {
            const result = $('div#result');
            const keyText = $('input#key');
            const errorMessage = $('h5#error-message');
            const spinner = $('div#spinner');
            errorMessage.hide();
            spinner.hide();

            $('button#copy').click(function () {
                keyText.select();
                document.execCommand('copy');
                $('small#info-text').text('Copied to clipboard!');
            });

            $('button#auth-key-btn').click(function () {
                    result.hide();
                    $('small#info-text').text('');
                    errorMessage.hide();
                    spinner.show();

                    $.ajax({
                        method: 'GET',
                        url: '{{ route('generateKey') }}',
                        dataType: 'text',
                    }).done(function (data) {
                        const newKey = data;
                        console.log('Key fetched: ' + data);
                        const updateData = {
                            'type': 'warehouse',
                            'key': data
                        };
                        $.ajaxSetup({
                            headers:
                                {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
                        });
                        $.ajax({
                            url: '{{ url('/key/update') }}' + '/' + '{{ auth()->user()->warehouse_id }}',
                            method: 'POST',
                            data: updateData,
                        }).done(function () {
                            spinner.hide();
                            console.log('Key updated successfully');
                            keyText.val(newKey);
                            result.show();
                            setTimeout(function () {
                                keyText.val('');
                                $('small#info-text').text('');
                            }, 5000)
                        }).fail(function (jqXHR, textStatus, errorThrown) {
                            spinner.hide();
                            // Log the error to the console
                            console.error(
                                "The following error occurred: " +
                                textStatus, errorThrown
                            );
                            errorMessage.text('Something went wrong<br>' + errorThrown);
                            errorMessage.show();
                        });
                    })
                }
            )
        })
    </script>
@endsection