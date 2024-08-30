<nav id="nav_bar"
    class="navbar navbar-expand-md navbar-light bg-white shadow-sm flex-column align-items-stretch rounded position-fixed end-0 me-4 rounded-pill shadow">
    <div class="container flex-column p-0">

        <div class="navbar-collapse flex-column" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            @auth
            <ul class="navbar-nav flex-column">
                <li class="nav-item p-3">
                    <a class="nav-link" href="{{ route('trip.index') }}"><i class="fa-solid fa-earth-europe"></i></a>
                    <span class="icon-text bg-white">Viaggi</span>
                </li>
            </ul>
            @endauth

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto flex-column mt-2 mt-md-0">
                <!-- Authentication Links -->
                @guest
                    <li class="nav-item p-3 pb-1">
                        <a class="nav-link" href="{{ route('login') }}"><i class="fa-solid fa-user-lock"></i></a>
                        <span class="icon-text">Accedi</span>
                    </li>
                    @if (Route::has('register'))
                        <li class="nav-item p-3 pb-2">
                            <a class="nav-link" href="{{ route('register') }}"><i class="fa-solid fa-user-plus"></i></a>
                            <span class="icon-text">Registrati</span>
                        </li>
                    @endif
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            <i class="fa-solid fa-user"></i>
                        </a>

                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            {{-- <a class="dropdown-item" href="{{ url('dashboard') }}">{{ __('Dashboard') }}</a> --}}
                            <a class="dropdown-item" href="{{ url('profile') }}">{{ __('Profilo') }}</a>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                {{ __('Esci') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
