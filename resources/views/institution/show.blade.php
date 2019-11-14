@extends('layouts.app')

@section('title', __('institution.edit'))

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">

        <div class="card">
            <div class="card-header">{{ __('institution.show') }}</div>
                {{ csrf_field() }}
                <div class="card-body">
                    <div class="form-group" >
                        <label> Наименование:&nbsp; </label>{{ $institution->name_en }}
                    </div>
                    <div class="form-group" >
                        <label> Город:&nbsp; </label> {{ $institution->address_city }}
                    </div>
                    <div class="form-group" >
                        <label> Адрес:&nbsp; </label> {{ $institution->address_street }}
                    </div>

                    <div id="mapid"></div>
                </div>
                <div class="card-footer">
                    <a href="{{ route('institution.edit') }}" id="edit-outlet-{{ $institution->id }}" class="btn btn-warning">{{ __('institution.edit') }}</a>

                </div>

        </div>
    </div>
</div>
@endsection
@section('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.1/dist/leaflet.css"
          integrity="sha512-Rksm5RenBEKSKFjgI3a41vrjkw4EVPlJ3+OiI65vTjIdo9brlAacEuKOiQ5OFh7cOI1bkDwLqdLw3Zg0cRJAAQ=="
          crossorigin=""/>

    <style>
        #mapid { height: 300px; }
    </style>
@endsection

@push('scripts')
    <script src="https://unpkg.com/leaflet@1.3.1/dist/leaflet.js"
            integrity="sha512-/Nsx9X4HebavoBvEBuyp3I7od5tA0UzAxs+j83KgC8PU0kgB4XiK4Lfe4y4cgBtaRJQEIFCW+oC506aPT2L1zw=="
            crossorigin=""></script>
    <script>
        var mapCenter = [{{ $institution->latitude > 0 ? $institution->latitude : config('leaflet.map_small_center_lat') }},
            {{$institution->longitude >0 ? $institution->longitude : config('leaflet.map_small_center_lon') }}];
        var map = L.map('mapid').setView( mapCenter,
            {{ config('leaflet.zoom_level') }});

        console.log (map);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);


        var marker = L.marker(mapCenter).addTo(map);

    </script>

@endpush

