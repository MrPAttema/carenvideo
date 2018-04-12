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
        
        <span>Een moment.. We bellen..</span>

    <style>
        #outgoing {
            width: 600px;
            word-wrap: break-word;
        }
    </style>
    <form>
        <textarea id="incoming"></textarea>
        <button type="submit">submit</button>
    </form>
    <pre id="outgoing"></pre>
    </div>
@endsection


