@extends('layouts.app')

@section('navmenu')
    <ul class="navbar-nav mr-auto">
        @if(\Illuminate\Support\Facades\Auth::user()->is_admin)
            <li class="nav-item">
                <a class="nav-link" href="{{url('/users')}}">Users</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{url('/reports')}}">Reports</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{url('/models')}}">Bike Models</a>
            </li>
        @endif
        <li class="nav-item">
            <a class="nav-link" href="{{url('/display')}}">Display</a>
        </li>
    </ul>
@stop

@section('content')
    <div class="container-fluid">
        <div class="col-md-auto">
            <h4>Report Detail</h4>
            <h6>Branch: {{ $reports->branches->name }}</h6>
            <h6>Submitted by: {{ $reports->users->name }}</h6>
            <h6>On: {{ \Carbon\Carbon::parse($reports->record_date)->format('M d, Y H:i:s') }}</h6>
            <div class="table-responsive">
                <table class="table table-striped" style="table-layout: fixed">
                    <thead>
                    <tr>
                        <th scope="col">Models</th>
                        <th scope="col">Display Qty</th>
                        <th scope="col">Talker</th>
                        <th scope="col">Flayer</th>
                        <th scope="col">Streamer</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($reports->details as $detail)
                        <tr>
                            <td scope="row">{{$detail->code_model}}</td>
                            <td>{{ $detail->dsp_qty }}</td>
                            <td>{{ $detail->talker }}</td>
                            <td>{{ $detail->flayer }}</td>
                            <td>{{ $detail->streamer }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div id="documentCarousel" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    @foreach($reports->documents as $document)
                        {{ asset('/images/'.$document->pic_path) }}
                        <div class="carousel-item">
                            <img src="" class="d-block w-100" alt="file {{ $document->pic_path }}">
                            <div class="carousel-caption d-none d-md-block">
                                <h5>{{ $document->pic_path }}</h5>
                            </div>
                        </div>
                    @endforeach
                    <a class="carousel-control-prev" href="#documentCarousel" role="button"
                       data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#documentCarousel" role="button"
                       data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
        </div>
@endsection