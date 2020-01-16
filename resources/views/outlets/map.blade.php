@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-body" id="mapid"></div>
    </div>
@endsection

@section('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.1/dist/leaflet.css"
          integrity="sha512-Rksm5RenBEKSKFjgI3a41vrjkw4EVPlJ3+OiI65vTjIdo9brlAacEuKOiQ5OFh7cOI1bkDwLqdLw3Zg0cRJAAQ=="
          crossorigin=""/>
        <style>
        #mapid { min-height: 500px; }
    </style>
@endsection
@push('scripts')
    <!-- Make sure you put this AFTER Leaflet's CSS -->
    <script src="https://unpkg.com/leaflet@1.3.1/dist/leaflet.js"
            integrity="sha512-/Nsx9X4HebavoBvEBuyp3I7od5tA0UzAxs+j83KgC8PU0kgB4XiK4Lfe4y4cgBtaRJQEIFCW+oC506aPT2L1zw=="
            crossorigin=""></script>
    <script src="https://unpkg.com/leaflet.markercluster@1.3.0/dist/leaflet.markercluster.js"></script>

    <script>
        var map = L.map('mapid').setView([{{ config('leaflet.map_center_latitude') }}, {{ config('leaflet.map_center_longitude') }}], {{ config('leaflet.zoom_level') }});
        var baseUrl = "{{ url('/') }}";
       var positron  = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);


       let url = '{{route('api.outlets.index')}}'.concat('?user_id=', '{{$user_id}}', '&isAdmin=', '{{$isAdmin}}');

        let a=[];
        let markers = new L.MarkerClusterGroup();
        axios.get(url)
            .then(function (response) {
               a = response.data.features;
                for (var i = 0; i < a.length; i++) {
                    var b = a[i];
                    var title = b.properties.name;
                    var marker = L.marker(new L.LatLng(b.geometry.coordinates[1], b.geometry.coordinates[0]), { title: title });
                    if ( {{$isAdmin}} ) {
                        marker.bindPopup(b.properties.map_admin_popup_content);
                    }
                    else {
                        marker.bindPopup(b.properties.map_popup_content);
                    }
                    markers.addLayer(marker);
                }
                map.addLayer(markers);
            });
       /* let markers = new L.MarkerClusterGroup();

        for (var i = 0; i < addressPoints.length; i++) {
            var a = addressPoints[i];
            var title = a.properties.name;
            var marker = L.marker(new L.LatLng(a.geometry.coordonates[0], a.geometry.coordonates[1]), { title: title });
            marker.bindPopup(a.properties.map_popup_content);
            markers.addLayer(marker);
        }
         map.addLayer(markers);*/




        @can('create', new App\Outlet)
         var theMarker;
        map.on('click', function(e) {
            let latitude = e.latlng.lat.toString().substring(0, 15);
            let longitude = e.latlng.lng.toString().substring(0, 15);
            if (theMarker != undefined) {
                map.removeLayer(theMarker);
            };
            var popupContent = "Your location : " + latitude + ", " + longitude + ".";
            popupContent += '<br><a href="{{ route('outlets.create') }}?latitude=' + latitude + '&longitude=' + longitude + '">Add new outlet here</a>';
            theMarker = L.marker([latitude, longitude]).addTo(map);
            theMarker.bindPopup(popupContent)
            .openPopup();
        });
        @endcan
    </script>
@endpush

