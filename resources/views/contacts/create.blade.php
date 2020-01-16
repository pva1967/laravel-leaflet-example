@extends('layouts.app')

@section('title', __('contact.create'))

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">{{ __('contact.create') }}</div>
            @if (Request::is('admin/*'))
                <form method="POST" action="{{ route('admin.contacts.store') }}" accept-charset="UTF-8" id="contact_create">
             @else
                <form method="POST" action="{{ route('contacts.store') }}" accept-charset="UTF-8" id="contact_create">
             @endif


                {{ csrf_field() }}
                <div class="card-body">
                    <div class="form-group">
                        <label for="name" class="control-label">{{ __('contact.name') }}</label>
                        <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required>
                        {!! $errors->first('name', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                    </div>
                    <div class="form-group">
                        <label for="email" class="control-label">{{ __('contact.email') }}</label>
                        <input id="email" type="text" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>
                        {!! $errors->first('e-mail', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                    </div>
                    <div class="form-group">
                        <label for="phone" class="control-label">{{ __('contact.phone') }}</label>
                        <input id="phone" type="text" class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" name="phone" value="{{ old('phone') }}" required>
                        {!! $errors->first('phone', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                    </div>
                    <div class="form-group">
                        <label for="type" class="control-label">{{ __('contact.type') }}</label>
                        <select name="type" form="contact_create">
                            <option value="0">Персональный</option>
                            <option value="1">Отдел (служба)</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="language" class="control-label">{{ __('contact.language') }}</label>
                        <select  name="language"  form="contact_create">
                            <option value="en">Английский</option>
                            <option value="ru">Русский</option>
                        </select>
                    </div>

                </div>

                <div class="card-footer">
                    <input type="submit" value="{{ __('contact.create') }}" class="btn btn-success">
                    <a href="{{ route('contacts.index') }}" class="btn btn-link">{{ __('app.cancel') }}</a>
                </div>
                <input type = "hidden" value="create" name="rules_type">
                 </form>
            </div>
        </div>
    </div>
</div>
@endsection


