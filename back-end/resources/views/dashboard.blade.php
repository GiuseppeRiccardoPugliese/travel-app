@extends('layouts.app')

@auth
    @section('welcome_message')
        {{ auth()->user()->sessualità == 'donna' ? 'Benvenuta' : 'Benvenuto' }}, {{ auth()->user()->name }}
    @endsection
@endauth
@section('content')
    @include('search_bar')
    <div class="ps-4 typing-container">
        <h4 class="fw-bold mb-0">Lasciati ispirare!</h4>
    </div>
    @include('carousel')
    <div class="ps-4 typing-container2 my-4 d-flex flex-wrap">
        <h4 class="fw-bold mb-0">Oppure guarda i nostri utenti dove sono andati...</h4>
    </div>

    @include('card_carousel')
    
@endsection

