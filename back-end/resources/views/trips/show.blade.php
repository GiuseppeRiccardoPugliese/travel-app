@extends('layouts.app')

@section('content')
    {{-- Sezione dei viaggi --}}
    <div class="container">
        <div class="d-flex justify-content-center">

            <h2 class="">Viaggio a: {{ $trip->nome }}</h2 class="mx-auto">
        </div>
        <div class="row">

            <div class="col-6 d-flex">
                <div id="photo-container" class="mt-3 flex-fill  d-flex justify-content-center align-items-center">
                    @if ($trip->immagine)
                        <img src="{{ asset('storage/' . $trip->immagine) }}" class=" h-100 w-100" alt="{{ $trip->nome }}">
                    @else
                        <p id="no-photo-container" class="">Immagine della destinazione non disponibile!</p>
                    @endif
                </div>
            </div>


            <div class="col-6 d-flex" onmouseover="noScrollPage()" onmouseout="scrollPage()">
                <div id="map-trip" style="height: 400px; width: 100%;position: relative;" class="mt-3 flex-fill">
                    <div id="searchBox"></div>
                </div>

            </div>
            <h2 class="my-2">Tappe del Viaggio</h2>
            @if ($trip->journeyStages->isEmpty())
                <p>Nessun stage disponibile per questo viaggio.</p>
            @else
                <div class="col-8">
                    <div class="accordion mt-4" id="accordionExample">
                        @foreach ($trip->journeyStages as $stage)
                        <div class="d-flex gap-2 pb-2">
                            <div class="accordion-item flex-grow-1">
                                <div class="accordion-header"
                                    id="heading{{ $stage->id }}">
                                    <a class="accordion-button text-decoration-none" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapse{{ $stage->id }}"
                                        aria-expanded="{{ $loop->first ? 'true' : 'false' }}" aria-controls="collapse{{ $stage->id }}" style="">
                                        <div class="d-flex justify-content-between flex-grow-1 gap-2">
                                            <span class="card-title">Tappa Giorno {{ $stage->ordine }}</span>
                                            <div class="d-flex gap-3 me-4 flex-grow-1 justify-content-between">
                                                <span class="flex-grow-1">{{ $stage->posizione }}</span>
                                                <div class="d-flex gap-4 justify-content-center">
                                                    <span class=""><i class="fa-solid fa-plane-departure "></i>
                                                        {{ \Carbon\Carbon::parse($trip->data_inizio)->setTimezone('Europe/Rome')->locale('it')->isoFormat('DD-MM-YYYY') }}
                                                    </span>
                                                    <span class=""><i class="fa-solid fa-plane-arrival"></i>
                                                        {{ \Carbon\Carbon::parse($trip->data_fine)->setTimezone('Europe/Rome')->locale('it')->isoFormat('DD-MM-YYYY') }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div id="collapse{{ $stage->id }}" class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}"
                                    aria-labelledby="heading{{ $stage->id }}" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        {{ $stage->descrizione != null ? $stage->descrizione : 'Descrizione non disponibile' }}
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex flex-column gap-4 align-self-center align-items-center">
                                <a onclick="submitEditForm({{ $stage->id }})"
                                    class="button text-decoration-none text-dark" style="cursor:pointer;">
                                    <i class="fa-solid fa-sliders"></i>
                                </a>
                                {{-- Funct che al click mi passa gli Id --}}
                                <a onclick="receiveIds({{ $trip->id }}, {{ $stage->id }})" type="submit"
                                    data-bs-toggle="modal" data-bs-target="#deleteModal"><i
                                        class="fa-solid fa-trash"></i></a>
                            </div>
                    
                            {{-- DELETE --}}
                            <form action="{{ route('journeyStages.destroy') }}" method="POST" style="display: inline;"
                                id="DestroyForm{{ $trip->id }}_{{ $stage->id }}">
                                @csrf
                                @method('DELETE')
                    
                                <input type="hidden" name="trip_id" value="{{ $trip->id }}">
                                <input type="hidden" name="stage_id" value="{{ $stage->id }}">
                            </form>
                            {{-- Form per passare il trip_id nascosto EDIT --}}
                            <form action="{{ route('journeyStages.edit') }}" method="POST"
                                id="EditStageForm{{ $stage->id }}">
                                @csrf
                                @method('POST')
                    
                                <input type="hidden" name="trip_id" value="{{ $trip->id }}">
                                <input type="hidden" name="stage_id" value="{{ $stage->id }}">
                            </form>
                        </div>
                    @endforeach
                    
                    </div>
                </div>
            @endif
            @php
                $class = !$trip->journeyStages->isEmpty() ? 'offset-1' : '';
            @endphp
            <div class="col-auto mt-2 {{ $class }}">

                {{-- //ROTTA PER LA CREATE DELLA TAPPA --}}
                <button type="button" class="btn btn-success rounded-pill" onclick="submitForm()">Aggiungi una nuova
                    tappa</button>
            </div>
        </div>
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



    {{-- Sezione per gli Stages del Viaggio --}}



    {{-- Form per passare il trip_id nascosto CREATE --}}
    <form action="{{ route('journeyStages.create') }}" method="POST" id="CreateStageForm">
        @csrf
        @method('POST')

        <input type="hidden" name="trip_id" value="{{ $trip->id }}">

    </form>


    {{-- MODAL --}}
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
@endsection
<script src="https://api.tomtom.com/maps-sdk-for-web/cdn/6.x/6.15.0/maps/maps-web.min.js"></script>
<script src="https://api.tomtom.com/maps-sdk-for-web/cdn/6.x/6.1.2-public-preview.15/services/services-web.min.js">
</script>

<script src="https://api.tomtom.com/maps-sdk-for-web/cdn/plugins/SearchBox/3.1.3-public-preview.0/SearchBox-web.js">
</script>

<script>
    document.addEventListener('DOMContentLoaded', async function() {
        function getRandomColor() {
        const letters = '0123456789ABCDEF';
        let color = '#';
        for (let i = 0; i < 6; i++) {
            color += letters[Math.floor(Math.random() * 16)];
        }
        return color;
    }

    
    function lightenColor(color, percent) {
        const num = parseInt(color.slice(1), 16);
        const r = Math.min(255, Math.max(0, (num >> 16) + percent));
        const g = Math.min(255, Math.max(0, ((num >> 8) & 0x00FF) + percent));
        const b = Math.min(255, Math.max(0, (num & 0x0000FF) + percent));
        return `#${(1 << 24 | r << 16 | g << 8 | b).toString(16).slice(1).toUpperCase()}`;
    }

    
    function getGradientFromBaseColor(baseColor) {
        const lightColor = lightenColor(baseColor, 30); 
        return `linear-gradient(to right, ${baseColor}, ${lightColor})`;
    }

    
    const baseColor = getRandomColor();

    document.querySelectorAll('.accordion-item').forEach((item, index) => {
        const baseColor = getRandomColor(); 
        const gradient = getGradientFromBaseColor(baseColor);
        
        const button = item.querySelector('.accordion-button');
        if (button) {
            button.style.background = gradient;
        }

  
    });
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
    async function fetchCityPhotos(city) {
        console.log(city);
        const accessKey = "QngG7sfBVMWvG3kVsWuLqkCRWftkIHIqNHRRsI6fp0I"; // Sostituisci con la tua chiave API
        const url = `https://api.unsplash.com/search/photos?query=${city}`;
        try {
            const response = await fetch(`${url}&client_id=${accessKey}`);
            if (!response.ok) {
                throw new Error("Network response was not ok");
            }
            const data = await response.json();
            console.log(data.results);

            displayPhotos(data.results, city);
        } catch (error) {
            console.error("Error fetching photos:", error);
        }
    }

    let map, map_modal, marker, marker_modal;

    function selectCity(city) {
        fetchCityPhotos(city.address.freeformAddress);
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

    function displayPhotos(photos, city) {
        // Recupera l'elemento contenitore per le foto
        const container = document.getElementById("photo-container");

        // Verifica se c'è già un'immagine e controlla il suo attributo 'alt'
        const existingImg = container.querySelector('img');
        if (existingImg && (existingImg.getAttribute('alt') == 'Photo' || existingImg.getAttribute('alt') == city)) {
            return; // Se l'immagine esistente ha già l'attributo 'alt' uguale a 'Photo' o alla città, esce dalla funzione
        } else {

            const lastElement = container.lastElementChild;
            container.innerHTML = "";
            container.append(lastElement);

            // Seleziona un indice casuale per l'immagine da mostrare
            let numeroCasuale = Math.round(getRandomDecimal(0, photos.length - 1));
            console.log(numeroCasuale);

            // Controlla se la descrizione o i tag dell'immagine corrispondono alla città
            if (
                photos[numeroCasuale].description?.toLowerCase().includes("city") ||
                (typeof city === 'string' &&
                    photos[numeroCasuale].tags[0]?.title?.toLowerCase().includes(city.toLowerCase()))
            ) {
                // Nasconde il messaggio "nessuna foto" se viene trovata una foto valida
                document.getElementById('no-photo-container').classList.add('d-none');
                // Crea un nuovo elemento immagine
                const img = document.createElement("img");
                img.src = photos[numeroCasuale].urls.regular;
                img.alt = "Photo";
                img.style.height = "400px";
                img.classList.add("drop-in-image", "w-100", "object-fit-cover", 'rounded-3');
                // Aggiunge l'immagine al contenitore
                container.appendChild(img);
            } else {
                document.getElementById('no-photo-container').classList.add('d-none');

            }
        }
    }

    function getRandomDecimal(min, max) {
        return Math.random() * (max - min) + min;
    }
</script>

<style>
    div.mapboxgl-canvas-container:nth-child(3)>canvas:nth-child(1) {
        width: 100%;
        height: 100%;
    }




    .accordion-button {
        display: flex;
        align-items: center;
    }

    .accordion-button .card-img {
        width: 50px;
        height: 50px;
        object-fit: cover;
        margin-right: 15px;
    }


    .accordion-button:not(.collapsed) {
        background-color: #f8f9fa;
        /* Optional: Highlight the active card */
    }

    #searchBox {
        position: absolute;
        /* Posizionamento sopra la mappa */
        top: 10px;
        /* Distanza dal bordo superiore della mappa */
        left: 10px;
        /* Distanza dal bordo sinistro della mappa */
        width: 20vw;
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
