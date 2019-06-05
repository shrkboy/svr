@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card p-3">
            <form method="POST" action="{{ route('warehouses.store') }}">
                {{  csrf_field() }}
                <h3>New warehouse</h3>

                <div class="p-2">

                    <div class="form-group row">
                        <label for="name" class="col-sm-2 col-form-label">Name</label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" name="name" id="name" required placeholder="Name">
                        </div>
                        <i class="m-auto fa fa-2x mr-2" id="mark"></i>
                    </div>

                    <div class="form-group row">
                        <label for="manager" class="col-sm-2 col-form-label">Manager</label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" name="manager" id="manager" required placeholder="Manager">
                        </div>
                        <i class="m-auto fa fa-2x mr-2" id="mark"></i>
                    </div>

                    <div class="form-group row">
                        <label for="phone" class="col-sm-2 col-form-label">Phone</label>
                        <div class="col-lg-4 input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">+63</div>
                            </div>
                            <input type="text" class="form-control" name="phone" id="phone" required placeholder="Phone">
                        </div>
                        <i class="m-auto fa fa-2x mr-2" id="mark"></i>
                    </div>

                </div>

                <div class="text-right mt-3">
                    <input type="submit" class="btn btn-success" value="Submit">
                </div>
            </form>
        </div>
    </div>
@endsection