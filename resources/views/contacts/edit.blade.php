@extends('layouts.app')

@section('title', __('contact.create'))

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">{{ __('contact.edit') }}</div>
            <form method="POST" action="{{ route('contacts.update') }}" accept-charset="UTF-8" id="contact_create">
                {{ csrf_field() }}
                <div class="card-body">
                    <div class="form-group">
                        <label for="name" class="control-label">{{ __('contact.name') }}</label>
                        <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name', $contact->name) }}" required>
                        {!! $errors->first('name', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                    </div>
                    <div class="form-group">
                        <label for="email" class="control-label">{{ __('contact.email') }}</label>
                        <input id="e-mail" type="text" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email', $contact->email) }}" required>
                        {!! $errors->first('e-mail', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                    </div>
                    <div class="form-group">
                        <label for="phone" class="control-label">{{ __('contact.phone') }}</label>
                        <input id="phone" type="text" class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" name="phone" value="{{ old('phone', $contact->phone) }}" required>
                        {!! $errors->first('phone', '<span class="invalid-feedback" role="alert">:message</span>') !!}
                    </div>
                    <div class="form-group">
                        <label for="type" class="control-label">{{ __('contact.type') }}</label>
                        <select name="type" form="contact_create">
                            <option value="0"  {{$contact->type == 0? 'selected':''}}>Персональный</option>
                            <option value="1" {{$contact->type == 1? 'selected':''}}>Отдел (служба)</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="language" class="control-label">{{ __('contact.language') }}</label>
                        <select  name="language"  form="contact_create">
                            <option value="en" {{$contact->language == 'en'? 'selected':''}}>Английский</option>
                            <option value="ru" {{$contact->language == 'ru'? 'selected':''}}>Русский</option>
                        </select>
                    </div>

                </div>

                <div class="card-footer" >

                     <input type="submit" value="{{ __('contact.update')}}" class="btn btn-success">
                        <a href="{{ route('contacts.index') }}" class="btn btn-link">{{ __('app.cancel') }}</a>
                </div>
                    <input type = "hidden" value="update" name="rules_type">
                    <input type = "hidden" value="{{$contact->id}}" name="update_id">
            </form>
            </form>
        </div>
    </div>
</div>
@endsection



