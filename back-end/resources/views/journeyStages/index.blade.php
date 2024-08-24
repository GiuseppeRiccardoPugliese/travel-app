@extends('layouts.app')

@section('content')
    @php
        $alertClass = 'alert-success'; // default class for green

        if ($codice == 1) {
            $alertClass = 'alert-success'; // Green
            $messaggio = 'Tappa creata con successo.';
        } elseif ($codice == 2) {
            $alertClass = 'alert-info'; // Blue
            $messaggio = 'Tappa aggiornata con successo.';
        } elseif ($codice == 3) {
            $alertClass = 'alert-danger'; // Red
            $messaggio = 'Tappa eliminata con successo.';
        } else {
            $alertClass = 'alert-secondary'; // Default for unknown
            $messaggio = 'Operazione sconosciuta.';
        }
    @endphp

    <div class="alert {{ $alertClass }} custom-alert" role="alert">
        <i class="fas fa-check-circle"></i>
        {{ $messaggio }}
    </div>

    <form action="{{ route('trip.show') }}" method="POST" id="ShowForm">
        @csrf
        @method('POST')

        <input type="hidden" id="trip_id" name="trip_id" value="{{ $trip->id }}">
    </form>
@endsection

<script>
    document.addEventListener("DOMContentLoaded", (event) => {
        setTimeout(() => {
            document.getElementById('ShowForm').submit();
        }, 10000); // Invia il form dopo 2 secondi
    });
</script>

<style>
    .custom-alert {
        position: relative;
        padding: 20px;
        border-radius: 0.75rem;
        color: #fff;
        font-size: 1.125rem;
        text-align: center;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        animation: slideIn 1s ease-in-out, fadeIn 1s ease-in-out;
        overflow: hidden;
    }

    .alert-success {
        background: linear-gradient(135deg, #d4edda 0%, #a0d6a2 100%);
        border: 1px solid #d4edda;
    }

    .alert-info {
        background: linear-gradient(135deg, #d1ecf1 0%, #a1d4e6 100%);
        border: 1px solid #d1ecf1;
    }

    .alert-danger {
        background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
        border: 1px solid #f8d7da;
    }

    .alert-secondary {
        background: linear-gradient(135deg, #e2e3e5 0%, #c6c8ca 100%);
        border: 1px solid #e2e3e5;
    }

    .custom-alert i {
        margin-right: 15px;
        font-size: 1.75rem;
        animation: pulse 1s infinite;
    }

    @keyframes slideIn {
        from {
            transform: translateY(-50px);
            opacity: 0;
        }

        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }

    @keyframes pulse {
        0% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.2);
        }

        100% {
            transform: scale(1);
        }
    }
</style>
