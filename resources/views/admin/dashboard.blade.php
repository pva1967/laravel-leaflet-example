@extends('layouts.app')

@section('title', __('institution.edit'))

@section('content')
    <div class="form-group">
        <label for="name_ru" class="control-label">{{ __('admin.name_ru') }}</label>
        <select name="inst" id="inst">
            @foreach($institutions as $institution)
                <option value="{{$institution->id}}" {{$institution->id == $inst_id ? 'selected':''}}>{{$institution->name_ru}}</option>
            @endforeach
        </select>
    </div>
    @if (Route::has('register'))

    @endif
    <a class="nav-link" href="{{ route('admin.user_index') }}">{{ __('admin.user_index') }}</a>
    <a class="nav-link" href="{{ route('admin.name_create') }}">{{ __('admin.Create_name') }}</a>
    <a class="nav-link" href="{{ route('admin.inst_create') }}">{{ __('admin.inst_create') }}</a>
    <a class="nav-link" href="{{ route('admin.realm_create') }}">{{ __('admin.realm_create') }}</a>
    <a class="nav-link" href="{{ route('admin.realm_edit') }}">{{ __('admin.realm_delete') }}</a>
    <a class="nav-link" href="{{ route('admin.policy_add') }}">{{ __('institution.policy') }}</a>

    <div class="row">
        <div class="col-md-12">
            <div class="card">

                <div class="card-header">
                    <form method="GET" action="" accept-charset="UTF-8" class="form-inline">
                        <div class="form-group">
                            <label for="q" class="control-label">{{ __('admin.search') }}</label>
                            <input placeholder="{{ __('admin.search_admin_text') }}" name="q" type="text" id="q" class="form-control mx-sm-2" value="{{ request('q') }}">
                        </div>
                        <input type="submit" value="{{ __('admin.search') }}" class="btn btn-secondary">
                        <a href="{{ route('admin.user_index') }}" class="btn btn-link">{{ __('app.reset') }}</a>
                    </form>
                </div>
                <table class="table table-sm table-responsive-sm">
                    <thead>
                    <tr>
                        <th class="text-center">{{ __('app.table_no') }}</th>
                        <th>{{ __('institution.list') }}</th>
                        <th>{{ __('outlet.address') }}</th>
                        <th>{{ __('institution.policy') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($institutions as $key => $institution)

                        <tr>
                            <td class="text-center">{{ $key+1 }}</td>
                            <td>{{$institution->name_ru}}</td>
                            <td>{{ $institution->address_city }}, {{ $institution->address_street}}</td>
                            <td>
                                @if ($institution->policy !== '')
                                <a href = "{{ $institution->policy }}">{{ __('institution.policy') }}</a></td>
                            @endif
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script type="text/javascript" src="{{ URL::asset('js/axios.min.js') }}"></script>
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
