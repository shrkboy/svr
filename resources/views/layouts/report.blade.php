<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Overpass+Mono&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Overpass Mono', monospace;
            filter: grayscale(100%);
        }
        table#data {
            width: 100%;
        }
        tr.blank-row {
            color: white;
            height: 10px;
        }
    </style>
</head>
<body onload="window.print()">
<div id="app">
        @yield('content')
</div>
</body>
</html>
