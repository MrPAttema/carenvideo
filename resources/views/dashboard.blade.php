@extends('layouts.main')

@section('content')

<Notifications></Notifications>

    <div class="flex-center position-ref full-height">

        <div class="top-right">
            @if (session()->has('carenAuthToken'))
                <form action="/caren/auth/destroy" method="POST">
                    <button class="btn-primary" type="submit">Uitloggen</button>
                    {{ csrf_field() }}
                </form>
            @endif
        </div>

        @if (session()->has('carenAuthToken'))

            <ContactList :users="'{{ json_encode($response) }}'"></ContactList>

        @endif

    </div>
@endsection


