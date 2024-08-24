@extends('layouts.app')

@section('content')
    @php
        if ($codice == 1) {
            $messaggio = 'Tappa creata con successo.';
        } elseif ($codice == 2) {
            $messaggio = 'Tappa aggiornata con successo.';
        } elseif ($codice == 3) {
            $messaggio = 'Tappa eliminata con successo.';
        } else {
            $messaggio = 'Operazione sconosciuta.';
        }
    @endphp

    <div class="alert alert-success">
        {{ $messaggio }}
    </div>

    <form action="{{ route('trip.show') }}" method="POST" id="ShowForm">
        @csrf
        @method('POST')

        <input type="hidden" id="trip_id" name="trip_id" value="{{ $trip->id }}">
    </form>
@endsection

<script>
    document.addEventListener("DOMContentLoaded", (event) => {

        setTimeout(() => {
            document.getElementById('ShowForm').submit();
        }, 2000); // Invia il form dopo 2 secondi

    });
</script>
