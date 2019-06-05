@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card p-3">
            <form method="POST" action="{{ route('warehouses.update', $warehouse->id) }}">
                @method('PUT')
                {{  csrf_field() }}
                <h3>Update {{ $warehouse->name }} warehouse info</h3>

                <div class="p-2">

                    <div class="form-group row">
                        <label for="name" class="col-sm-2 col-form-label">Name</label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" name="name" id="name" required placeholder="Name"
                                   value="{{ $warehouse->name }}">
                        </div>
                        <i class="m-auto fa fa-2x mr-2" id="mark"></i>
                    </div>

                    <div class="form-group row">
                        <label for="manager" class="col-sm-2 col-form-label">Manager</label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" name="manager" id="manager" required
                                   placeholder="Manager" value="{{ $warehouse->manager }}">
                        </div>
                        <i class="m-auto fa fa-2x mr-2" id="mark"></i>
                    </div>

                    <div class="form-group row">
                        <label for="phone" class="col-sm-2 col-form-label">Phone</label>
                        <div class="col-lg-4 input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">+63</div>
                            </div>
                            <input type="text" class="form-control" name="phone" id="phone" required placeholder="Phone"
                                   value="{{ $warehouse->phone }}">
                        </div>
                        <i class="m-auto fa fa-2x mr-2" id="mark"></i>
                    </div>

                </div>

                <div class="text-right mt-3">
                    <a class="btn btn-secondary" href="{{ route('warehouses.index') }}">Cancel</a>
                    <input type="submit" class="btn btn-primary" value="Edit">
                </div>
            </form>
        </div>
    </div>
@endsection