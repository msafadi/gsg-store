@extends('layouts.admin')

@section('title')
{{ $title }} <a href="{{ route('categories.create') }}">Create</a>
@endsection

@section('breadcrumb')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"><a href="#">Home</a></li>
    <li class="breadcrumb-item active">Categories</li>
</ol>
@endsection

@section('content')

{{ trans_choice('app.categories_count', $categories->count(), ['number' => $categories->count()]) }}
{{ __('Current Locale is :locale', ['locale' => App::getLocale()]) }}
<table class="table">
    <thead>
        <tr>
            <th>$loop</th>
            <th>{{ __('ID') }}</th>
            <th>{{ trans('Name') }}</th>
            <th>{{ Lang::get('Slug') }}</th>
            <th>@lang('Parent Name')</th>
            <th>{{ __('Products Count') }}</th>
            <th>{{ __('Status') }}</th>
            <th>{{ __('Created At') }}</th>
            <th></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach($categories as $category)
        <tr>
            <td>{{ $loop->first? 'First' : ($loop->last? 'Last' : $loop->iteration) }}</td>
            <td>{{ $category->id }}</td>
            <td>{{ $category->name }}</td>
            <td>{{ $category->slug }}</td>
            <td>{{ $category->parent->name}}</td>
            <td>{{ $category->count }}</td>
            <td>{{ $category->status }}</td>
            <td>{{ $category->created_at }}</td>
            <td><a href="{{ route('categories.edit', $category->id) }}" class="btn btn-sm btn-dark">{{ __('app.edit') }}</a></td>
            <td>
                <form action="{{ route('categories.destroy', $category->id) }}" method="post">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-sm btn-danger">{{ __('Delete') }}</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{{ $categories->links() }}

@endsection