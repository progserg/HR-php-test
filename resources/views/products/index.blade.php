@extends('layouts.app')

@section('content')
    <div class="container">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>ID</th>
                <th>Наименование</th>
                <th>Поставщик</th>
                <th>Цена</th>
            </tr>
            </thead>
            @foreach($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->vendor->name }}</td>
                    <td><product-price product-id="{{ $product->id }}" product-price="{{ $product->price }}"></product-price></td>
                </tr>
            @endforeach
        </table>
        <div class="row">
            <div class="col-md-12 text-center">
                {{ $products->links() }}
            </div>
        </div>
    </div>
@endsection
