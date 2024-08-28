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

<body class="vh-100">
    <div id="app" class="d-flex flex-column h-100">
        <header class="site-header">
            <div class="container d-flex justify-content-center align-items-center py-3">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <h1 class="travel-app mb-0">
                        <span class="part1">TRA</span><span class="part2">VEL</span><span class="dash">-</span><span
                            class="part3">APP</span>
                    </h1>
                </a>
            </div>
            <h3>@yield('welcome_message')</h3>
        </header>
        @include('nav_bar')



        <main class="mb-4 flex-grow-1">
            @yield('content')
        </main>



        @include('footer')


    </div>

</body>

<script src="https://api.tomtom.com/maps-sdk-for-web/cdn/6.x/6.15.0/maps/maps-web.min.js"></script>

</html>
