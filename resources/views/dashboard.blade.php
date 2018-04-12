@extends('layouts.main')

@section('content')

    <div class="flex-center position-ref full-height">

        <div class="top-right">
            @if (session()->has('carenAuthToken'))
                <form action="/caren/auth/destroy" method="POST">
                    <button class="btn" type="submit">Uitloggen</button>
                    {{ csrf_field() }}
                </form>
            @endif
        </div>

        @if (session()->has('carenAuthToken'))
            <form action="/setup/client" method="GET">
                <button class="btn" type="submit">Bel Bram</button>
            </form>
        @endif

    </div>
@endsection


