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


        <main class="py-4 container">
            @yield('content')
        </main>

    </div>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
 <script>
     $('a[href="' + window.location.href + '"]').addClass('active');

 </script>
    @stack('scripts')
</body>
</html>
