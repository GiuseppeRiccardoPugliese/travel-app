@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="container">
            <form id="myForm" action="{{ route('trip.update') }}" method="POST" enctype="multipart/form-data"
                class="mt-4 d-flex flex-column justify-content-center align-items-center">
                @csrf
                @method('PUT')

                <!-- Nome -->
                <div class="input-group mb-3">
                    <label for="nome">Nome*</label>
                    <input type="text" id="nome" name="nome" class="form-control" value="{{ $trip->nome }}">
                    <div id="nomeError" style="color: red; display: none;"></div>
                </div>

                <!-- Descrizione -->
                <div class="input-group mb-3">
                    <label for="descrizione">Descrizione*</label>
                    <textarea id="descrizione" name="descrizione" class="form-control" rows="3">{{ $trip->descrizione }}</textarea>
                    <div id="descrizioneError" style="color: red; display: none;"></div>
                </div>

                <!-- Data Inizio -->
                <div class="input-group mb-3">
                    <label for="data_inizio">Data Inizio*</label>
                    <input type="date" id="data_inizio" name="data_inizio" class="form-control"
                        value="{{ $trip->data_inizio }}">
                    <div id="dataInizioError" style="color: red; display: none;"></div>
                </div>

                <!-- Data Fine -->
                <div class="input-group mb-3">
                    <label for="data_fine">Data Fine*</label>
                    <input type="date" id="data_fine" name="data_fine" class="form-control"
                        value="{{ $trip->data_fine }}">
                    <div id="dataFineError" style="color: red; display: none;"></div>
                </div>

                <!-- Destinazione -->
                <div class="input-group mb-3">
                    <label for="destinazione">Destinazione*</label>
                    <input type="text" id="destinazione" name="destinazione" class="form-control"
                        value="{{ $trip->destinazione }}">
                    <div id="destinazioneError" style="color: red; display: none;"></div>
                </div>

                <!-- Immagine -->
                <div class="input-group mb-3">
                    <label for="immagine">Immagine</label>
                    <input type="file" id="immagine" name="immagine" class="form-control">
                    <div id="immagineError" style="color: red; display: none;"></div>
                    <small class="form-text text-muted">Accetta solo file JPEG, JPG e PNG</small>
                </div>
                {{-- Visualizzazione IMG inserita --}}
                <img id="image_trip" src="{{ asset('storage/' . $trip->immagine) }}" alt="Immagine Trip"
                    style="width: 250px">

                <!-- Submit Button -->
                <div class="input-group justify-content-center">
                    <button type="submit" class="btn btn-primary btn-sm">MODIFICA</button>
                </div>
                <input type="hidden" name="trip_id" value="{{ $trip->id }}">

            </form>
            <small>I campi contrassegnati con * sono <b>obbligatori</b>!</small>
        </div>

    </div>
@endsection


{{-- <script>
    function submitEditForm(id) {
        document.getElementById(`${'EditForm'}${id}`).submit();
    };
</script> --}}
