@extends('layouts.app')

@section('title', __('outlet.edit'))

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        @if (request('action') == 'delete' && $outlet)
            <div class="card">
                <div class="card-header">{{ __('outlet.delete') }}</div>
                <div class="card-body">
                    <label class="control-label text-primary">{{ __('outlet.name') }}</label>
                    <p>{{ $outlet->name }}</p>
                    <div class="form-group" >
                        <label> Город:&nbsp; </label> <span id="ad_city">{{ $outlet->address_city }}</span>
                    </div>
                    <div class="form-group" >
                        <label> Адрес:&nbsp; </label> <span id="ad_street">{{ $outlet->address_street }}</span>
                    </div>
                    <label class="control-label text-primary">{{ __('outlet.latitude') }}</label>
                    <p>{{ $outlet->latitude }}</p>
                    <label class="control-label text-primary">{{ __('outlet.longitude') }}</label>
                    <p>{{ $outlet->longitude }}</p>
                    {!! $errors->first('outlet_id', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                </div>
                <hr style="margin:0">
                <div class="card-body text-danger">{{ __('outlet.delete_confirm') }}</div>
                <div class="card-footer">
                    @if (Request::is('admin/*'))
                        <form method="POST" action="{{ route('admin.outlets.destroy', $outlet) }}" accept-charset="UTF-8" onsubmit="return confirm({{ __('app.delete_confirm') }})" class="del-form float-right" style="display: inline;">
                    @else
                        <form method="POST" action="{{ route('outlets.destroy', $outlet) }}" accept-charset="UTF-8" onsubmit="return confirm({{ __('app.delete_confirm') }})" class="del-form float-right" style="display: inline;">
                    @endif
                        {{ csrf_field() }} {{ method_field('delete') }}
                        <input name="outlet_id" type="hidden" value="{{ $outlet->id }}">
                        <button type="submit" class="btn btn-danger">{{ __('app.delete_confirm_button') }}</button>
                    </form>
                    @if (Request::is('admin/*'))
                        <a href="{{ route('admin.outlets.edit', $outlet) }}" class="btn btn-link">{{ __('app.cancel') }}</a>
                    @else
                        <a href="{{ route('outlets.edit', $outlet) }}" class="btn btn-link">{{ __('app.cancel') }}</a>
                    @endif
                </div>
            </div>
        @else
        <div class="card">
            <div class="card-header">{{ __('outlet.edit') }}</div>
            @if (Request::is('admin/*'))
                <form method="POST" action="{{ route('admin.outlets.update', $outlet) }}" accept-charset="UTF-8" id="contact_create">
            @else
                <form method="POST" action="{{ route('outlets.update', $outlet) }}" accept-charset="UTF-8" id="contact_create">
            @endif
                {{ csrf_field() }} {{ method_field('patch') }}
                <div class="card-body">
                    <div class="form-group">
                        <label for="name" class="control-label">{{ __('outlet.name') }}</label>
                        <input id="name" type="text"  class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name', $outlet->name) }}" required>
                        {!! $errors->first('name', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                    </div>
                    <div class="form-group">
                        <label for="AP_no" class="control-label">{{ __('outlet.AP_no') }}</label>
                        <input id="AP_no" type="text" class="form-control{{ $errors->has('AP_no') ? ' is-invalid' : '' }}" name="AP_no" value="{{ old('AP_no', $outlet->AP_no) }}" required>
                        {!! $errors->first('AP_no', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                    </div>
                    <div class="form-group">
                        <label for="AP_no" class="control-label">{{ __('outlet.info_URL') }}</label>
                        <input id="info_URL" type="text" class="form-control{{ $errors->has('info_URL') ? ' is-invalid' : '' }}" name="info_URL" value="{{ old('info_URL', $outlet->info_URL) }}" required>
                        {!! $errors->first('info_URL', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                    </div>
                    <div class="form-group">
                        <label for="location_type" class="control-label">{{ __('outlet.location_type') }}</label>
                        <select name="location_type">
                            <option value="3,3" {{$outlet->location_type == '3,3'? 'selected':''}}>Университет, колледж</option>
                            <option value="2,8" {{$outlet->location_type == '2,8'? 'selected':''}}>Исследовательский институт</option>
                            <option value="7,3" {{$outlet->location_type == '7,3'? 'selected':''}}>Общежитие</option>
                        </select>
                    </div>
                    <div class="form-group" >
                        <label> Город:&nbsp; </label> <span id="ad_city">{{ $outlet->address_city }}</span>
                    </div>
                    <div class="form-group" >
                        <label> Адрес:&nbsp; </label> <span id="ad_street">{{ $outlet->address_street }}</span>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="latitude" class="control-label">{{ __('outlet.latitude') }}</label>
                                <input id="latitude" type="text" class="form-control{{ $errors->has('latitude') ? ' is-invalid' : '' }}" name="latitude" value="{{ old('latitude', $outlet->latitude) }}" required>
                                {!! $errors->first('latitude', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="longitude" class="control-label">{{ __('outlet.longitude') }}</label>
                                <input id="longitude" type="text" class="form-control{{ $errors->has('longitude') ? ' is-invalid' : '' }}" name="longitude" value="{{ old('longitude', $outlet->longitude) }}" required>
                                {!! $errors->first('longitude', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                            </div>
                        </div>
                    </div>
                    <div id="mapid"></div>
                </div>
                <div class="card-footer">
                    <input type="submit" value="{{ __('outlet.update') }}" class="btn btn-success">
                    @if (Request::is('admin/*'))
                        <a href="{{ route('admin.outlets.show', $outlet) }}" class="btn btn-link">{{ __('app.cancel') }}</a>
                        <a href="{{ route('admin.outlets.edit', [$outlet, 'action' => 'delete']) }}" id="del-outlet-{{ $outlet->id }}" class="btn btn-danger float-right">{{ __('app.delete') }}</a>
                    @else
                     <a href="{{ route('outlets.show', $outlet) }}" class="btn btn-link">{{ __('app.cancel') }}</a>
                        <a href="{{ route('outlets.edit', [$outlet, 'action' => 'delete']) }}" id="del-outlet-{{ $outlet->id }}" class="btn btn-danger float-right">{{ __('app.delete') }}</a>
                    @endif


                </div>
                <input type="hidden" id="address_street" name="address_street" value='{{ $outlet->address_street }}'>
                <input type="hidden" id="address_city" name="address_city" value='{{ $outlet->address_city }}'>
            </form>
        </div>
    </div>
</div>
@endif
@endsection

@section('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.1/dist/leaflet.css"
    integrity= "sha512-Rksm5RenBEKSKFjgI3a41vrjkw4EVPlJ3+OiI65vTjIdo9brlAacEuKOiQ5OFh7cOI1bkDwLqdLw3Zg0cRJAAQ=="
    crossorigin=""/>

<style>
    #mapid { height: 300px; }
</style>
@endsection

@push('scripts')

<script>

    var mapCenter = [{{ $outlet->latitude }}, {{ $outlet->longitude }}];
    var map = L.map('mapid').setView(mapCenter, {{ config('leaflet.detail_zoom_level') }});

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);


    var marker = L.marker(mapCenter).addTo(map);
    function updateMarker(lat, lng) {
        marker
        .setLatLng([lat, lng])
         .bindPopup("Адрес :  " + marker.getLatLng().toString())
         .openPopup();
        return false
    };

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
    $('#latitude').on('input', updateMarkerByInputs);
    $('#longitude').on('input', updateMarkerByInputs);
</script>
<script async defer
        src="https://maps.googleapis.com/maps/api/js?key={!! env('GOOGLE_API') !!}&language=en">
</script>
@endpush
