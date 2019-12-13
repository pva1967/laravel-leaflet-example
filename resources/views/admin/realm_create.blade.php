@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('admin.realm_create') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('admin.realm_store') }}">
                        @csrf
                        <div class="form-group">
                            <label for="name_ru" class="control-label">{{ __('admin.name_ru') }}</label>
                            <select name="inst_name" id="inst_name">
                                @foreach($instnames as $instname)
                                    <option value="{{$instname->id}}" >{{$instname->inst_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('realm') }}</label>

                            <div class="col-md-6">
                                <input id="realm" type="text" class="form-control{{ $errors->has('realm') ? ' is-invalid' : '' }}" name="realm" value="{{ old('realm') }}" required autofocus>

                                @if ($errors->has('realm'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('realm') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('admin.realm_create') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
