@extends('site.master')

@section('title','Trang San Pham')

@section('body')
<div class="container">
    <h1>Category: {{ $category->name }}</h1>
    <div class="row">
        @foreach($category->products as $product)
            <div class="col-lg-4 col-md-6">
                <div class="product__item">
                    <div class="product__item__pic">
                        <img src="{{ asset($product->image) }}" alt="{{ $product->name }}">
                    </div>
                    <div class="product__item__text">
                        <h6>{{ $product->name }}</h6>
                        <span>{{ number_format($product->price, 0) }} VNĐ</span>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
