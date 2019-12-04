@extends('layouts.app')

@section('title', __('institution.edit'))

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">

        <div class="card">
            <div class="card-header">{{ __('institution.show') }}</div>
            <div class="card-body">
                <div class="form-group" >
                    <label> Наименование:&nbsp; </label>{{ $institution->name_en }}
                </div>
                <div class="form-group" >
                    <label> {{ __('outlet.location_type') }}:&nbsp; </label>{{ $institution->loc}}
                </div>
                <div class="form-group" >
                    <label> Город:&nbsp; </label> <span id="ad_city">{{ $institution->address_city }}</span>
                </div>
                <div class="form-group" >
                    <label> Адрес:&nbsp; </label> <span id="ad_street">{{ $institution->address_street }}</span>
                </div>
                <div class="form-group" >{{ __('outlet.contacts') }}<br>
                    @if (!empty($contacts))
                        @foreach($contacts as $key => $contact)
                            {{$key+1}}.&nbsp;{{$contact->name}}<br>
                        @endforeach
                    @endif
                </div>
                <div id="mapid"></div>
            </div>
            <div class="card-footer">
                <a href="{{ route('institution.edit') }}" id="edit-institution-{{ $institution->id }}" class="btn btn-warning">{{ __('institution.edit') }}</a>
                <a href="{{ route('contacts2institution.edit') }}" id="edit-institution" class="btn btn-warning">{{ __('contact.add_contacts') }}</a>

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

    <script>
        var mapCenter = [{{ $institution->latitude > 0 ? $institution->latitude : config('leaflet.map_small_center_lat') }},
            {{$institution->longitude >0 ? $institution->longitude : config('leaflet.map_small_center_lon') }}];
        var map = L.map('mapid').setView( mapCenter,
            {{ config('leaflet.detail_zoom_level') }});


        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);


        var marker = L.marker(mapCenter).addTo(map);

    </script>

@endpush

