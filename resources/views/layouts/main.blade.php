<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name') }}</title>

        {{-- CSS --}}
        <link type="text/css" rel="stylesheet" href="{{ asset('css/all.css') }}">
        
    </head>
    <body>
        <div id="app">
            
            @yield('content')
            
        </div>
    </body>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.0.4/socket.io.js"></script>
    <script type="text/javascript" src="https://js.pusher.com/4.2/pusher.min.js"></script>
    <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
</html>