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
    <div class="container ">
        <h1>Modifica Tappa: {{ $stage->nome }}</h1>

        <form id="editTappaForm" action="{{ route('journeyStages.update') }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Nome -->
            <div class="form-group">
                <label for="nome">Nome*</label>
                <input type="text" id="nome" name="nome" class="form-control"
                    value="{{ old('nome', $stage->nome) }}">
                <div id="nomeError" class="text-danger" style="display: none;"></div>
            </div>

            <!-- Descrizione -->
            <div class="form-group">
                <label for="descrizione">Descrizione</label>
                <textarea id="descrizione" name="descrizione" class="form-control">{{ old('descrizione', $stage->descrizione) }}</textarea>
                <div id="descrizioneError" class="text-danger" style="display: none;"></div>
            </div>

            <!-- Posizione -->
            <div class="form-group">
                <label for="posizione">Posizione*</label>
                <input type="text" id="posizione" name="posizione" class="form-control"
                    value="{{ old('posizione', $stage->posizione) }}">
                <div id="posizioneError" class="text-danger" style="display: none;"></div>
            </div>

            <!-- Data -->
            <div class="form-group">
                <label for="data">Data</label>
                <input type="date" id="data" name="data" class="form-control"
                    value="{{ old('data', $stage->data) }}">
                <div id="dataError" class="text-danger" style="display: none;"></div>
            </div>

            <!-- Ordine -->
            <div class="form-group">
                <label for="ordine">Ordine*</label>
                <input type="number" id="ordine" name="ordine" class="form-control"
                    value="{{ old('ordine', $stage->ordine) }}">
                <div id="ordineError" class="text-danger" style="display: none;"></div>
            </div>

            <!-- Completata -->
            <div class="form-group">
                <label for="completata">Completata</label>
                <input type="checkbox" id="completata" name="completata" value="{{ $stage->completata }}"
                    @checked($stage->completata ? true : false)>
            </div>

            <input type="hidden" name="stage_id" value="{{ $stage->id }}">
            <input type="hidden" name="trip_id" value="{{ $trip->id }}">

            <small class="d-block mb-2">I campi contrassegnati con * sono <b>obbligatori</b>!</small>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary">Aggiorna Tappa</button>
        </form>
    </div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('editTappaForm').addEventListener('submit', function(event) {
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
