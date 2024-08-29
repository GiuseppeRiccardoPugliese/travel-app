@extends('layouts.app')
@section('content')
@section('welcome_message')
    {{ auth()->user()->name }}
@endsection
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

                {{-- receiveTripId() prende il $trip->id per passarlo alla funzione sulla onClick del button delete del modal --}}
                <button class="btn btn-danger" onclick="receiveTripId({{ $trip->id }})" data-bs-toggle="modal"
                    data-bs-target="#deleteModal">Elimina</button>
            </form>

        </a>

        {{-- Rotta SHOW per i trip --}}
        <form action="{{ route('trip.show') }}" method="POST" id="ShowForm{{ $trip->id }}">
            @csrf
            @method('POST')

            <input type="hidden" name="trip_id" value="{{ $trip->id }}">

        </form>
    @endforeach


    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-danger text-white text-center flex-column">
                    <img src="https://static.vecteezy.com/ti/vettori-gratis/p1/9326903-icona-aereo-proibito-su-sfondo-bianco-stile-piatto-cartello-di-divieto-rosso-non-volare-aerei-simbolo-zona-divieto-vettoriale.jpg"
                        alt="Delete Icon" class="img-fluid mb-2 rounded-circle border border-white" style="width: 60px;">
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



@endauth
@endsection

<script>
    let trip_id = 0;

    function submitForm(id) {
        document.getElementById(`${'ShowForm'}${id}`).submit();
    };

    function submitDestroyForm() {

        event.preventDefault(); // Prevent default form submission

        document.getElementById(`DestroyForm${trip_id}`)
            .submit(); //Al submit prendo il form del destroy con l'id e submitto

    }

    function submitEditForm(id) {
        event.preventDefault(); // Prevent default form submission
        document.getElementById(`EditForm${id}`).submit();
    }

    function receiveTripId(id) {
        event.preventDefault();
        trip_id = id;
    }
</script>

<style>
.modal-header {
    border-top-left-radius: 15px;
    border-top-right-radius: 15px;
}

.btn-close-white {
    filter: brightness(0) invert(1);
}

.btn-white-custom {
    background-color: #ffffff;
    color: #000000;
    border: 1px solid #ced4da;
    transition: background-color 0.3s ease, color 0.3s ease, box-shadow 0.3s ease;
}

.btn-white-custom:hover {
    background-color: #000000;
    color: #ffffff;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.2);
}
</style>
