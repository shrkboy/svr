@extends('layouts.app')

@section('content')
<div class="container mh-auto mt-5 p-4 border" style="width: 25%">
    <span class="h3">Login</span>
    <form class="mt-3">
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" id="username" class="form-control" placeholder="Username">
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" class="form-control" placeholder="Password">
        </div>
        <div class="text-right">
            <button type="submit" class="btn btn-primary">Login</button>
        </div>
    </form>
</div>
@endsection