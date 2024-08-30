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
    <div class="container">
        {{-- Rotta Create per i trip --}}
        <div class="row justify-content-between" id="calendar_row">
            <div class="col-auto">
                <div class="icon-container" style="cursor: default;">
                    <h6 class="me-1">Se desideri aggiungere un nuovo viaggio, clicca sul calendario
                    </h6>
                    <i class="fa-solid fa-right-long"></i>
                </div>
            </div>
            <div class="col-1 nav-item d-flex flex-column align-items-center gap-4">
                <a href="{{ route('trip.create') }}" class="fs-3"><i class="fa-regular fa-calendar-plus"></i></a>
                <span class="icon-text">Aggiungi un nuovo viaggio</span>
            </div>
        </div>
    </div>
    @if ($trips != null)
        <div class="ps-4 typing-container">
            <h4 class="fw-bold mb-0">Viaggi Passati</h4>
        </div>
        <div class="container">
            <div class="row mt-4">
                @foreach ($trips as $trip)
                    <div class=" col-md-4  col-6 mb-4">
                        <a onclick="submitForm({{ $trip->id }})" class="text-decoration-none" style="cursor: pointer;">
                            <div class="card h-100 position-relative">
                                <img src="{{ asset('storage/' . $trip->immagine) }}" class="card-img-top img-fluid"
                                    alt="Immagine Viaggio">
                                <div class="card-body card_show_trip d-flex flex-column align-items-center">
                                    <h5 class="card-title mb-4">{{ $trip->nome }}</h5>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <a onclick="submitEditForm({{ $trip->id }})" style="cursor: pointer;"
                                            class="flex-grow-1">
                                            <div class="rounded-circle bg-info p-2" style="width: fit-content;">

                                                <i class="fa-solid fa-pen text-white"></i>
                                            </div>
                                        </a>
                                        <a onclick="submitDestroyForm(event, {{ $trip->id }})" style="cursor: pointer;">
                                            <div class="rounded-circle bg-black p-2" style="width: fit-content;">
                                                <i class="fa-solid fa-trash-can text-danger "></i>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="d-flex justify-content-between w-100 mt-auto flex-wrap">
                                        <div class="d-flex flex-column align-items-center">
                                            <i class="fa-solid fa-plane-departure"></i> <i
                                                class="fa-solid fa-down-long"></i> <span
                                                class="dateSpan">{{ $trip->data_inizio }}</span>
                                        </div>
                                        <div class="d-flex flex-column align-items-center">
                                            <i class="fa-solid fa-plane-arrival"></i> <i class="fa-solid fa-down-long"></i>
                                            <span class="dateSpan">{{ $trip->data_fine }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                    {{-- Form per Edit --}}
                    <form action="{{ route('trip.edit') }}" method="POST" id="EditForm{{ $trip->id }}"
                        style="display:none;">
                        @csrf
                        @method('POST')
                        <input type="hidden" name="trip_id" value="{{ $trip->id }}">
                    </form>

                    {{-- Form per Delete --}}
                    <form action="{{ route('trip.destroy') }}" method="POST" id="DestroyForm{{ $trip->id }}"
                        style="display:none;">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="trip_id" value="{{ $trip->id }}">
                    </form>

                    {{-- Form per Show --}}
                    <form action="{{ route('trip.show') }}" method="POST" id="ShowForm{{ $trip->id }}"
                        style="display:none;">
                        @csrf
                        @method('POST')
                        <input type="hidden" name="trip_id" value="{{ $trip->id }}">
                    </form>
                @endforeach
            </div>
        </div>
        <div class="ps-4 typing-container">
            <h4 class="fw-bold mb-0">Riscopri le tue tappe preferite!</h4>
        </div>
        <div class="container mt-4">
            <div class="owl-carousel  position-relative" id="carosello-journey-card">


            </div>
        </div>
    @endif


@endauth
@endsection
<script src="http://www.localhost:5173/resources/js/carousel_journeystages.js"></script>

<script>
    function fixDate(date) {
        if (!date || isNaN(Date.parse(date))) {
            return "Data non valida";
        }

        const options = {
            year: 'numeric',
            month: 'numeric',
            day: 'numeric'
        };
        return new Date(date).toLocaleDateString('it-IT', options);
    }
    document.addEventListener('DOMContentLoaded', function() {
        // Seleziona tutti gli elementi <span> con la classe "dateSpan"
        const dateSpans = document.querySelectorAll('.dateSpan');

        // Itera su tutti gli elementi selezionati
        dateSpans.forEach(function(span) {
            // Ottieni il valore della data dal data attribute
            console.log(span);
            const date = span.textContent;
            // Applica la funzione fixDate e aggiorna il testo del <span>
            span.innerText = fixDate(date);
        });

        const userId = {{ Auth::id() }}; // Sostituisci con l'ID dell'utente desiderato
        carousel(userId);
    });
</script>
<style>
.icon-container {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    /* Dimensione dell'icona */
    cursor: pointer;
    transition: transform 0.3s ease;
    animation: moveRight 1s ease-in-out infinite;
    /* Transizione fluida */
}



@keyframes moveRight {
    0% {
        transform: translateX(0);
        /* Inizio senza traslazione */
    }

    50% {
        transform: translateX(10px);
        /* Traslazione a destra */
    }

    100% {
        transform: translateX(0);
        /* Torna alla posizione iniziale */
    }
}

.card-img-top {
    object-fit: cover;
    /* Mantiene le proporzioni dell'immagine */
    width: 100%;
    /* Assicura che l'immagine occupi tutta la larghezza del contenitore */
    height: auto;
    /* Altezza automatica per mantenere le proporzioni */
    min-height: 10rem;
    /* Altezza minima per evitare che l'immagine diventi troppo piccola */
}

/* Regole per schermi medi e superiori */
@media (min-width: 768px) {
    .card-img-top {
        max-height: 20rem;
        /* Altezza massima per schermi medi e superiori */
    }

    #calendar_row .col-1 {
        margin: none;
    }
}

@media (max-width: 768px) {
    #calendar_row .col-1 {
        margin: 10px auto;
    }

    #calendar_row .col-1 i {
        font-size: 4rem;
    }

    .icon-container i {
        display: none;
    }

    .card-img-top {
        max-height: 20rem;
        /* Altezza massima per schermi medi e superiori */
    }

    .icon-container i {
        display: none;
    }
}

@media (min-width: 992px) {
    .card-img-top {
        max-height: 5rem;
        /* Altezza massima per schermi grandi */
    }
}

@media (min-width: 1200px) {
    .card-img-top {
        max-height: 12rem;
        /* Altezza massima per schermi extra-grandi */

    }
}

.card_show_trip>:nth-child(2) {
    position: absolute;
    top: 10px;
    width: calc(100% - 20px);
    margin: 0 auto;
    right: 10px;
}

.col-1>span:nth-child(2) {
    position: unset;
    margin: 0;
}

.col-1:hover {
    color: black;
    box-shadow: #333;
}

.col-1>a {
    color: #333;
}
</style>
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
