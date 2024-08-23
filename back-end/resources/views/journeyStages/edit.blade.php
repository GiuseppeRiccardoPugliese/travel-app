@extends('layouts.app')

@section('content')
    <div class="container ">
        <h1>Modifica Tappa</h1>

        <form action="{{ route('journeyStages.update') }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Nome -->
            <div class="form-group">
                <label for="nome">Nome*</label>
                <input type="text" id="nome" name="nome" class="form-control" value="{{ old('nome', $stage->nome) }}"
                    required>
            </div>

            <!-- Descrizione -->
            <div class="form-group">
                <label for="descrizione">Descrizione</label>
                <textarea id="descrizione" name="descrizione" class="form-control">{{ old('descrizione', $stage->descrizione) }}</textarea>
            </div>

            <!-- Posizione -->
            <div class="form-group">
                <label for="posizione">Posizione</label>
                <input type="text" id="posizione" name="posizione" class="form-control"
                    value="{{ old('posizione', $stage->posizione) }}">
            </div>

            <!-- Data -->
            <div class="form-group">
                <label for="data">Data</label>
                <input type="date" id="data" name="data" class="form-control"
                    value="{{ old('data', $stage->data) }}">
            </div>

            <!-- Ordine -->
            <div class="form-group">
                <label for="ordine">Ordine</label>
                <input type="number" id="ordine" name="ordine" class="form-control"
                    value="{{ old('ordine', $stage->ordine) }}">
            </div>

            <!-- Completata -->
            <div class="form-group">
                <label for="completata">Completata</label>
                <input type="checkbox" id="completata" name="completata" value="1"
                    {{ old('completata', $stage->completata) ? 'checked' : '' }}>
            </div>

            <input type="hidden" name="id" value="{{ $stage->id }}">
            <input type="hidden" name="trip_id" value="{{ $trip->id }}">

            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary">Aggiorna Tappa</button>
        </form>
    </div>
< @endsection
