@extends('layouts.app')

@section('title', __('outlet.list'))

@section('content')
<div class="mb-3">
    <div class="float-right">
        @can('create', new App\Outlet)
            <a href="{{ route('admin.user_create') }}" class="btn btn-success">{{ __('admin.Register') }}</a>
        @endcan
    </div>
    <h1 class="page-title">{{ __('admin.manage admins') }}</h1>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            @if (session('status') == 'We have e-mailed your password reset link!')
                <div class="alert alert-success" role="alert">
                    {{ 'Письмо со ссылкой на изменение пароля успешно отправлено' }}
                </div>
            @endif
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
                        <th>{{ __('admin.user') }}</th>
                        <th>{{ __('admin.email') }}</th>
                        <th>{{ __('admin.name_ru') }}</th>
                        <th class="text-center">{{ __('app.action') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($admins as $key => $admin)

                        <tr>
                        <td class="text-center">{{ $key+1 }}</td>
                            <td><a href = "{{ route('admin.user_edit', $admin->user_id)}}" >{{$admin->name}}</a></td>
                        <td>{{ $admin->email }}</td>
                        <td>{{ $admin->instname }}</td>

                           <td class="text-center">
                               <form method="POST" action="{{ route('admin.password.send') }}">
                                   @csrf
                               <input id="user_id" type="hidden" name="user_id" value="{{$admin->user_id}}" >
                               <button type="submit" class="btn btn-primary">
                                   Выслать админу активацию
                               </button>
                               </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
