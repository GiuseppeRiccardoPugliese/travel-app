@extends('layouts.app')
@section('content')
    {{-- @unless (Auth::check())
        <div class="welcome-container">
            <h1 class="welcome-text">BENVENUTO SU TRAVEL-APP</h1>
        </div>
    @endunless --}}

    @auth
        {{-- Rotta Create per i trip --}}
        <a href="{{route('trip.create')}}" class="btn btn-sm btn-primary">Crea un nuovo viaggio</a>

        @foreach ($trips as $trip)

            <a onclick="submitForm({{$trip->id}})">
                <h1>Nome viaggio: {{ $trip->nome }}
                    {{-- Rotta EDIT per i trip --}}
                    <a href="{{route('trip.edit', $trip->id)}}">Modifica</a></h1>

                    {{-- Rotta DELETE per i trip --}}
                    <form action="{{route('trip.destroy', $trip->id)}}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Elimina</button>
                    </form>

            </a>    
            
            {{-- Rotta show per i trip --}}
            <form action="{{ route('trip.show') }}" method="POST" id="ShowForm{{$trip->id}}" >
            @csrf
            @method('POST')

            <input type="hidden" name="trip_id" value="{{ $trip->id}}">

            </form>    
            
        @endforeach
        
    @endauth
@endsection

<script>
    function submitForm(id) {
        console.log(id);
        document.getElementById(`${'ShowForm'}${id}`).submit();
    };
</script>