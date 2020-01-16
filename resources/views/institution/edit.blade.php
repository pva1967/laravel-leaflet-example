@extends('layouts.app')

@section('title', __('institution.edit'))

@section('content')

<div class="row justify-content-center">
    <div class="col-md-6">

        <div class="card">
            <div class="card-header">{{ __('institution.edit') }}</div>
            @if (Request::is('admin/*'))
                <form method="POST" action="{{ route('admin.institution.store') }}" accept-charset="UTF-8">
            @else
                <form method="POST" action="{{ route('institution.store') }}" accept-charset="UTF-8">
            @endif
                {{ csrf_field() }}
                <div class="card-body">
                    <div class="form-group" >
                        <label> Наименование:&nbsp; </label>{{ $institution->name_en }}
                    </div>
                    <div class="form-group" >
                        <label> Город:&nbsp; </label> <span id="ad_city">{{ $institution->address_city }}</span>
                    </div>
                    <div class="form-group" >
                        <label> Адрес:&nbsp; </label> <span id="ad_street">{{ $institution->address_street }}</span>
                    </div>
                    <div class="form-group">
                        <label for="location_type" class="control-label">{{ __('outlet.location_type') }}</label>
                        <select name="venue_type">
                            <option value="3,3" {{$institution->venue_type == '3,3'? 'selected':''}}>Университет, колледж</option>
                            <option value="2,8" {{$institution->venue_type == '2,8'? 'selected':''}}>Исследовательский институт</option>
                            <option value="7,3" {{$institution->venue_type == '7,3'? 'selected':''}}>Общежитие</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="info_URL_en" class="control-label" style="width: 250px;">{{ __('admin.info_URL_en') }}</label>
                        <input id="info_URL_en" type="text" name="info_URL_en" value="{{ old('info_URL_en', $institution->info_URL_en, "http://www.eduroam.ru/") }}" required  style="width: 250px;">
                        {!! $errors->first('info_URL_en', '<span class="invalid-feedback" role="alert">Неверный формат URL</span>') !!}

                    </div>
                    <div class="form-group">
                        <label for="info_URL_ru" class="control-label" style="width: 250px;">{{ __('admin.info_URL_ru') }}</label>
                        <input id="info_URL_ru" type="text" name="info_URL_ru" value="{{ old('info_URL_ru', $institution->info_URL_ru,"http://www.eduroam.ru/") }}"   style="width: 250px;">
                        {!! $errors->first('info_URL_ru', '<span class="invalid-feedback" role="alert">Неверный формат URL</span>') !!}
                    </div>
                    <div class="form-group">
                        <label for="policy_URL_en" class="control-label" style="width: 250px;">{{ __('admin.policy_URL_en') }}</label>
                        <input id="policy_URL_en" type="text" name="policy_URL_en" value="{{ old('policy_URL_en', $institution->policy_URL_en, "http://www.eduroam.ru/")}}" required  style="width: 250px;">
                        {!! $errors->first('policy_URL_en', '<span class="invalid-feedback" role="alert">Неверный формат URL</span>') !!}
                    </div>
                    <div class="form-group">
                        <label for="policy_URL_ru" class="control-label" style="width: 250px;">{{ __('admin.policy_URL_ru') }}</label>
                        <input id="policy_URL_ru" type="text" name="policy_URL_ru" value="{{ old('policy_URL_ru', $institution->policy_URL_ru, "http://www.eduroam.ru/")}}"   style="width: 250px;">
                        {!! $errors->first('policy_URL_ru', '<span class="invalid-feedback" role="alert">Неверный формат URL</span>') !!}
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="latitude" class="control-label">{{ __('institution.latitude') }}</label>
                                <input id="latitude" type="text" class="form-control{{ $errors->has('latitude') ? ' is-invalid' : '' }}" name="latitude" value="{{ old('latitude', $institution->latitude) }}" required>
                                {!! $errors->first('latitude', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="longitude" class="control-label">{{ __('institution.longitude') }}</label>
                                <input id="longitude" type="text" class="form-control{{ $errors->has('longitude') ? ' is-invalid' : '' }}" name="longitude" value="{{ old('longitude', $institution->longitude) }}" required>
                                {!! $errors->first('longitude', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                            </div>
                        </div>
                    </div>
                    <div id="mapid"></div>
                </div>
                <div class="card-footer">
                    <input type="submit" value="{{ __('institution.update') }}" class="btn btn-success">
                    @if (Request::is('admin/*')) <a href="{{ route('admin.institution.show') }}" class="btn btn-link">{{ __('app.cancel') }}</a>
                    @else <a href="{{ route('institution.show') }}" class="btn btn-link">{{ __('app.cancel') }}</a>
                    @endif

                </div>
                <input type="hidden" id="address_street" name="address_street" value='{{ $institution->address_street }}'>
                <input type="hidden" id="address_city" name="address_city" value='{{ $institution->address_city }}'>
            </form>
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
        var L = window.L;
        var mapCenter = [{{ $institution->latitude > 0 ? $institution->latitude : config('leaflet.map_small_center_lat') }}, {{$institution->longitude >0 ? $institution->longitude : config('leaflet.map_small_center_lon') }}];
        var map = L.map('mapid').setView( mapCenter,
            {{ config('leaflet.detail_zoom_level' ) }});

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
        }
        $(function() {
            $('#address').val($('#address_show').text());
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
        var updateMarkerByInputs = function () {
            return updateMarker($('#latitude').val(), $('#longitude').val());
        };
        $('#latitude').on('change', updateMarkerByInputs);
        $('#longitude').on('change', updateMarkerByInputs);
    </script>
    <script async defer
            src="https://maps.googleapis.com/maps/api/js?key={!! env('GOOGLE_API') !!}&language=en">
    </script>
@endpush

