@extends('layouts.app')

@section('title', __('outlet.create'))

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">{{ __('outlet.create') }}</div>
            <form method="POST" action="{{ route('outlets.store') }}" accept-charset="UTF-8">
                {{ csrf_field() }}
                <div class="card-body">
                    <div class="form-group">
                        <label for="name" class="control-label">{{ __('outlet.name') }}</label>
                        <input id="name" type="text" placeholder="{{ __('outlet.name_text') }}" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required>
                        {!! $errors->first('name', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                    </div>
                    <div class="form-group">
                        <label for="AP_no" class="control-label">{{ __('outlet.AP_no') }}</label>
                        <input id="AP_no" type="text" class="form-control{{ $errors->has('AP_no') ? ' is-invalid' : '' }}" name="AP_no" value="{{ 1, old('AP_no') }}" required>
                        {!! $errors->first('AP_no', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                    </div>
                    <div class="form-group">
                        <label for="AP_no" class="control-label">{{ __('outlet.info_URL') }}</label>
                        <input id="info_URL" type="text" class="form-control{{ $errors->has('info_URL') ? ' is-invalid' : '' }}" name="info_URL" value="{{ 'https://www.eduroam.ru', old('info_URL') }}" required>
                        {!! $errors->first('info_URL', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                    </div>
                    <div class="form-group">
                        <label for="location_type" class="control-label">{{ __('outlet.location_type') }}</label>
                        <select name="location_type">
                            <option value="3,3">Университет, колледж</option>
                            <option value="2,8">Исследовательский институт</option>
                            <option value="7,3">Общежитие</option>
                        </select>
                    </div>
                    <div class="form-group" >
                        <label> Город:&nbsp; </label> <span id="ad_city">{{ old('address_city') }}</span>
                    </div>
                    <div class="form-group" >
                        <label> Адрес:&nbsp; </label> <span id="ad_street">{{ old('address_street') }}</span>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="latitude" class="control-label">{{ __('outlet.latitude') }}</label>
                                <input id="latitude" type="text" placeholder="{{ __('outlet.address_text') }}" class="form-control{{ $errors->has('latitude') ? ' is-invalid' : '' }}" name="latitude" value="{{ old('latitude') }}" required>
                                {!! $errors->first('latitude', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="longitude" class="control-label">{{ __('outlet.longitude') }}</label>
                                <input id="longitude" type="text" placeholder="{{ __('outlet.address_text') }}" class="form-control{{ $errors->has('longitude') ? ' is-invalid' : '' }}" name="longitude" value="{{ old('longitude') }}" required>
                                {!! $errors->first('longitude', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                            </div>
                        </div>
                    </div>
                    <div id="mapid"></div>
                </div>

                <div class="card-footer">
                    <input type="submit" value="{{ __('outlet.create') }}" class="btn btn-success">
                    <a href="{{ route('outlets.index') }}" class="btn btn-link">{{ __('app.cancel') }}</a>
                </div>
                <input type="hidden" id="address_street" name="address_street" value=''>
                <input type="hidden" id="address_city" name="address_city" value=''>
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

<script>
    let old_lat= $('#latitude').val();
    let old_lon= $('#longitude').val();

    let lat = old_lat ? old_lat : "{{config('leaflet.map_center_latitude')}}";
    let lon = old_lon ? old_lon : "{{config('leaflet.map_center_longitude')}}";

    var mapCenter = [lat,lon];

    console.log(mapCenter);
    var map = L.map('mapid').setView(mapCenter, {{ config('leaflet.zoom_level') }});

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
        $('#address').val($('#address_show').text())
    });
    map.on('click', function(e) {
        let latitude = e.latlng.lat.toString().substring(0, 15);
        let longitude = e.latlng.lng.toString().substring(0, 15);
        $('#latitude').val(latitude);
        $('#longitude').val(longitude);


        updateMarker(latitude, longitude);

        var geocoder = new google.maps.Geocoder;
        var latlng = {lat: parseFloat(latitude), lng: parseFloat(longitude)};
        let street_address1 = '';
        let street_address2 = '';
        let city = '';
        let address_street = '';
        geocoder.geocode({'location': latlng}, function (results, status) {
            if (status === 'OK') {
                //console.log(results);
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
                                break;
                            case 'route':
                                street_address1 = expr_short;
                                break;
                            case 'street_number':
                                street_address2 = expr_short;
                                break;
                        }

                    }

                    address_street = street_address1+', '+street_address2;

                    console.log('street_address: ', address_street);
                    console.log('city ', city);
                }


            }

            /*Заполняем спрятанные поля и лейблы*/

            $('#ad_city').text(city);
            $('#ad_street').text(address_street);
            $('#address_city').attr('value', city);
            $('#address_street').attr('value', address_street);

        });


    });
    var updateMarkerByInputs = function() {
        return updateMarker( $('#latitude').val() , $('#longitude').val());
    };
    $('#latitude').on('input', updateMarkerByInputs);
    $('#longitude').on("input", updateMarkerByInputs);
</script>
<script async defer
        src="https://maps.googleapis.com/maps/api/js?key={!! env('GOOGLE_API') !!}&language=en">
</script>

@endpush
