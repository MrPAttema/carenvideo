@extends('layouts.main')

@section('content')

    <div class="flex-center position-ref full-height">
        @if (Route::has('login'))
            <div class="top-right links">
                @auth
                    <a href="{{ url('/home') }}">Home</a>
                @else
                    <a href="{{ route('login') }}">Login</a>
                    <a href="{{ route('register') }}">Register</a>
                @endauth
            </div>
        @endif
        
        <div class="center">
            @if (session()->has('token'))
                <form action="/caren/auth/destroy" method="POST">
                    <button class="btn-primary" type="submit">Uitloggen</button>
                    {{ csrf_field() }}
                </form>
            @else 
                <form action="/caren/auth" method="POST">
                    <button class="btn-primary" type="submit">Koppel met Carenzorgt</button>
                    {{ csrf_field() }}
                </form>
            @endif
        </div>

    </div>
@endsection


