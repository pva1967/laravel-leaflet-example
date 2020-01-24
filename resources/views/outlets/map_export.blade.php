@extends('layouts.app-small')

@section('title', __('outlet.detail'))


@section('content')
    <div class="card">
        <div class="card-body" id="mapid"></div>
        <div class="card-body">
        <table class="table table-sm table-responsive-sm">
            <thead>
            <tr>
                <th class="text-center">{{ __('app.table_no') }}</th>
                <th>Организация</th>
                <th>{{ __('outlet.name') }}</th>
                <th>{{ __('outlet.address_city') }}</th>
                <th>{{ __('outlet.address_street') }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($outlets as $key => $outlet)
                <tr>
                    <td class="text-center"> {{$key+1 }}</td>
                    <td>{{ $outlet->name_ru }}</td>
                    <td>{{ $outlet->name }}</td>
                    <td>{{ $outlet->address_city }}</td>
                    <td>{{ $outlet->address_street }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
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
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);
        let outlets=[];
        outlets = {!! json_encode($outlets) !!};

        let a=[];
        let markers = new L.MarkerClusterGroup();

                for (let i = 0; i < outlets.length; i++) {
                    let b = outlets[i];
                    let title = b.name;
                    let marker = L.marker(new L.LatLng(b.latitude, b.longitude), { title: title });
                    marker.bindPopup( b.name_ru, "; ", b.address_city, ", ", b.address_street );
                    markers.addLayer(marker);
                }

                map.addLayer(markers);









    </script>
@endpush

