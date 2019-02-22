@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Add New MC Model</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('models.add') }}">
                            @csrf

                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" name="name" required autofocus>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="code" class="col-md-4 col-form-label text-md-right">Code</label>

                                <div class="col-md-6">
                                    <input id="code" type="text" class="form-control" name="code" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="color" class="col-md-4 col-form-label text-md-right">Color</label>
                                <div class="col-md-6">
                                    <input id="code" type="text" class="form-control" name="color" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="specification"
                                       class="col-md-4 col-form-label text-md-right">Specification</label>

                                <div class="col-md-6">
                                    <textarea id="specification" class="form-control" name="specification"
                                              required></textarea>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">Add</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
