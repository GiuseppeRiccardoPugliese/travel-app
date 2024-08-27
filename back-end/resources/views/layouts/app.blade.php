<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    {{-- FiveIco --}}
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.png') }}">
    {{-- FONT AWESOME --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <!-- Owl Carousel CSS -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" />

    <!-- Owl Carousel JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

    {{-- TOMTOM MAP --}}
    <link rel="stylesheet" href="https://api.tomtom.com/maps-sdk-for-web/cdn/6.x/6.15.0/maps/maps.css">


</head>
<!-- Usando Vite -->
@vite(['resources/js/app.js'])
@vite(['resources/js/maps_scripts.js'])
@vite(['resources/js/search_city_image.js'])
@vite(['resources/js/scroll_page.js'])
</head>

<body>
    <div id="app" class="position-relative">
        <header class="site-header">
            <div class="container d-flex justify-content-center align-items-center py-3">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <h1 class="travel-app mb-0">
                        <span class="part1">TRA</span><span class="part2">VEL</span><span class="dash">-</span><span
                            class="part3">APP</span>
                    </h1>
                </a>
            </div>
            <h3>Benvenuta, {{ auth()->user()->name }}</h3>
        </header>
        <section class=" ps-4 text-dark ">
            <h1 class="text_title fw-bold">Pianifica il tuo viaggio!</h1>
        </section>
        <div class="container p-0 d-flex flex-column ">

            <div class="row w-75 mx-auto multi-colored-border justify-content-center">
                <div class="col-md-4 p-0 border border-0 ">
                    @include('search_bar')
                </div>

                @include('start_date')


                <div class="col-md-12 pe-1">
                    <div id="results" class="border-1 border-black border-0 bg-white pe-1 rounded-2"></div>
                </div>

            </div>
            <div class="row w-75 mx-auto ">


                <div class="col-6 d-flex">
                    <a data-bs-toggle="modal" data-bs-target="#exampleModal" class="w-100">
                        <div id="map" style="height: 400px; width: 100%;" class="mt-3 flex-fill"></div>
                    </a>
                </div>


                <div class="col-6 d-flex">
                    <div id="photo-container"
                        class="mt-3 flex-fill bg-light d-flex justify-content-center align-items-center">
                        <p>Immagine della destinazione <br> non disponibile!</p>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="ModalSearchedCity">Modal title</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body p-0">
                            <!-- Mappa che riempie la larghezza e altezza del modale -->
                            <div id="map_modal" class="w-100" style="height: 600px;"></div>
                        </div>

                    </div>
                </div>
            </div>

            {{-- <section class="rounded-4 mt-4">
                @include('carousel')
            </section> --}}
        </div>
        <div class="ps-4 typing-container">
            <h3 class="text_title fw-bold">Lasciati ispirare!</h3>
        </div>
        <nav id="nav_bar"
            class="navbar navbar-expand-md navbar-light bg-white shadow-sm flex-column align-items-stretch rounded position-fixed end-0 me-4 rounded-pill shadow">
            <div class="container flex-column p-0">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse flex-column" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav flex-column">
                        <li class="nav-item p-3">
                            <a class="nav-link" href="{{ route('trip.index') }}"><i
                                    class="fa-solid fa-earth-europe"></i></a>
                            <span class="icon-text">Viaggi</span>
                        </li>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto flex-column mt-2 mt-md-0">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <i class="fa-solid fa-user"></i>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    {{-- <a class="dropdown-item" href="{{ url('dashboard') }}">{{ __('Dashboard') }}</a> --}}
                                    <a class="dropdown-item" href="{{ url('profile') }}">{{ __('Profilo') }}</a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        {{ __('Esci') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                        class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Contenuto principale -->
        <div class="content">
            <!-- Qui puoi aggiungere il contenuto della tua pagina -->
        </div>



        <main class="">
            @yield('content')
        </main>
    </div>
</body>
<script src="https://api.tomtom.com/maps-sdk-for-web/cdn/6.x/6.15.0/maps/maps-web.min.js"></script>

</html>
