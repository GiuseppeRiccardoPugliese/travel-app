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
    <a class="text-decoration-underline" onclick="submitForm()">Crea una nuova tappa</a>

    {{-- Form per passare il trip_id nascosto CREATE --}}
    <form action="{{ route('journeyStages.create') }}" method="POST" id="CreateStageForm">
        @csrf
        @method('POST')

        <input type="hidden" name="trip_id" value="{{ $trip->id }}">

    </form>

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
                    <a onclick="submitEditForm({{ $stage->id }})" class="button">MODIFICA</a>

                    {{-- Form per passare il trip_id nascosto EDIT --}}
                    <form action="{{ route('journeyStages.edit') }}" method="POST" id="EditStageForm{{ $stage->id }}">
                        @csrf
                        @method('POST')

                        <input type="hidden" name="trip_id" value="{{ $trip->id }}">
                        <input type="hidden" name="stage_id" value="{{ $stage->id }}">

                    </form>

                    {{-- DELETE --}}
                    <form action="{{ route('journeyStages.destroy') }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')

                        <input type="hidden" name="trip_id" value="{{ $trip->id }}">
                        <input type="hidden" name="stage_id" value="{{ $stage->id }}">

                        <button type="submit" class="btn btn-danger">Elimina</button>
                    </form>
                </li>
            @endforeach
        </ul>
    @endif
@endsection

<script>
    function submitForm() {
        document.getElementById('CreateStageForm').submit();
    };

    function submitEditForm(id) {
        document.getElementById(`${'EditStageForm'}${id}`).submit();
    };
</script>
