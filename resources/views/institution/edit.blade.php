@extends('layouts.app')

@section('title', __('institution.edit'))

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">

        <div class="card">
            <div class="card-header">{{ __('institution.edit') }}</div>
            <form method="POST" action="{{ route('institution.store') }}" accept-charset="UTF-8">
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

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="latitude" class="control-label">{{ __('outlet.latitude') }}</label>
                                <input id="latitude" type="text" class="form-control{{ $errors->has('latitude') ? ' is-invalid' : '' }}" name="latitude" value="{{ old('latitude', $institution->latitude) }}" required>
                                {!! $errors->first('latitude', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="longitude" class="control-label">{{ __('outlet.longitude') }}</label>
                                <input id="longitude" type="text" class="form-control{{ $errors->has('longitude') ? ' is-invalid' : '' }}" name="longitude" value="{{ old('longitude', $institution->longitude) }}" required>
                                {!! $errors->first('longitude', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                            </div>
                        </div>
                    </div>
                    <div id="mapid"></div>
                </div>
                <div class="card-footer">
                    <input type="submit" value="{{ __('outlet.update') }}" class="btn btn-success">
                    <a href="{{ route('institution.show') }}" class="btn btn-link">{{ __('app.cancel') }}</a>

                </div>
                <input type="hidden" id="address" name="address" value=''>
            </form>
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
        function updateMarker(lat, lng) {
            marker
                .setLatLng([lat, lng])
                .bindPopup("Адрес :  " + marker.getLatLng().toString())
                .openPopup();
            return false;
        };
        $(function() {
            $('#address').val($('#address_show').text());
        });
        map.on('click', function(e) {
            let latitude = e.latlng.lat.toString().substring(0, 15);
            let longitude = e.latlng.lng.toString().substring(0, 15);
            $('#latitude').val(latitude);
            $('#longitude').val(longitude);
            console.log(latitude,'second', longitude);
            updateMarker(latitude, longitude);
            var geocoder = new google.maps.Geocoder;
            var latlng = {lat: parseFloat(latitude), lng: parseFloat(longitude)};
            let street_address1 = '';
            let street_address2 = '';
            let city = '';
            let address_street = '';
            geocoder.geocode({'location': latlng}, function (results, status) {
                if (status === 'OK') {
                    if (results[0]) {
                        let f_address = results[0].formatted_address;
                        console.log(results[0]);
                        $('#address_show').text(f_address);
                        $('#address').val(f_address);

                        for (var i = 0; i < results[0].address_components.length; i++) {
                            let expr_short = results[0].address_components[i].short_name;
                            let expr_long = results[0].address_components[i].long_name;
                            switch (results[0].address_components[i].types[0]) {
                                case 'locality':
                                    city = expr_long;
                                    console.log('Город ', city);
                                    break;
                                case 'route':
                                    street_address1 = expr_short;
                                    break;
                                case 'street_number':
                                    street_address2 = expr_short;
                                    break;
                            }

                        }

                        address_street = street_address1.concat(', ', street_address2);

                        console.log('street_address', address_street);
                    }
                    if (results[7]) {

                        for (var i = 0; i < results[7].address_components.length; i++) {
                            let expr_long = results[7].address_components[i].long_name;
                            switch (results[7].address_components[i].types[0]) {
                                case 'locality':
                                    city = expr_long;
                                    console.log('Город ', city);
                                    break;
                            }

                        }


                    }

                }
                if (address_street) {
                    if ($('#address_street').length > 0) {
                        $('#address_street').val(address_street);
                    } else {
                        $('input[name="address"]').after("<input type=\"hidden\" id=\"address_street\" name=\"address_street\" value=\"".concat(address_street, "\">"));
                    }
                }
                if (city) {
                    if ($('#address_city').length > 0) {
                        $('#address_city').val(city);
                    } else {
                        $('input[name="address"]').after("<input type=\"hidden\" id=\"address_city\" name=\"address_city\" value=\"".concat(city, "\">"));
                    }
                }
            });


        });
        var updateMarkerByInputs = function () {
            return updateMarker($('#latitude').val(), $('#longitude').val());
        }
        $('#latitude').on('change', updateMarkerByInputs);
        $('#longitude').on('change', updateMarkerByInputs);
    </script>
    <script async defer
            src="https://maps.googleapis.com/maps/api/js?key={!! env('GOOGLE_API') !!}&language=en">
    </script>
@endpush

