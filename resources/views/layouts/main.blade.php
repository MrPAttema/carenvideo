<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Laravel</title>

        {{-- CSS --}}
        <link type="text/css" rel="stylesheet" href="{{ asset('css/app.css') }}">

        {{--  SCRIPTS  --}}
        <script defer type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.0.4/socket.io.js"></script>
        <script defer type="text/javascript" src="{{ asset('js/app.js') }}"></script>
        <script src="https://js.pusher.com/4.1/pusher.min.js"></script>
    </head>
    <body>
        <div id="app">

            @yield('content')

        </div>
    </body>
</html>