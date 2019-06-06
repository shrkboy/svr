@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Update {{ $warehouse->name }} warehouse info</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('warehouses.update', $warehouse->id) }}">
                            @method('PUT')
                            @csrf

                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>

                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="name" id="name" required placeholder="Name"
                                           value="{{ $warehouse->name }}">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="manager" class="col-md-4 col-form-label text-md-right">Manager</label>

                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="manager" id="manager" required
                                           placeholder="Manager" value="{{ $warehouse->manager }}">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="phone" class="col-md-4 col-form-label text-md-right">Phone</label>

                                <div class="col-md-6 input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">+63</div>
                                    </div>
                                    <input type="text" class="form-control" name="phone" id="phone" required placeholder="Phone"
                                           value="{{ $warehouse->phone }}">
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <a class="btn btn-secondary" href="{{ route('warehouses.index') }}">Cancel</a>
                                    <input type="submit" class="btn btn-primary" value="Edit">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection