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
                <input type="date" class="form-control custom-input" id="data" name="data">
                <div id="dataError" class="custom-error"></div>
            </div>

            {{-- Ordine --}}
            <div class="form-group mb-3">
                <label class="custom-label" for="ordine">Ordine*</label>
                <input type="number" class="form-control custom-input" id="ordine" name="ordine">
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
    document.addEventListener('DOMContentLoaded', function() {
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
            let ordine = document.getElementById('ordine').value;
            if (ordine === '' || ordine < 0) {
                document.getElementById('ordineError').textContent =
                    'Il campo "Ordine" deve essere un numero positivo.';
                document.getElementById('ordineError').style.display = 'block';
                hasError = true;
            }

            if (hasError) {
                event.preventDefault(); // Blocca l'invio del form se ci sono errori
            }
        });
    });
</script>
