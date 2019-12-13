@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('admin.Create_name') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('admin.name_store') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name_ru" class="col-md-4 col-form-label text-md-right">{{ __('admin.name_ru') }}</label>

                            <div class="col-md-6">
                                <input id="name_ru" type="text" class="form-control{{ $errors->has('name_ru') ? ' is-invalid' : '' }}" name="name_ru" value="{{ old('name_ru') }}" required autofocus>

                                @if ($errors->has('name_ru'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name_ru') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name_en" class="col-md-4 col-form-label text-md-right">{{ __('admin.name_en') }}</label>

                            <div class="col-md-6">
                                <input id="name_en" type="text" class="form-control{{ $errors->has('name_en') ? ' is-invalid' : '' }}" name="name_en" value="{{ old('name_en') }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name_en') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('admin.Create_name') }}
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
