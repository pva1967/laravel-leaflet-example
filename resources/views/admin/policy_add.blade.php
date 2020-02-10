@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('institution.policy_add') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('admin.policy_store') }}">
                        @csrf
                        <div class="form-group">
                            <label for="instname_ru" class="control-label">{{ $instname_ru}}</label>

                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('institution.policy') }}</label>

                            <div class="col-md-6">
                                <input id="policy" type="text" class="form-control{{ $errors->has('policy') ? ' is-invalid' : '' }}" name="policy" value="{{ old('policy') }}" required autofocus>
                                <input id="inst_id" type="hidden" class="form-control{{ $errors->has('policy') ? ' is-invalid' : '' }}" name="inst_id" value="{{$inst_id}}">
                                @if ($errors->has('policy'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('policy') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('institution.policy_add') }}
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
