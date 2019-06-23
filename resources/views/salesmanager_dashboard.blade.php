@extends('layouts.app')

@section('head-styles')
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/Chart.min.css') }}">
@endsection

@section('navmenu')
    <ul class="navbar-nav mr-auto">
        @if(auth()->user()->role_id == 3)
            <li class="nav-item">
                <a class="nav-link" href="{{url('/display')}}">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{url('/display')}}">Display</a>
            </li>
        @endif
        <li class="nav-item active">
            <a class="nav-link" href="{{url('/retaildashboard')}}">Dashboard</a>
        </li>
        <li class="nav-item ">
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
    <div class="row">
        <div class="col-md m-auto">
            <h3 id="date">Loading date</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-md m-auto">
            <h3 id="clock">Loading clock</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 m-auto">
            <h3>
                Logged in from {{$dealer->dlname}} as {{auth()->user()->name}} ({{$role->name}})
            </h3>
        </div>
        <div class="col-md-6 text-right m-auto">
        </div>
    </div>
    <br>
    {{--<div class="table-responsive mt-3">--}}
        {{--<table id="report-table" class="table table-striped table-sm display" style="table-layout: fixed">--}}
            {{--<thead class="thead-inverse">--}}
            {{--<tr>--}}
                {{--<th scope="col">model</th>--}}
                {{--<th scope="col">amount</th>--}}
            {{--</tr>--}}
            {{--</thead>--}}
            {{--<tbody>--}}
            {{--@foreach($modelsSold as $modelSold)--}}
                {{--<tr>--}}

                    {{--<td>{{$modelSold->name}}</td>--}}
                    {{--<td>{{$modelSold->amount}}</td>--}}
                {{--</tr>--}}
            {{--@endforeach--}}
            {{--</tbody>--}}
        {{--</table>--}}
    {{--</div>--}}
        <div class="col-md-auto">
            <div class="row">
                <div class="col-md-4" id="modelSoldThisMonth">
                    <div class="card">
                        <div class="card-header">
                            <h4><b>Motorcycle Models Sold This Month</b></h4>
                        </div>
                        <div class="card-body">
                            <canvas id="modelSoldThisMonthChart" height="255"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-8" id="monthlySold">
                    <div class="card">
                        <div class="card-header">
                            <h4><b>Motorcycles Sold Monthly</b></h4>
                        </div>
                        <div class="card-body">
                            <canvas id="monthlySoldChart" height="120"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-md-8" id="modelsStockThisMonth">
                    <div class="card">
                        <div class="card-header">
                            <h4><b>Motorcycle Models Stock This Month</b></h4>
                        </div>
                        <div class="card-body">
                            <canvas id="modelsStockThisMonthChart" height="120"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-4" id="modelsStockThisMonth">
                    <div class="card">
                        <div class="card-header">
                            <h4><b>Summary This Month</b></h4>
                        </div>
                        <div class="card-body">
                            <br>
                            @foreach($soldthismonth as $sold)
                            <h1><b>{{$sold->amount}}</b></h1>
                            @endforeach
                            <h3>Motorcycles Sold</h3>
                            <br>
                            @foreach($restockedthismonth as $restock)
                            <h1><b>{{$restock->amount}}</b></h1>
                            @endforeach
                            <h3>Motorcycles Restocked</h3>
                            <br>
                            @foreach($purchasedthismonth as $purchase)
                                <h1><b>{{$purchase->amount}}</b></h1>
                            @endforeach
                            <h3>Motorcycle Models Purchased</h3>
                            <br>
                            <h1><b>{{date("m/d/Y", strtotime($last_updated->input_date))}}</b></h1>
                            <h3>Last Updated</h3>
                            <br>

                        </div>
                    </div>
                </div>
            </div>
        </div>



    {{--<div class="table-responsive mt-3">--}}
        {{--<table id="report-table" class="table table-striped table-sm display" style="table-layout: fixed">--}}
            {{--<thead class="thead-inverse">--}}
                {{--<tr>--}}
                    {{--<th scope="col">month</th>--}}
                    {{--<th scope="col">amount</th>--}}
                {{--</tr>--}}
            {{--</thead>--}}
            {{--<tbody>--}}
            {{--@foreach($monthlySold as $month)--}}
                {{--<tr>--}}
                    {{--<td>{{$month->month}}</td>--}}
                    {{--<td>{{$month->amount}}</td>--}}
                {{--</tr>--}}
            {{--@endforeach--}}
            {{--</tbody>--}}
        {{--</table>--}}
    {{--</div>--}}
    {{--<div class="table-responsive mt-3">--}}
    {{--<table id="report-table" class="table table-striped table-sm display" style="table-layout: fixed">--}}
    {{--<thead class="thead-inverse">--}}
    {{--<tr>--}}
    {{--<th scope="col">model</th>--}}
    {{--<th scope="col">stock</th>--}}
    {{--</tr>--}}
    {{--</thead>--}}
    {{--<tbody>--}}
    {{--@foreach($modelsStock as $stock)--}}
    {{--<tr>--}}
    {{--<td>{{$stock->name}}</td>--}}
    {{--<td>{{$stock->amount}}</td>--}}
    {{--</tr>--}}
    {{--@endforeach--}}
    {{--</tbody>--}}
    {{--</table>--}}
    {{--</div>--}}

@endsection

@section('script')
    <script src="{{ asset('js/clock-and-date.js') }}"></script>
    <script src="{{ asset('js/Chart.bundle.min.js') }}"></script>
    <script src="{{ asset('js/moment.min.js') }}"></script>
    <!--FontAwesome-->
    <script src="https://use.fontawesome.com/094c71b384.js"></script>
    <script>
        const modelsSold = @json($modelsSold);

        const modelsSoldChart = new Chart($('canvas#modelSoldThisMonthChart').get(0).getContext('2d'), {
            type: 'pie',
            data: {
                labels: modelsSold.map(x => x.name),
                datasets: [{
                    label: '# of Sold Models This Month',
                    data: modelsSold.map(x => x.amount),
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

        const monthlySold = @json($monthlySold);

        const monthlySoldChart = new Chart($('canvas#monthlySoldChart').get(0).getContext('2d'), {
            type: 'line',
            data: {
                labels: monthlySold.map(x => moment(x.month, 'M').format('MMMM')),
                datasets: [{
                    label: '# of Sold Motorcycles Monthly',
                    data: monthlySold.map(x => x.amount),
                    backgroundColor: 'rgba(75, 192, 192, 0.6)',
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

        const modelsStock = @json($modelsStock);

        const modelsStockChart = new Chart($('canvas#modelsStockThisMonthChart').get(0).getContext('2d'), {
            type: 'horizontalBar',
            data: {
                labels: modelsStock.map(x => x.name),
                datasets: [{
                    label: '# of Stock in Inventory',
                    data: modelsStock.map(x => x.amount),
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
                    xAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    </script>
@endsection


