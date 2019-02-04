@extends('layouts.app')

@section('head-script')
    <!-- Select2 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="col-md-auto">
            <h4>Display</h4>
            {{--<h6 id="logs">Log here:</h6>--}}
            <form method="post" action="{{ url('/display') }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <table class="table table-striped" style="table-layout: fixed">
                    <thead>
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Username</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td scope="row">{{$user->name}}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->username }}</td>

                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </form>
        </div>
    </div>
@endsection