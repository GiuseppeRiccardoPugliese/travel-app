@extends('layouts.app')

@section('content')
@section('welcome_message')
    {{ auth()->user()->name }}
@endsection
    {{-- Sezione dei viaggi --}}
    <div class="container">
        <div class="d-flex justify-content-center">

            <h2 class="">Viaggio a: {{ $trip->nome }}</h2 class="mx-auto">
        </div>
        <a class="w-100" >
            <div id="map-trip" style="height: 400px; width: 100%;position: relative;" class="mt-3 flex-fill">
                <div id="searchBox" ></div>
            </div>


        </a>
        <div class="modal fade " id="exampleModal" tabindex="-1" data-bs-backdrop="static"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="ModalSearchedCity">{{ $trip->nome }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                            onclick="scrollPage()"></button>
                    </div>
                    <div class="modal-body p-0">
                        <!-- Mappa che riempie la larghezza e altezza del modale -->
                        <div id="map_modal" class="w-100" style="height: 600px;"></div>
                    </div>

                </div>
            </div>
        </div>
    </div>
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
<script src="https://api.tomtom.com/maps-sdk-for-web/cdn/6.x/6.15.0/maps/maps-web.min.js"></script>
<script src="https://api.tomtom.com/maps-sdk-for-web/cdn/6.x/6.1.2-public-preview.15/services/services-web.min.js">
</script>

<script src="https://api.tomtom.com/maps-sdk-for-web/cdn/plugins/SearchBox/3.1.3-public-preview.0/SearchBox-web.js">
</script>
<script>
    document.addEventListener('DOMContentLoaded', async function() {
        const city = "{{ $trip->nome }}";
        const url =
            `https://api.tomtom.com/search/2/search/${city}.json?key=JaJJHJ6GGLUhADXt9Iuu4C5oaRT5Ah96&typeahead=true&limit=5&entityTypeSet=Municipality`;

        fetch(url)
            .then((response) => response.json())
            .then((data) => {

                console.log(data.results[0]);
                selectCity(data.results[0]);
            })
            .catch((error) => {
                console.error("Errore nella richiesta:", error);
            });
    });
    let map, map_modal, marker, marker_modal;

    function selectCity(city) {
        // Inizializza la mappa solo se non esiste già
        if (!map) {
            map = tt.map({
                key: "JaJJHJ6GGLUhADXt9Iuu4C5oaRT5Ah96",
                container: "map-trip",
                center: [city.position.lon, city.position.lat],
                zoom: 13,
            });

            map_modal = tt.map({
                key: "JaJJHJ6GGLUhADXt9Iuu4C5oaRT5Ah96",
                container: "map_modal",
                center: [city.position.lon, city.position.lat],
                zoom: 10,
            });

            document.getElementById("map-trip").classList.add("drop-in-image");

            var options = {

                searchOptions: {

                    key: "JaJJHJ6GGLUhADXt9Iuu4C5oaRT5Ah96",

                    language: "it-IT",

                    limit: 5,

                },

                autocompleteOptions: {

                    key: "JaJJHJ6GGLUhADXt9Iuu4C5oaRT5Ah96",

                    language: "it-IT",

                },

            }

            var ttSearchBox = new tt.plugins.SearchBox(tt.services, options)

            var searchBoxHTML = ttSearchBox.getSearchBoxHTML();

            document.getElementById('searchBox').append(searchBoxHTML);


        } else {
            // Aggiorna la posizione e lo zoom se la mappa è già inizializzata
            map.setCenter([city.position.lon, city.position.lat]);
            map_modal.setCenter([city.position.lon, city.position.lat]);
        }

        // Rimuovi il marker esistente, se presente
        if (marker) {
            marker.remove();
        }
        if (marker_modal) {
            marker_modal.remove();
        }
        ttSearchBox.on('tomtom.searchbox.resultselected', function(event) {
            var result = event.data.result;
            var lat = result.position.lat;
            var lon = result.position.lng;
            console.log(result);
            // Aggiorna la mappa principale
            map.setCenter([lon, lat]);
            map.setZoom(18);

            // Aggiorna la mappa del modale
            map_modal.setCenter([lon, lat]);
            map_modal.setZoom(10);

            // Rimuovi il marker esistente, se presente
            if (marker) marker.remove();
            if (marker_modal) marker_modal.remove();

            // Aggiungi un nuovo marker
            marker = new tt.Marker()
                .setLngLat([lon, lat])
                .addTo(map);

            marker_modal = new tt.Marker()
                .setLngLat([lon, lat])
                .addTo(map_modal);

            // Aggiungi evento di click al marker
            marker.getElement().addEventListener("click", () => {
                console.log(`Latitude: ${lat}, Longitude: ${lon}`);
                const googleMapsUrl = `https://www.google.com/maps?q=${lat},${lon}`;
                window.open(googleMapsUrl, "_blank");
            });
        });
        // Aggiungi un nuovo marker
        marker = new tt.Marker()
            .setLngLat([city.position.lon, city.position.lat])
            .addTo(map);

        marker_modal = new tt.Marker()
            .setLngLat([city.position.lon, city.position.lat])
            .addTo(map_modal);

        // Aggiungi un evento di click al marker
        marker.getElement().addEventListener("click", () => {
            const latitude = city.position.lat;
            const longitude = city.position.lon;
            console.log(`Latitude: ${latitude}, Longitude: ${longitude}`);
            const googleMapsUrl = `https://www.google.com/maps?q=${latitude},${longitude}`;
            window.open(googleMapsUrl, "_blank");
        });

        // Gestisci la visibilità del nav_bar quando il modale è mostrato
        $("#exampleModal").on("shown.bs.modal", function() {
            document.getElementById("nav_bar").style.display = "none";
            if (map_modal) {
                // Ricalcola la dimensione della mappa nel modale
                map_modal.resize();
            }
        });
    }
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

    function noScrollPage() {

        console.log('asdasd');
        document.getElementById('main-body').style.overflowY = 'clip';

    }

    function scrollPage() {
        document.getElementById('main-body').style.overflowY = 'auto';

    }
</script>

<style>
    #searchBox {
        position: absolute;
        /* Posizionamento sopra la mappa */
        top: 10px;
        /* Distanza dal bordo superiore della mappa */
        left: 10px;
        /* Distanza dal bordo sinistro della mappa */
        width: 500px;
        /* Larghezza della barra di ricerca */
        z-index: 1000;
        /* Assicurati che sia sopra la mappa */
    }

    /* Stile del campo di input della SearchBox */
    .tt-search-box input {
        width: 100%;
        padding: 10px;
        border: 2px solid #007bff;
        /* Bordo del campo di ricerca */
        border-radius: 4px;
        /* Angoli arrotondati del campo di ricerca */
        font-size: 16px;
        /* Dimensione del testo */
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        /* Ombra leggera */
        transition: border-color 0.3s ease;
        /* Transizione morbida per il colore del bordo */
    }

    /* Stile del campo di input al focus */
    .tt-search-box input:focus {
        border-color: #0056b3;
        /* Colore del bordo al focus */
        outline: none;
        /* Rimuove l'outline predefinito */
    }

    /* Stile del pulsante di ricerca (se presente) */
    .tt-search-box button {
        background-color: #007bff;
        /* Colore di sfondo del pulsante */
        color: #fff;
        /* Colore del testo del pulsante */
        border: none;
        padding: 10px 15px;
        border-radius: 4px;
        /* Angoli arrotondati del pulsante */
        cursor: pointer;
        font-size: 16px;
        transition: background-color 0.3s ease;
        /* Transizione morbida per il colore di sfondo */
    }

    /* Stile del pulsante di ricerca al hover */
    .tt-search-box button:hover {
        background-color: #0056b3;
        /* Colore di sfondo al hover */
    }

    /* Stile dei suggerimenti della ricerca (dropdown) */
    .tt-suggestion {
        padding: 10px;
        border: 1px solid #ddd;
        /* Bordo dei suggerimenti */
        border-top: none;
        background-color: #fff;
        max-height: 200px;
        overflow-y: auto;
        /* Scroll verticale se ci sono molti suggerimenti */
    }

    /* Stile di un suggerimento della ricerca */
    .tt-suggestion:hover {
        background-color: #f8f9fa;
        /* Colore di sfondo del suggerimento al hover */
    }


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
