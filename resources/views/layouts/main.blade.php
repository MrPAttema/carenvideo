<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name') }}</title>

        {{-- CSS --}}
        <link type="text/css" rel="stylesheet" href="{{ asset('css/app.css') }}">
        
    </head>
    <body>
        <div id="app">
            
            @yield('content')
            
        </div>
    </body>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.0.4/socket.io.js"></script>
    <script type="text/javascript" src="https://js.pusher.com/4.1/pusher.min.js"></script>
    <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
    {{-- <script>   
        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;
        
        var pusher = new Pusher('8dc95d49e9a8f15e0980', {
            cluster: 'eu',
            encrypted: true
        });
        var channel = pusher.subscribe('call.1566404');
            channel.bind('App\Events\SendCallRequest', function(data) {
            alert(data.message);
            });
        
    </script> --}}
</html>