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
    <div class="container">
        <h1>Crea una nuova Tappa per il Viaggio: {{ $trip->nome }}</h1>

        <form id='tappaForm' action="{{ route('journeyStages.store') }}" method="POST">
            @csrf
            @method('POST')

            <div class="form-group">
                <label for="nome">Nome*</label>
                <input type="text" class="form-control" id="nome" name="nome">
                <div id="nomeError" class="text-danger" style="display: none;"></div>
            </div>

            <div class="form-group">
                <label for="descrizione">Descrizione</label>
                <textarea class="form-control" id="descrizione" name="descrizione" rows="3"></textarea>
                <div id="descrizioneError" class="text-danger" style="display: none;"></div>
            </div>

            <div class="form-group">
                <label for="posizione">Posizione*</label>
                <input type="text" class="form-control" id="posizione" name="posizione">
                <div id="posizioneError" class="text-danger" style="display: none;"></div>
            </div>

            <div class="form-group">
                <label for="data">Data</label>
                <input type="date" class="form-control" id="data" name="data">
                <div id="dataError" class="text-danger" style="display: none;"></div>
            </div>

            <div class="form-group">
                <label for="ordine">Ordine*</label>
                <input type="number" class="form-control" id="ordine" name="ordine">
                <div id="ordineError" class="text-danger" style="display: none;"></div>
            </div>

            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="completata" name="completata">
                <label class="form-check-label" for="completata">Completata</label>
            </div>

            <input type="hidden" name="trip_id" value="{{ $trip->id }}">

            <small class="d-block mb-2">I campi contrassegnati con * sono <b>obbligatori</b>!</small>

            <button type="submit" class="btn btn-primary">Crea Tappa</button>
        </form>
    </div>
@endsection
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('tappaForm').addEventListener('submit', function(event) {

            // Reset error messages
            let hasError = false;
            document.querySelectorAll('.text-danger').forEach(function(element) {
                element.style.display = 'none';
            });

            // Validazione Nome
            let nome = document.getElementById('nome').value.trim();
            if (!nome) {
                document.getElementById('nomeError').textContent = 'Il campo Nome è obbligatorio.';
                document.getElementById('nomeError').style.display = 'block';
                hasError = true;
            }

            // Validazione Posizione
            let posizione = document.getElementById('posizione').value.trim();
            if (!posizione) {
                document.getElementById('posizioneError').textContent =
                    'Il campo Posizione è obbligatorio.';
                document.getElementById('posizioneError').style.display = 'block';
                hasError = true;
            }

            // Validazione Data
            let data = document.getElementById('data').value;
            let today = new Date().toISOString().split('T')[0];
            if (data && data < today) {
                document.getElementById('dataError').textContent =
                    'La data non può essere precedente a oggi.';
                document.getElementById('dataError').style.display = 'block';
                hasError = true;
            }

            // Validazione Ordine
            let ordine = document.getElementById('ordine').value;
            if (ordine === '' || ordine < 0) {
                document.getElementById('ordineError').textContent =
                    'Il campo Ordine deve essere un numero positivo.';
                document.getElementById('ordineError').style.display = 'block';
                hasError = true;
            }

            if (hasError) {
                event.preventDefault(); // Blocca l'invio del form se ci sono errori
            }
        });
    });
</script>
