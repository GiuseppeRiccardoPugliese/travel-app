@extends('layouts.app')

@section('content')
@section('welcome_message')
    {{ auth()->user()->name }}
@endsection
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

    {{-- ROTTA PER LA CREATE DELLA TAPPA --}}
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
                    <form action="{{ route('journeyStages.destroy') }}" method="POST" style="display: inline;"
                        id="DestroyForm{{ $trip->id }}_{{ $stage->id }}">
                        @csrf
                        @method('DELETE')

                        <input type="hidden" name="trip_id" value="{{ $trip->id }}">
                        <input type="hidden" name="stage_id" value="{{ $stage->id }}">

                        {{-- Funct che al click mi passa gli Id --}}
                        <button onclick="receiveIds({{ $trip->id }}, {{ $stage->id }})" type="submit"
                            data-bs-toggle="modal" data-bs-target="#deleteModal" class="btn btn-danger">Elimina</button>
                    </form>
                </li>
            @endforeach
        </ul>

        {{-- MODAL --}}
        <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg">
                    <div class="modal-header bg-danger text-white text-center flex-column">
                        <img src="https://static.vecteezy.com/ti/vettori-gratis/p1/9326903-icona-aereo-proibito-su-sfondo-bianco-stile-piatto-cartello-di-divieto-rosso-non-volare-aerei-simbolo-zona-divieto-vettoriale.jpg"
                            alt="Delete Icon" class="img-fluid mb-2 rounded-circle border border-white"
                            style="width: 60px;">
                        <h5 class="modal-title" id="deleteModalLabel">Conferma Eliminazione</h5>
                    </div>
                    <div class="modal-body text-center">
                        <p class="lead">Sei sicuro di voler eliminare questo viaggio?</p>
                        <p class="text-muted">Questa azione è irreversibile.</p>
                    </div>
                    <div class="modal-footer justify-content-center">
                        <button type="button" class="btn btn-white-custom btn-lg rounded-pill px-4 shadow"
                            data-bs-dismiss="modal">Annulla</button>
                        <button type="button" class="btn btn-danger btn-lg rounded-pill px-4" onclick="submitDestroyForm()"
                            id="confirmDeleteButton">Elimina</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

<script>
    let trip_id = 0;
    let stage_id = 0;

    function submitForm() {
        document.getElementById('CreateStageForm').submit();
    };

    function submitEditForm(id) {
        document.getElementById(`${'EditStageForm'}${id}`).submit();
    };

    function submitDestroyForm() {
        event.preventDefault(); // Prevent default form submission

        document.getElementById(`DestroyForm${this.trip_id}_${this.stage_id}`)
            .submit();
    }

    function receiveIds(trip_id, stage_id) {
        event.preventDefault();
        this.trip_id = trip_id;
        this.stage_id = stage_id;
    }
</script>

<style>
    .btn-white-custom {
        background-color: #ffffff;
        color: #000000;
        border: 1px solid #ced4da;
        transition: background-color 0.6s ease, color 0.6s ease, box-shadow 0.3s ease;
    }

    .btn-white-custom:hover {
        background-color: #000000 !important;
        color: #ffffff !important;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.2);
    }
</style>
