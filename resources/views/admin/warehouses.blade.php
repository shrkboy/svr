@extends('layouts.app')

@section('head-styles')
    <link rel="stylesheet" href="{{ asset('css/font-awesome.css') }}">
    <link rel="stylesheet" href="{{ asset('css/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
@endsection


@section('navmenu')
    <ul class="navbar-nav mr-auto">
        @if(auth()->user()->role_id == 8)
            <li class="nav-item active">
                <a class="nav-link" href="{{url('/users')}}">Users</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{url('/reports')}}">Reports</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{url('/models')}}">MC Models</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="{{url('/warehouses')}}">Warehouses</a>
            </li>
        @endif
    </ul>
@stop

@section('content')
    <div class="card p-3">
        <div class="row mb-3">
            <div class="col-md-6">
                <h4>Warehouses</h4>
            </div>
            <div class="col-md-6">
                <a class="btn btn-primary float-right" role="button" href="{{ route('warehouses.create') }}">Add</a>
            </div>
        </div>
        <table class="table table-sm table-striped" id="data-table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Manager</th>
                <th scope="col">Phone</th>
                <th scope="col">Action</th>
            </tr>
            </thead>

            <tbody>
            @foreach($warehouses as $key=>$warehouse)
                <tr>
                    <td scope="row">{{ ++$key }}</td>
                    <td>{{ $warehouse->name }}</td>
                    <td>{{ $warehouse->manager_detail['name'] }}</td>
                    <td>{{ $warehouse->phone != null ? '+63'.$warehouse->phone : '' }}</td>
                    <td>
                        <div class="btn-group">
                            <button type="button" class="btn btn-primary" data-toggle="modal"
                                    data-target="#keyModal" data-id="{{ $warehouse->id }}"
                                    data-name="{{ $warehouse->name }}">Refresh auth key
                            </button>
                            <a class="btn btn-secondary" href="{{ route('warehouses.edit', $warehouse->id) }}">Update</a>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>


    {{--Modal to view auth key--}}
    <div class="modal fade" id="keyModal" tabindex="-1" role="dialog" aria-labelledby="modelLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modelLabel">New message</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <div id="result">
                        <div class="input-group">
                            <input type="text" class="form-control" id="key" readonly>
                            <div class="input-group-append">
                                <button type="button" class="btn btn-primary" id="copy">
                                    <span class="fa fa-copy"></span>
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
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('js/clock-and-date.js') }}"></script>
    <script src="{{ asset('js/select2.full.min.js') }}"></script>
    <script src="{{ asset('js/datatables.min.js') }}"></script>
    <script src="{{ asset('js/moment.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap-datetimepicker.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            /**
             * set table as DataTable
             */
            $("#data-table").DataTable({
                columnDefs: [
                    {orderable: false, searchable: false, targets: 4}
                ],
                responsive: true,
            });

            $('button#copy').click(function () {
                $('input#key').select();
                document.execCommand('copy');
                $('small#info-text').text('Copied to clipboard!');
            });

            $('#keyModal').on('show.bs.modal', function (event) {
                const modal = $(this);
                const button = $(event.relatedTarget); // Button that triggered the modal
                const id = button.data('id');
                const name = button.data('name');

                const result = modal.find('div#result');
                const keyText = modal.find('input#key');
                const errorMessage = modal.find('h5#error-message');
                const spinner = modal.find('div#spinner');

                result.hide();
                $('small#info-text').text('');
                errorMessage.hide();
                spinner.show();
                modal.find('.modal-title').text('New auth key for warehouse ' + name);

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
                        url: '{{ url('/key/update') }}' + '/' + id,
                        method: 'POST',
                        data: updateData,
                    }).done(function () {
                        spinner.hide();
                        console.log('Key updated successfully');
                        keyText.val(newKey);
                        result.show();
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
                });
            });
        })
    </script>
@endsection
