@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if (request('q') == 'del' && $realm)
                    <div class="card">
                        <div class="card-header">{{ __('admin.realm_delete') }}</div>
                        <div class="card-body">

                            <div class="card-body text-danger">{{ __('admin.realm_delete_confirm') }}<strong>{{ $realm }}</strong>?</div>
                        <div class="card-footer">
                            <form method="POST" action="{{ route('admin.realm_destroy', $realm) }}" accept-charset="UTF-8" onsubmit="return confirm({{ __('app.delete_confirm') }})" class="del-form float-right" style="display: inline;">
                                {{ csrf_field() }}
                                <input type="hidden" name="realm" value = "{{$realm}}">
                                <button type="submit" class="btn btn-danger">{{ __('app.delete_confirm_button') }}</button>
                            </form>
                            <a href="{{ route('admin.realm_edit') }}" class="btn btn-link">{{ __('app.cancel') }}</a>
                        </div>
                    </div>
            @else
            <div class="card">
                <div class="card-header">{{ __('admin.realm_edit') }}</div>

                <div class="card-body">

                        <div class="form-group">
                            <label for="realm" class="control-label">{{ __('admin.realm') }}</label>
                            <select name="realm" id="realm">
                                @foreach($realms as $realm)
                                    <option value="{{$realm->realm}}" >{{$realm->realm}}</option>
                                @endforeach
                            </select>
                        </div>


                        <div class="card-footer">
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-link">{{ __('app.cancel') }}</a>

                                <a href="" id="del-realm" class="btn btn-danger float-right" >{{ __('app.delete') }}</a>

                    </form>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
    @push('scripts')
        <script>
            $( document ).ready(function() {
                let realm = $("#realm").val();
                let url ="{{route('admin.realm_edit')}}";
                $("#del-realm").attr("href",url+"?q=del&realm="+realm )  ;
            });
            $("#realm").change(function() {
                let realm = $("#realm").val();
                let url ="{{route('admin.realm_edit')}}";
                $("#del-realm").attr("href",url+"?q=del&realm="+realm )  ;
            });


        </script>
@endpush
