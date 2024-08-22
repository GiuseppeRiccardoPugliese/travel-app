@extends('layouts.app')

@section('content')
    
<div class="card">
    <div class="container">
        <form id="myForm" action="{{ route('trip.store') }}" method="POST" enctype="multipart/form-data"
        class="mt-4 d-flex flex-column justify-content-center align-items-center">
        @csrf
        @method('POST')

       <!-- Nome -->
       <div class="input-group mb-3">
        <label for="nome">Nome*</label>
        <input type="text" id="nome" name="nome" class="form-control" >
        <div id="nomeError" style="color: red; display: none;"></div>

        <!-- Descrizione -->
    <div class="input-group mb-3">
        <label for="descrizione">Descrizione*</label>
        <textarea id="descrizione" name="descrizione" class="form-control" rows="3"></textarea>
        <div id="descrizioneError" style="color: red; display: none;"></div>
    </div>

    <!-- Data Inizio -->
    <div class="input-group mb-3">
        <label for="data_inizio">Data Inizio*</label>
        <input type="date" id="data_inizio" name="data_inizio" class="form-control" >
        <div id="dataInizioError" style="color: red; display: none;"></div>
    </div>

    <!-- Data Fine -->
    <div class="input-group mb-3">
        <label for="data_fine">Data Fine*</label>
        <input type="date" id="data_fine" name="data_fine" class="form-control" >
        <div id="dataFineError" style="color: red; display: none;"></div>
    </div>

    <!-- Destinazione -->
    <div class="input-group mb-3">
        <label for="destinazione">Destinazione*</label>
        <input type="text" id="destinazione" name="destinazione" class="form-control" >
        <div id="destinazioneError" style="color: red; display: none;"></div>
    </div>

    <!-- Immagine -->
    <div class="input-group mb-3">
        <label for="immagine">Immagine</label>
        <input type="file" id="immagine" name="immagine" class="form-control">
        <div id="immagineError" style="color: red; display: none;"></div>
        <small class="form-text text-muted">Accetta solo file JPEG, JPG e PNG</small>
    </div>

    <!-- Submit Button -->
    <div class="input-group justify-content-center">
        <button type="submit" class="btn btn-primary btn-sm">CREA</button>
    </div>
    </form>
    <small>I campi contrassegnati con * sono <b>obbligatori</b>!</small>
    </div>
    </div>
    
</div>

@endsection