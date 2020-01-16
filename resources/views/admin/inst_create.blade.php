@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('admin.inst_create') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('admin.inst_store') }}">
                        @csrf
                        <div class="form-group">
                            <label for="name_ru" class="control-label" style="width: 250px;">{{ __('admin.name_ru') }}</label>
                            <select name="inst_name" id="inst_name">
                                @foreach($instnames as $instname)
                                    <option value="{{$instname->id}}" >{{$instname->name_ru}}</option>
                                @endforeach
                            </select>
                            {!! $errors->first('inst_name', '<span class="invalid-feedback" role="alert">Организация с этим названием уже есть</span>') !!}
                        </div>
                        <div class="form-group">
                            <label for="user" class="control-label" style="width: 250px;">{{ __('admin.user') }}</label>
                            <select name="creator_id" id="creator_id">
                                @foreach($users as $user)
                                    <option value="{{$user->id}}" >{{$user->name}}::{{$user->email}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="inst_type" class="control-label" style="width: 250px;">{{ __('institution.SP/IdP') }}</label>
                            <select name="inst_type">
                                <option value="IdP" >IdP</option>
                                <option value="SP" >SP</option>
                                <option value="IdP+SP" >IdP+SP</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="info_URL_en" class="control-label" style="width: 250px;">{{ __('admin.info_URL_en') }}</label>
                            <input id="info_URL_en" type="text" name="info_URL_en" value="{{ old('info_URL_en', "http://www.eduroam.ru/") }}" required  style="width: 250px;">
                            {!! $errors->first('info_URL_en', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                        </div>
                        <div class="form-group">
                            <label for="info_URL_ru" class="control-label" style="width: 250px;">{{ __('admin.info_URL_ru') }}</label>
                            <input id="info_URL_ru" type="text" name="info_URL_ru" value="{{ old('info_URL_ru',"http://www.eduroam.ru/") }}"  style="width: 250px;">
                            {!! $errors->first('info_URL_ru', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                        </div>
                        <div class="form-group">
                            <label for="policy_URL_en" class="control-label" style="width: 250px;">{{ __('admin.policy_URL_en') }}</label>
                            <input id="policy_URL_en" type="text" name="policy_URL_en" value="{{ old('info_URL_en', "http://www.eduroam.ru/") }}" required  style="width: 250px;">
                            {!! $errors->first('policy_URL_en', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                        </div>
                        <div class="form-group">
                            <label for="policy_URL_ru" class="control-label" style="width: 250px;">{{ __('admin.policy_URL_ru') }}</label>
                            <input id="info_URL_ru" type="text" name="info_URL_ru" value="{{ old('policy_URL_ru', "http://www.eduroam.ru/") }}"  style="width: 250px;">
                            {!! $errors->first('policy_URL_ru', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('admin.inst_create') }}
                                </button>
                                <a href="{{ route('admin.dashboard') }}" class="btn btn-link">{{ __('app.cancel') }}</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
