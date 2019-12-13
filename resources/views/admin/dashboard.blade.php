@extends('layouts.app')

@section('title', __('institution.edit'))

@section('content')
    <div class="form-group">
        <label for="name_ru" class="control-label">{{ __('admin.name_ru') }}</label>
        <select name="inst" id="inst">
            @foreach($institutions as $institution)
                <option value="{{$institution->id}}" {{$institution->id == $inst_id ? 'selected':''}}>{{$institution->name_ru()}}</option>
            @endforeach
        </select>
    </div>
    @if (Route::has('register'))
        <a class="nav-link" href="{{ route('admin.user_create') }}">{{ __('admin.Register') }}</a>
    @endif
    <a class="nav-link" href="{{ route('admin.name_create') }}">{{ __('admin.Create_name') }}</a>
    <a class="nav-link" href="{{ route('admin.inst_create') }}">{{ __('admin.inst_create') }}</a>
    <a class="nav-link" href="{{ route('admin.realm_create') }}">{{ __('admin.realm_create') }}</a>
@endsection

@push('scripts')
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script>
        $("#inst").on('change', function(){
            let inst = $('#inst').val();
            let url = '{{route('admin.store')}}'.concat('?inst=', inst);
            console.log("url: ", url);
            axios.get(url)
                .then(function (response) {
                    console.log(response.data);
                })
                .catch(function (error) {
                    console.log(error);
                });
           //console.log (inst);
        });

    </script>
@endpush
