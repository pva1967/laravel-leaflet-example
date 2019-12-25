@extends('layouts.app')

@section('title', __('outlet.detail'))

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">{{ __('outlet.detail') }}</div>
            <div class="card-body">
                <table class="table table-sm">
                    <tbody>
                        <tr><td>{{ __('outlet.name') }}</td><td>{{ $outlet->name }}</td></tr>
                        <tr><td>{{ __('outlet.address_city') }}</td><td>{{ $outlet->address_city }}</td></tr>
                        <tr><td>{{ __('outlet.address_street') }}</td><td>{{ $outlet->address_street }}</td></tr>
                        <tr><td>{{ __('outlet.latitude') }}</td><td>{{ $outlet->latitude }}</td></tr>
                        <tr><td>{{ __('outlet.longitude') }}</td><td>{{ $outlet->longitude }}</td></tr>
                        <tr><td>{{ __('outlet.longitude') }}</td><td>{{ $outlet->longitude }}</td></tr>
                        @if ($outlet->info_URL !== '' && !$outlet->info_URL)
                            <tr><td>{{ __('outlet.info_URL') }}</td><td>{{ $outlet->info_URL }}</td></tr>
                        @endif
                        <tr><td>{{ __('outlet.AP_no') }}</td><td>{{ $outlet->AP_no }}</td></tr>
                        <tr><td>{{ __('outlet.location_type') }}</td><td>{{ $outlet->locType() }}</td></tr>
                        <tr><td>{{ __('outlet.contacts') }}</td><td>
                                @if (!empty($contacts))
                                    @foreach($contacts as $key => $contact)
                                        {{$key+1}}.&nbsp;{{$contact->name}}<br>
                                    @endforeach
                                @endif
                            </td></tr>
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                @can('update', $outlet)
                    <a href="{{ route('outlets.edit', $outlet) }}" id="edit-outlet-{{ $outlet->id }}" class="btn btn-warning">{{ __('outlet.edit') }}</a>
                @endcan
                    <a href="{{ route('cont2outlets.edit', $outlet ) }}" id="edit-outlet-{{ $outlet->id }}" class="btn btn-warning">{{ __('contact.add_contacts') }}</a>
                <a href="{{ route('outlets.index') }}" class="btn btn-link">{{ __('outlet.back_to_index') }}</a>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">{{ trans('outlet.location') }}</div>
            @if ($outlet->coordinate)
            <div class="card-body" id="mapid"></div>
            @else
            <div class="card-body">{{ __('outlet.no_coordinate') }}</div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.1/dist/leaflet.css"
    integrity="sha512-Rksm5RenBEKSKFjgI3a41vrjkw4EVPlJ3+OiI65vTjIdo9brlAacEuKOiQ5OFh7cOI1bkDwLqdLw3Zg0cRJAAQ=="
    crossorigin=""/>

<style>
    #mapid { height: 400px; }
</style>
@endsection
@push('scripts')
<!-- Make sure you put this AFTER Leaflet's CSS -->


<script>
    var map = L.map('mapid').setView([{{ $outlet->latitude }}, {{ $outlet->longitude }}],{{ config('leaflet.detail_zoom_level') }});

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    var marker = L.marker([{{ $outlet->latitude }},{{ $outlet->longitude }}]).addTo(map);
        marker.bindPopup("Адрес :  " + marker.getLatLng().toString());
</script>
@endpush
