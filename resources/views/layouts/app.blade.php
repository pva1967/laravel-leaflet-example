<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('APP_NAME', 'monitor.eduroam.ru') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
    <script src="https://unpkg.com/leaflet@1.3.1/dist/leaflet.js"
            integrity="sha512-/Nsx9X4HebavoBvEBuyp3I7od5tA0UzAxs+j83KgC8PU0kgB4XiK4Lfe4y4cgBtaRJQEIFCW+oC506aPT2L1zw=="
            crossorigin=""></script>
    <script src="https://unpkg.com/leaflet.markercluster@1.3.0/dist/leaflet.markercluster.js"></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/MarkerCluster.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/MarkerCluster.Default.css') }}" />
    @yield('styles')
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container">
              <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    @if (Request::is('admin/*'))
                    <a href = "/admin/"><img src="http://eduroam.ru/wp-content/uploads/2019/09/eduroam_trans_450pix.png" alt="profile Pic" height="64" width="148"></a>
                    @else
                        <a href = "/"><img src="http://eduroam.ru/wp-content/uploads/2019/09/eduroam_trans_450pix.png" alt="profile Pic" height="64" width="148"></a>
                    @endif
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @if (Request::is('admin/*'))


                            @guest('admin')
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('admin.login') }}">{{ __('auth.Login') }}</a>
                                </li>

                            @endguest

                            @auth('admin')

                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('admin.home') }}">{{ __('admin.dashboard') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('admin.institution.show') }}">{{ __('institution.list') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('admin.contacts.index') }}">{{ __('contact.index') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('admin.outlet_map.index') }}">{{ __('menu.our_outlets') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('admin.outlets.index') }}">{{ __('outlet.list') }}</a>
                                </li>
                                <li class="nav-item dropdown">
                                    <a id="adminDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        {{ Auth::guard('admin')->user()->name }} (ADMIN) <span class="caret"></span>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="adminDropdown">
                                        <a href="{{route('admin.home')}}" class="dropdown-item">Dashboard</a>
                                        <a class="dropdown-item" href="#" onclick="event.preventDefault();document.querySelector('#admin-logout-form').submit();">
                                            Logout
                                        </a>
                                        <form id="admin-logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>
                                    </div>
                                </li>
                            @endauth
                        @else
                            @guest('web')
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('auth.Login') }}</a>
                                </li>
                            <!-- <li class="nav-item">
                                    /* @if (Route::has('register'))
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                       @endif
                                </li> -->
                            @endguest


                            @auth('web')
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('institution.show') }}">{{ __('institution.list') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('contacts.index') }}">{{ __('contact.index') }}</a>
                                </li>
                                <li class="nav-item"><a class="nav-link" href="{{ route('outlet_map.index') }}">{{ __('menu.our_outlets') }}</a></li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('outlets.index') }}">{{ __('outlet.list') }}</a>
                                </li>
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        {{ Auth::guard('web')->user()->name }} <span class="caret"></span>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                        <a href="{{route('home')}}" class="dropdown-item">Dashboard</a>
                                        <a class="dropdown-item" href="#" onclick="event.preventDefault();document.querySelector('#logout-form').submit();">
                                            Logout
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>
                                    </div>
                                </li>
                            @endauth
                        @endif


                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4 container">
            @yield('content')
        </main>
        @include('layouts.partials.footer')
    </div>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
 <script>
     $('a[href="' + window.location.href + '"]').addClass('active');

 </script>
    @stack('scripts')
</body>
</html>
