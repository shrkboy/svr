@extends('layouts.app')

@section('head-styles')
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

    <div class="row mt-3">
        <div class="col-xl-4" id="shipmentsLastSixMonths">
            <div class="card">
                <div class="card-header">
                    Shipments in last 6 months
                </div>
                <div class="card-body">
                    <canvas id="shipmentsLastSixMonthsChart" height="200"></canvas>
                </div>
            </div>
        </div>
        <div class="col-xl-4 mt-xl-0 mt-sm-3" id="returnsLastSixMonths">
            <div class="card">
                <div class="card-header">
                    Returns in last 6 months
                </div>
                <div class="card-body">
                    <canvas id="returnsLastSixMonthsChart" height="200"></canvas>
                </div>
            </div>
        </div>
        <div class="col-xl-4 mt-xl-0 mt-sm-3" id="bikeShippedThisMonth">
            <div class="card">
                <div class="card-header">
                    Bike shipped this month
                </div>
                <div class="card-body">
                    <canvas id="bikeShippedThisMonthChart" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('js/clock-and-date.js') }}"></script>
    <script src="{{ asset('js/Chart.bundle.min.js') }}"></script>
    <script>
        const shipmentsLastSixMonthsChart = new Chart($('canvas#shipmentsLastSixMonthsChart').get(0).getContext('2d'), {
            type: 'bar',
            data: {
                labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
                datasets: [{
                    label: '# of Votes',
                    data: [12, 19, 3, 5, 2, 3],
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
        const returnsLastSixMonthsChart = new Chart($('canvas#returnsLastSixMonthsChart').get(0).getContext('2d'), {
            type: 'bar',
            data: {
                labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
                datasets: [{
                    label: '# of Votes',
                    data: [12, 19, 3, 5, 2, 3],
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
        const bikeShippedThisMonthChart = new Chart($('canvas#bikeShippedThisMonthChart').get(0).getContext('2d'), {
            type: 'pie',
            data: {
                labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
                datasets: [{
                    label: '# of Votes',
                    data: [12, 19, 3, 5, 2, 3],
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
    </script>
@endsection