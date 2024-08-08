@extends('layouts.app')
@section('content')
    <head>
        @vite(['resources/js/maps_scripts.js'])
    </head>
    {{-- TOMTOM LINK - MAP --}}

    <head>
        <link rel="stylesheet" href="https://api.tomtom.com/maps-sdk-for-web/cdn/6.x/6.15.0/maps/maps.css">
    </head>


    <div>
        <input type="text" id="search_city" placeholder="Inserisci citt&agrave" name="search_city">
        <button type="submit" onclick="ricerca()">Cerca</button>
    </div>
    <div id="results"></div>

    <div id="city"></div>
    <div id="map" style="height: 500px;width:500px"></div>

    <script src="https://api.tomtom.com/maps-sdk-for-web/cdn/6.x/6.15.0/maps/maps-web.min.js"></script>
@endsection
