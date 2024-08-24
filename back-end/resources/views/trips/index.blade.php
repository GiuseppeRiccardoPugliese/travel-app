@extends('layouts.app')
@section('content')
    {{-- @unless (Auth::check())
        <div class="welcome-container">
            <h1 class="welcome-text">BENVENUTO SU TRAVEL-APP</h1>
        </div>
    @endunless --}}

    @auth
        {{-- Rotta Create per i trip --}}
        <a href="{{ route('trip.create') }}" class="btn btn-sm btn-primary">Crea un nuovo viaggio</a>

        @foreach ($trips as $trip)
            <a class="text-decoration-underline" onclick="submitForm({{ $trip->id }})">
                <h1>Nome viaggio: {{ $trip->nome }}

                    {{-- Rotta EDIT per i trip --}}
                    <a onclick="submitEditForm({{ $trip->id }})" class="text-decoration-underline">Modifica</a>
                </h1>

                {{-- EDIT --}}
                <form action="{{ route('trip.edit') }}" method="POST" id="EditForm{{ $trip->id }}">
                    @csrf
                    @method('POST')

                    <input type="hidden" name="trip_id" value="{{ $trip->id }}">

                </form>



                {{-- Rotta DELETE per i trip --}}
                <form action="{{ route('trip.destroy') }}" method="POST" style="display: inline;"
                    id="DestroyForm{{ $trip->id }}">
                    @csrf
                    @method('DELETE')

                    <input type="hidden" name="trip_id" value="{{ $trip->id }}">

                    <button onclick="submitDestroyForm(event, {{ $trip->id }})" class="btn btn-danger">Elimina</button>

                </form>

            </a>

            {{-- Rotta SHOW per i trip --}}
            <form action="{{ route('trip.show') }}" method="POST" id="ShowForm{{ $trip->id }}">
                @csrf
                @method('POST')

                <input type="hidden" name="trip_id" value="{{ $trip->id }}">

            </form>
        @endforeach

    @endauth
@endsection

<script>
    function submitForm(id) {
        document.getElementById(`${'ShowForm'}${id}`).submit();
    };

    function submitDestroyForm(event, id) {
        event.preventDefault(); // Prevent default form submission
        if (confirm('Sei sicuro di voler eliminare questo viaggio?')) {
            document.getElementById(`DestroyForm${id}`).submit();
        }
    }

    function submitEditForm(id) {
        event.preventDefault(); // Prevent default form submission
        document.getElementById(`EditForm${id}`).submit();
    }
</script>
