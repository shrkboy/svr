@extends('layouts.app')

@section('content')
<<<<<<< HEAD
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    You are logged in!
                </div>
=======
    <div class="container">
        <form class="p-3">
            <div class="form-group" style="width: 30%">
                <label for="branch">Select branch</label>
                <select name="branch" id="branch" class="form-control">
                    <option hidden selected value="null">Select...</option>
                    <option value="">Branch #1</option>
                    <option value="">Branch #2</option>
                    <option value="">Branch #3</option>
                </select>
>>>>>>> 30f9d14736039f88d282c8698fc535e7265392d1
            </div>

            <table class="table">

                <thead>
                <tr>
                    <th scope="col">Models</th>
                    <th scope="col">Display Qty</th>
                    <th scope="col">Talker</th>
                    <th scope="col">Flyer</th>
                    <th scope="col">Streamer</th>
                </tr>
                </thead>

                <tbody>
                <tr>
                    <th scope="row">Model name</th>
                    <td>
                        <input type="number" min=0 max=999 name="display-qty" class="form-control">
                    </td>
                    <td>
                        <input type="number" min=0 max=999 name="talker" class="form-control">
                    </td>
                    <td>
                        <input type="number" min=0 max=999 name="flyer" class="form-control">
                    </td>
                    <td>
                        <input type="number" min=0 max=999 name="streamer" class="form-control">
                    </td>
                </tr>
                </tbody>

            </table>

            <div class="text-right">
                <button type="submit" class="btn btn-primary">Login</button>
            </div>

        </form>

    </div>
@endsection
