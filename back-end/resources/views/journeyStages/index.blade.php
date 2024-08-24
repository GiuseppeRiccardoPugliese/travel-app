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

        <input type="hidden" name="trip_id" value="{{ $trip->id }}">

    </form>
@endsection

<script>
    document.addEventListener("DOMContentLoaded", (event) => {
        setTimeout(() => {
            document.getElementById(('ShowForm')).submit();
        }, 4000);
    });

    let postExecuted = true;

    window.addEventListener('beforeunload', function(e) {
        if (!postExecuted) {
            fetch('/keep-alive', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                        'content')
                },
                body: JSON.stringify({}) // Chiamata nulla
            });
        }
    });
</script>
