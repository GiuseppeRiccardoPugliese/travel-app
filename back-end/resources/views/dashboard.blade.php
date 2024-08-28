@extends('layouts.app')

@section('welcome_message')
{{auth()->user()->sessualità == 'donna' ? 'Benvenuta' : 'Benvenuto'}}, {{ auth()->user()->name }}
@endsection
@section('content')
    @include('search_bar')
    <div class="ps-4 typing-container">
        <h3 class="text_title fw-bold">Lasciati ispirare!</h3>
    </div>
    @include('carousel')
@endsection
