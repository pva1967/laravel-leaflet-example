@extends('layouts.app')

@section('title', __('contact.list'))

@section('content')
<div class="mb-3">
    <div class="float-right">

            <a href="{{ route('contacts.create') }}" class="btn btn-success">{{ __('contact.create') }}</a>

    </div>

    <h1 class="page-title">{{ __('contact.list') }} </h1>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
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
                        <td class="text-center">{{ $contacts->firstItem() + $key }}</td>
                        <td>{!! $contact->name_link !!}</td>
                        <td>{{ $contact->email }}</td>
                        <td>{{ $contact->phone }}</td>
                        <td>{{ $contact->language_name}}</td>
                        <td>{{ $contact->type_name}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="card-body">{{ $contacts->appends(Request::except('page'))->render() }}</div>
        </div>
    </div>
</div>
@endsection
