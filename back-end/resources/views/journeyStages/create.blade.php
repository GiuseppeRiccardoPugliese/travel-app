@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Crea una nuova Tappa per il Viaggio: {{ $trip->nome }}</h1>

        <form action="{{ route('journeyStages.store') }}" method="POST">
            @csrf
            @method('POST')

            <div class="form-group">
                <label for="nome">Nome:</label>
                <input type="text" class="form-control" id="nome" name="nome">
            </div>

            <div class="form-group">
                <label for="descrizione">Descrizione:</label>
                <textarea class="form-control" id="descrizione" name="descrizione" rows="3"></textarea>
            </div>

            <div class="form-group">
                <label for="posizione">Posizione:</label>
                <input type="text" class="form-control" id="posizione" name="posizione">
            </div>

            <div class="form-group">
                <label for="data">Data:</label>
                <input type="date" class="form-control" id="data" name="data">
            </div>

            <div class="form-group">
                <label for="ordine">Ordine:</label>
                <input type="number" class="form-control" id="ordine" name="ordine">
            </div>

            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="completata" name="completata">
                <label class="form-check-label" for="completata">Completata</label>
            </div>

            <input type="hidden" name="trip_id" value="{{ $trip->id }}">

            <button type="submit" class="btn btn-primary">Crea Tappa</button>
        </form>
    </div>
@endsection
