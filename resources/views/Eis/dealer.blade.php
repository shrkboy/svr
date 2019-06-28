@extends('eis.app')

@section('content')
    <div class="row">
        <div class="col-md-auto">
            <div class="card">
                <div class="card-header bg-white">
                    <div class="row align-items-center">
                        <div class="col-md-9">
                            <h5 class="card-title text-muted mb-0" style="font-weight: bold">Latest Report Detail from {{ $reports->branches->dlname }}</h5>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="col-md-auto mb-3">
                        <ul>
                            <li class="h6">ID Report: {{ $reports->id }}</li>
                            <li class="h6">Branch: {{ $reports->branches->dlname }}</li>
                            <li class="h6">Submitted by: {{ $reports->users->name }}</li>
                            <li class="h6">On: {{ \Carbon\Carbon::parse($reports->record_date)->format('M d, Y H:i:s') }}</li>
                        </ul>
                        <table id="details" class="table table-striped table-bordered table-light hover" style="width: 100%">
                            <thead>
                            <tr>
                                <th scope="col">MC Models</th>
                                <th scope="col">Display Qty</th>
                                <th scope="col">Talker</th>
                                <th scope="col">Flayer</th>
                                <th scope="col">Streamer</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($reports->details as $detail)
                                <tr>
                                    <td scope="row">{{$detail->model->color}}</td>
                                    <td>{{ $detail->dsp_qty }}</td>
                                    <td>{{ $detail->talker }}</td>
                                    <td>{{ $detail->flayer }}</td>
                                    <td>{{ $detail->streamer }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <h4 class="mt-3">Document Photos</h4>
                    <div class="row">
                        @foreach($reports->documents as $document)
                            <div class="col-md-3">
                                <a href="{{ asset('/images/reports/'.$document->pic_path) }}"
                                   data-title="{{ $document->pic_path }}"
                                   data-lightbox="document">
                                    <img class="img-thumbnail"
                                         src="{{ asset('/images/reports/'.$document->pic_path) }}"
                                         alt="File {{ asset('/images/reports/'.$document->pic_path) }}">
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.bundle.js" charset="utf-8"></script>
    <script>
        $(document).ready( function () {
            $('#details').DataTable({
                "searching": false,
            });
        } );
    </script>
    <script>
        lightbox.option({
            alwaysShowNavOnTouchDevices: true,
            showImageNumberLabel: true,
            albumLabel: 'Document %1 of %2'
        })
    </script>
@endsection
