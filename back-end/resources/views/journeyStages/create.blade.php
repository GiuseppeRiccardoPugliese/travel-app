@extends('layouts.app')

@section('content')
    {{-- VALIDATION REQUEST --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Titolo Animato --}}
    <div class="animated-title-create">
        <h1 class="m-0">Crea una nuova Tappa per il Viaggio: {{ $trip->nome }}</h1>
    </div>

    <div class="container">

        <form id='tappaForm' action="{{ route('journeyStages.store') }}" method="POST" class="custom-form">
            @csrf
            @method('POST')

            {{-- Nome --}}
            <div class="form-group mb-3">
                <label class="custom-label" for="nome">Nome*</label>
                <input type="text" class="form-control custom-input" id="nome" name="nome">
                <div id="nomeError" class="custom-error"></div>
            </div>

            {{-- Descrizione --}}
            <div class="form-group mb-3">
                <label class="custom-label" for="descrizione">Descrizione</label>
                <textarea class="form-control custom-input" id="descrizione" name="descrizione" rows="3"></textarea>
                <div id="descrizioneError" class="custom-error"></div>
            </div>

            {{-- Posizione --}}
            <div class="form-group mb-3">
                <label class="custom-label" for="posizione">Posizione*</label>
                <input type="text" class="form-control custom-input" id="posizione" name="posizione">
                <div id="posizioneError" class="custom-error"></div>
            </div>

            {{-- Data --}}
            <div class="form-group mb-3">
                <label class="custom-label" for="data">Data</label>
                <input type="date" class="form-control custom-input" id="data" name="data"
                    min="{{ $data_inizio }}" max="{{ $data_fine }}" value="{{ $data_inizio }}">
                <div id="dataError" class="custom-error"></div>
            </div>

            {{-- Ordine --}}
            <div class="form-group mb-3">
                <label class="custom-label" for="ordine">Giorno*</label>
                <input type="number" class="form-control custom-input" id="ordine" name="ordine" min="1"
                    max="{{ $durata_viaggio }}" value="1">
                <div id="ordineError" class="custom-error"></div>
            </div>

            {{-- Completata --}}
            <div class="form-check mb-3">
                <input type="checkbox" class="form-check-input" id="completata" name="completata">
                <label class="custom-label" for="completata">Completata</label>
            </div>

            <input type="hidden" name="trip_id" value="{{ $trip->id }}">

            <div class="form-group text-center">
                <button type="submit" class="btn btn-primary btn-sm custom-submit-button">Crea Tappa</button>
            </div>

        </form>
        <small class="custom-small-text-center">I campi contrassegnati con * sono <b>obbligatori</b>!</small>
    </div>
@endsection
<script>
    function changeOrNotDay(event) {
        let minGiorno = '{{ $data_inizio }}';
        let maxGiorno = '{{ $data_fine }}';
        // Converto le stringhe di data in oggetti Date
        let dataInizio = new Date(maxGiorno);
        let dataFine = new Date(minGiorno);

        let dataSelezionata = document.getElementById('data').value;

        let selectedDate = new Date(dataSelezionata);
        let startTime = selectedDate.getTime();
        let endTime = dataFine.getTime();

        let giornInMillis = startTime - endTime;

        // Converto la differenza in giorni
        let differenceInDays = Math.floor(giornInMillis / (1000 * 60 * 60 * 24));
        // console.log(document.getElementById('ordine').value = differenceInDays + 1)
    }

    function changeDateorNot(event) {

        let dataInizio = '{{ $data_inizio }}'
        // Numero di giorni da aggiungere
        let giorniDaAggiungere = document.getElementById('ordine').value - 1;

        // Converto giorni in secondi
        let secondiInGiorni = giorniDaAggiungere * 24 * 60 * 60; // giorni * ore/giorno * minuti/ora * secondi/minuto

        // Converto la data iniziale in millisecondi
        let startDate = new Date(dataInizio);
        let startDateInMillis = startDate.getTime();

        // Aggiungo i secondi convertiti in millisecondi
        let nuovaDataInMillis = startDateInMillis + (secondiInGiorni * 1000);

        // Converto la nuova data in formato Date
        let nuovaData = new Date(nuovaDataInMillis);

        // Converto la nuova data in formato YYYY-MM-DD
        let nuovaDataFormato = nuovaData.toISOString().split('T')[0];

        document.getElementById('data').value = nuovaDataFormato  ;
    }
    document.addEventListener('DOMContentLoaded', function() {
        // CAMBIARE GIORNO DALLA DATA
        const dataTappa = document.getElementById('data');
        dataTappa.addEventListener('change', changeOrNotDay);

        // CAMBIARE DATA DAL GIORNO
        const ordineTappa = document.getElementById('ordine');
        ordineTappa.addEventListener('change', changeDateorNot);
        document.getElementById('tappaForm').addEventListener('submit', function(event) {

            // Reset error messages
            let hasError = false;
            document.querySelectorAll('.custom-error').forEach(function(element) {
                element.style.display = 'none';
            });

            // Validazione Nome
            let nome = document.getElementById('nome').value.trim();
            if (!nome) {
                document.getElementById('nomeError').textContent = 'Il campo "Nome" è obbligatorio.';
                document.getElementById('nomeError').style.display = 'block';
                hasError = true;
            }

            // Validazione Posizione
            let posizione = document.getElementById('posizione').value.trim();
            if (!posizione) {
                document.getElementById('posizioneError').textContent =
                    'Il campo "Posizione" è obbligatorio.';
                document.getElementById('posizioneError').style.display = 'block';
                hasError = true;
            }

            // Validazione Data
            let data = document.getElementById('data').value;
            let today = new Date().toISOString().split('T')[0];
            if (data && data < today) {
                document.getElementById('dataError').textContent =
                    'La data non può essere precedente ad oggi.';
                document.getElementById('dataError').style.display = 'block';
                hasError = true;
            }


            // Validazione Ordine

            // variabile per determinare il max dei giorni da mettere nel campo
            let maxGiorni = "{{ $durata_viaggio }}";

            let ordine = document.getElementById('ordine').value;
            if (ordine === '' || ordine < 1) {
                document.getElementById('ordineError').textContent =
                    `Il campo "Giorno" deve essere un numero compreso 1 e ${maxGiorni}`;
                document.getElementById('ordineError').style.display = 'block';
                hasError = true;
            }

            if (hasError) {
                event.preventDefault(); // Blocca l'invio del form se ci sono errori
            }
        });
    });
</script>
