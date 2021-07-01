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

    <table class="table">
        <thead>
            <tr>
                <th>$loop</th>
                <th>ID</th>
                <th>Name</th>
                <th>Slug</th>
                <th>Parent ID</th>
                <th>Status</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $category)
            <tr>
                <td>{{ $loop->first? 'First' : ($loop->last? 'Last' : $loop->iteration) }}</td>
                <td>{{ $category->id }}</td>
                <td>{{ $category->name }}</td>
                <td>{{ $category->slug }}</td>
                <td>{{ $category->parent_name }}</td>
                <td>{{ $category->status }}</td>
                <td>{{ $category->created_at }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

@endsection

