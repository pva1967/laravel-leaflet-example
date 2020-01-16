@extends('layouts.app')

@section('title', __('contact.list'))

@section('content')
    <div class="mb-3">


        <h1 class="page-title">{{ __('contact.add2inst') }} </h1>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                @if (Request::is('admin/*'))
                    <form method="POST" action="{{ route('admin.contacts2institution.store') }}" accept-charset="UTF-8">
                @else
                    <form method="POST" action="{{ route('contacts2institution.store') }}" accept-charset="UTF-8">
                @endif

                    {{ csrf_field() }}
                    <table class="table table-sm table-responsive-sm">
                        <thead>
                        <tr>
                            <th class="text-center">{{ __('app.table_no') }}</th>
                            <th>{{ __('contact.name') }}</th>
                            <th>{{ __('contact.email') }}</th>
                            <th>{{ __('contact.phone') }}</th>
                            <th>{{ __('contact.language') }}</th>
                            <th>{{ __('contact.type') }}</th>
                        </tr>
                        </thead>
                        <tbody>


                        @foreach($contacts as $key => $contact)
                            <tr>
                                <td class="text-center"><input type="checkbox" name="contact[]" {{in_array($contact->id, $contact_insts)?'checked':''}} value="{{$contact->id}}"> </td>
                                <td>{{$contact->name}}</td>
                                <td>{{ $contact->email }}</td>
                                <td>{{ $contact->phone }}</td>
                                <td>{{ $contact->language_name}}</td>
                                <td>{{ $contact->type_name}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <input type="submit" value="{{ __('contact.add2inst') }}" class="btn btn-success">
                </form>
            </div>

            <div class="card-body">{{ $contacts->appends(Request::except('page'))->render() }}</div>
        </div>
    </div>
    </div>
@endsection

