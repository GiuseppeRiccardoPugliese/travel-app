@extends('layouts.app')

@section('content')
    {{-- Sezione dei viaggi --}}
    <h1>Nome viaggio: {{ $trip->nome }}</h1>
    <h1> Descrizione: {{ $trip->descrizione }}</h1>
    <h1> Destinazione: {{ $trip->destinazione }}</h1>


    <p class="card-text">Data inizio:
        {{ \Carbon\Carbon::parse($trip->data_inizio)->setTimezone('Europe/Rome')->locale('it')->isoFormat('DD-MM-YYYY') }}
    </p>
    <p class="card-text">Data fine:
        {{ \Carbon\Carbon::parse($trip->data_fine)->setTimezone('Europe/Rome')->locale('it')->isoFormat('DD-MM-YYYY') }}
    </p>

    {{-- Sezione per gli Stages del Viaggio --}}

    {{-- //ROTTA PER LA CREATE DELLA TAPPA --}}
    <a href="{{ route('journeyStages.create', ['trip' => $trip->id]) }}">Crea una nuova tappa</a>

    <h2>Stages del Viaggio</h2>
    @if ($trip->journeyStages->isEmpty())
        <p>Nessun stage disponibile per questo viaggio.</p>
    @else
        <ul>
            @foreach ($trip->journeyStages as $stage)
                <li>
                    <strong>{{ $stage->nome }}</strong>: {{ $stage->descrizione }}
                    <br>
                    <h5>Posizione: {{ $stage->posizione }}</h5>

                    <em>Data:
                        {{ \Carbon\Carbon::parse($stage->data)->setTimezone('Europe/Rome')->locale('it')->isoFormat('DD-MM-YYYY') }}
                    </em>

                    {{-- EDIT --}}
                    <a class="button" href="{{ route('journeyStages.edit') }}?id={{ $stage->id }}">MODIFICA</a>

                    {{-- DELETE --}}
                    <form action="{{ route('journeyStages.destroy') }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="id" value="{{ $stage->id }}">
                        <button type="submit" class="btn btn-danger">Elimina</button>
                    </form>
                </li>
            @endforeach
        </ul>
    @endif
@endsection
