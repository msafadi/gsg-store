@extends('layouts.admin')

@section('title')
<div class="d-flex justify-content-between">
    <h2>Trashed Products</h2>
</div>
@endsection

@section('breadcrumb')
<ol class="breadcrumb float-sm-right">
    <li class="breadcrumb-item"><a href="#">Home</a></li>
    <li class="breadcrumb-item active">Products</li>
</ol>
@endsection

@section('content')
    
    <x-alert />
    <div class="d-flex mb-4">
        <form action="{{ route('products.restore') }}" method="post" class="mr-3">
            @csrf
            @method('put')
            <button type="submit" class="btn btn-sm btn-warning">Restore All</button>
        </form>
        <form action="{{ route('products.force-delete') }}" method="post">
            @csrf
            @method('delete')
            <button type="submit" class="btn btn-sm btn-danger">Empty Trash</button>
        </form>
    </div>
    <table class="table">
        <thead>
            <tr>
                <th></th>
                <th>Name</th>
                <th>Category</th>
                <th>Price</th>
                <th>Qty.</th>
                <th>Status</th>
                <th>Deleted At</th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            <tr>
                <td><img src="{{ asset('uploads/' . $product->image_path) }}" width="60" alt=""></td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->category_name }}</td>
                <td>{{ $product->price }}</td>
                <td>{{ $product->quantity }}</td>
                <td>{{ $product->status }}</td>
                <td>{{ $product->deleted_at }}</td>
                <td>
                <form action="{{ route('products.restore', $product->id) }}" method="post">
                    @csrf
                    @method('put')
                    <button type="submit" class="btn btn-sm btn-warning">Restore</button>
                </form>
                </td>
                <td><form action="{{ route('products.force-delete', $product->id) }}" method="post">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-sm btn-danger">Delete Forever</button>
                </form></td>
            </tr>
            @endforeach
        </tbody>
    </table>


    {{ $products->links() }}
    

@endsection

