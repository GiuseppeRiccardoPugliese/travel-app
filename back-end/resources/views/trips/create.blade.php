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
        <h1 class="m-0">Crea il tuo viaggio</h1>
    </div>

    <div class="container">
        <form id="myForm" action="{{ route('trip.store') }}" method="POST" enctype="multipart/form-data" class="custom-form">
            @csrf
            @method('POST')

            <!-- Nome -->
            <div class="form-group mb-3">
                <label class="custom-label" for="nome">Nome*</label>
                <input type="text" id="nome" name="nome" class="form-control custom-input">
                <div id="nomeError" class="custom-error"></div>
            </div>

            <!-- Descrizione -->
            <div class="form-group mb-3">
                <label class="custom-label" for="descrizione">Descrizione</label>
                <textarea id="descrizione" name="descrizione" class="form-control custom-input" rows="3"></textarea>
                <div id="descrizioneError" class="custom-error"></div>
            </div>

            <!-- Data Inizio -->
            <div class="form-group mb-3">
                <label class="custom-label" for="data_inizio">Data Inizio*</label>
                <input type="date" id="data_inizio" name="data_inizio" class="form-control custom-input" min="{{$dateToday}}" value="{{$dateToday}}">
                <div id="dataInizioError" class="custom-error"></div>
            </div>

            <!-- Data Fine -->
            <div class="form-group mb-3">
                <label class="custom-label" for="data_fine">Data Fine</label>
                <input type="date" id="data_fine" name="data_fine" class="form-control custom-input" min="{{$dateToday}}" value="{{$dateToday}}">
                <div id="dataFineError" class="custom-error"></div>
            </div>

            <!-- Destinazione -->
            <div class="form-group mb-3">
                <label class="custom-label" for="destinazione">Destinazione*</label>
                <input type="text" id="destinazione" name="destinazione" class="form-control custom-input">
                <div id="destinazioneError" class="custom-error"></div>
            </div>

            <!-- Immagine -->
            <div class="form-group mb-3">
                <label class="custom-label" for="immagine">Immagine</label>
                <input type="file" id="immagine" name="immagine" class="form-control custom-input">
                <div id="immagineError" class="custom-error"></div>
                <small class="custom-small-text">Accetta solo file JPEG, JPG
                    e PNG</small>
            </div>

            <!-- Submit Button -->
            <div class="form-group text-center">
                <button type="submit" class="btn btn-primary btn-sm custom-submit-button">CREA</button>
            </div>
        </form>
        <small class="custom-small-text-center">I campi contrassegnati con * sono
            <b>obbligatori</b>!</small>
    </div>
@endsection

<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById('myForm').addEventListener('submit', function(event) {
            // Reset error mclass="custom-error" essages
            let isValid = true;
            resetErrors();

            // Nome: richiesto, massimo 255 caratteri
            let nome = document.getElementById('nome').value;
            if (nome === '' || nome.length > 255) {
                showError('nomeError',
                    'Il campo "Nome" è obbligatorio.');
                isValid = false;
            }

            // Descrizione: opzionale
            let descrizione = document.getElementById('descrizione').value;
            if (descrizione !== '' && typeof descrizione !== 'string') {
                showError('descrizioneError', 'Il campo "Descrizione" deve essere un testo valido.');
                isValid = false;
            }

            // Data Inizio: richiesto, deve essere odierna o futura
            let dataInizio = document.getElementById('data_inizio').value;
            if (dataInizio === '' || new Date(dataInizio) < new Date().setHours(0, 0, 0, 0)) {
                showError('dataInizioError',
                    'Il campo "Data Inizio" è obbligatorio e deve essere odierna o futura.');
                isValid = false;
            }

            // Data Fine: opzionale, deve essere uguale o successiva a Data Inizio
            let dataFine = document.getElementById('data_fine').value;
            if (dataFine !== '' && new Date(dataFine) < new Date(dataInizio)) {
                showError('dataFineError',
                    'Il campo "Data Fine" deve essere uguale o successivo alla "Data Inizio".');
                isValid = false;
            }

            // Destinazione: richiesto, massimo 255 caratteri
            let destinazione = document.getElementById('destinazione').value;
            if (destinazione === '' || destinazione.length > 255) {
                showError('destinazioneError',
                    'Il campo "Destinazione" è obbligatorio.');
                isValid = false;
            }

            // Immagine: opzionale, accetta solo file JPEG, JPG e PNG
            let immagine = document.getElementById('immagine').files[0];
            if (immagine) {
                let allowedExtensions = ['image/jpeg', 'image/jpg', 'image/png'];
                if (!allowedExtensions.includes(immagine.type)) {
                    showError('immagineError',
                        'Il campo "Immagine" deve essere un file di tipo JPEG, JPG o PNG.');
                    isValid = false;
                }
            }

            // Prevent form submission if validation fails
            if (!isValid) {
                event.preventDefault(); // Blocco l'invio del form
            }
        });

        // Function to show error messages
        function showError(elementId, message) {
            document.getElementById(elementId).innerText = message;
            document.getElementById(elementId).style.display = 'block';
        }

        // Function to reset error messages
        function resetErrors() {
            document.querySelectorAll('[id$="Error"]').forEach(function(element) {
                element.style.display = 'none';
                element.innerText = '';
            });
        }
    });
</script>
