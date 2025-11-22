@extends('layouts.app')

@section('title', 'Product Details')

@section('content')
<div class="container py-4">
    <h2 class="fw-bold mb-4">Product Details</h2>
    <div class="card mb-4">
        <div class="row g-0">
            <div class="col-md-4">
                <img src="{{ $product->image_url }}" class="img-fluid rounded-start" alt="{{ $product->name }}">
            </div>
            <div class="col-md-8">
                <div class="card-body">
                    <h5 class="card-title">{{ $product->name }}</h5>
                    <p class="card-text">{{ $product->description }}</p>
                    <p class="card-text"><strong>Category:</strong> {{ $product->category }}</p>
                    <p class="card-text"><strong>Price:</strong> {{ $product->formatted_price }}</p>
                    <p class="card-text"><strong>Unit:</strong> {{ $product->unit }}</p>
                    <p class="card-text"><strong>Available:</strong> {{ $product->quantity_available }}</p>
                    <p class="card-text"><strong>Status:</strong> {{ $product->status }}</p>
                    <p class="card-text"><strong>Organic:</strong> {{ $product->is_organic ? 'Yes' : 'No' }}</p>
                    <p class="card-text"><strong>Harvest Date:</strong> {{ $product->harvest_date }}</p>
                    <p class="card-text"><strong>Farmer:</strong> {{ $product->farmer->user->name ?? '-' }}</p>
                </div>
            </div>
        </div>
    </div>
    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Back to Products</a>
</div>
@endsection
