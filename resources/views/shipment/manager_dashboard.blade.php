@extends('layouts.app')

@section('head-styles')
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/Chart.min.css') }}">
@endsection

@section('navmenu')
    <ul class="navbar-nav mr-auto">
        @if(auth()->user()->role_id == 5)
            <li class="nav-item">
                <a href="{{ route('dashboard.warehouse') }}" class="nav-link active">Dashboard</a>
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

    <div class="row container-fluid">
        <div class="col-xl-6 mt-3" id="shipmentsLastSixMonths">
            <div class="card">
                <div class="card-header">
                    Shipment analytics
                </div>
                <div class="card-body">
                    <canvas id="shipmentsLastSixMonthsChart" height="150"></canvas>
                </div>
            </div>
        </div>
        <div class="col-xl-6 mt-3" id="bikeModelShippedThisMonth">
            <div class="card">
                <div class="card-header">
                    Motorcycles shipped this month
                </div>
                <div class="card-body">
                    <canvas id="bikeModelShippedThisMonthChart" height="150"></canvas>
                </div>
            </div>
        </div>
        <div class="col-xl-3 mt-3" id="returnsLastSixMonths">
            <div class="card">
                <div class="card-header">
                    Returns in last 6 months
                </div>
                <div class="card-body">
                    <canvas id="returnsLastSixMonthsChart" height="200"></canvas>
                </div>
            </div>
        </div>
        <div class="col-xl-3 mt-3" id="authKey">
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
                                    <span class="fa fa-clipboard"></span>
                                </button>
                                <button type="button" class="btn btn-secondary" id="auth-key-btn">
                                    <span class="fa fa-refresh"></span>
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
    <script src="{{ asset('js/Chart.bundle.min.js') }}"></script>
    <script src="{{ asset('js/moment.min.js') }}"></script>
    <!--FontAwesome-->
    <script src="https://use.fontawesome.com/094c71b384.js"></script>
    <script>
        // Chart data
        const shipmentAmount = @json($shipmentAmount);
        const bikeShipped = @json($bikeShipped);
        const returnAmount = @json($returnAmount);
        const bikeModelShipped = @json($bikeModelShipped);

        // Create chart
        const shipmentAmountChart = new Chart($('canvas#shipmentsLastSixMonthsChart').get(0).getContext('2d'), {
            type: 'line',
            data: {
                labels: shipmentAmount.map(x => moment(x.month, 'M').format('MMMM')),
                datasets: [
                    {
                        label: '# of Shipments',
                        data: shipmentAmount.map(x => x.amount),
                        backgroundColor: 'rgba(75, 192, 192, 0.6)',
                    },
                    {
                        label: '# of Motorcycles Shipped',
                        data: bikeShipped.map(x => x.amount),
                        backgroundColor: 'rgba(255, 206, 86, 0.6)',
                    }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
        const returnAmountChart = new Chart($('canvas#returnsLastSixMonthsChart').get(0).getContext('2d'), {
            type: 'bar',
            data: {
                labels: returnAmount.map(x => moment(x.month, 'M').format('MMMM')),
                datasets: [{
                    label: '# of Returned Items',
                    data: returnAmount.map(x => x.amount),
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.7)',
                        'rgba(54, 162, 235, 0.7)',
                        'rgba(255, 206, 86, 0.7)',
                        'rgba(75, 192, 192, 0.7)',
                        'rgba(153, 102, 255, 0.7)',
                        'rgba(255, 159, 64, 0.7)'
                    ],
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
        const bikeModelShippedChart = new Chart($('canvas#bikeModelShippedThisMonthChart').get(0).getContext('2d'), {
            type: 'pie',
            data: {
                labels: bikeModelShipped.map(x => x.name),
                datasets: [{
                    label: '# of Votes',
                    data: bikeModelShipped.map(x => x.amount),
                    backgroundColor: [
                        'rgba(255, 99, 132)',
                        'rgba(54, 162, 235)',
                        'rgba(255, 206, 86)',
                        'rgba(75, 192, 192)',
                        'rgba(153, 102, 255)',
                        'rgba(255, 159, 64)'
                    ],
                }]
            },
        });

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