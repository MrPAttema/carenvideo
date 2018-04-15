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
        
        
        <CallingComponent></CallingComponent>

    {{-- <style>
        #outgoing {
            width: 600px;
            word-wrap: break-word;
        }
    </style>
    <pre id="outgoing"></pre> --}}
    </div>
@endsection


