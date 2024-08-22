@extends('layouts.app')

@section('content')
    <h1>Viaggio</h1>
    <h1> Descrizione: {{ $trip->descrizione }}</h1>

    <p class="card-text">Data inizio:
        {{ \Carbon\Carbon::parse($trip->data_inizio)->setTimezone('Europe/Rome')->locale('it')->isoFormat('DD-MM-YYYY') }}
    </p>
    <p class="card-text">Data fine:
        {{ \Carbon\Carbon::parse($trip->data_fine)->setTimezone('Europe/Rome')->locale('it')->isoFormat('DD-MM-YYYY') }}
    </p>
@endsection
