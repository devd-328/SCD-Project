@extends('layouts.app')

@section('title', $farmer->farm_name . ' - AgriConnect')

@section('content')
<!-- Farmer Profile Header -->
<div class="bg-light py-5">
    <div class="container">
        <div class="mb-4">
            <a href="{{ route('farmers.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Back to Community
            </a>
        </div>
        <div class="row align-items-center">
            <div class="col-md-4 text-center mb-4 mb-md-0">
                <img src="{{ $farmer->profile_image ? asset('assets/images/farmers/' . $farmer->profile_image) : asset('assets/images/farmers/default.jpg') }}" 
                     alt="{{ $farmer->farm_name }}" 
                     class="rounded-circle shadow-lg" 
                     style="width: 200px; height: 200px; object-fit: cover;">
            </div>
            <div class="col-md-8">
                <h1 class="fw-bold text-success mb-2">{{ $farmer->farm_name }}</h1>
                <h4 class="text-muted mb-3">{{ $farmer->name ?? $farmer->user->name }}</h4>
                <p class="lead text-secondary mb-4">{{ $farmer->bio }}</p>
                
                <div class="d-flex flex-wrap gap-3">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-geo-alt text-success me-2 fs-5"></i>
                        <span>{{ $farmer->location }}</span>
                    </div>
                    <div class="d-flex align-items-center">
                        <i class="bi bi-telephone text-success me-2 fs-5"></i>
                        <span>{{ $farmer->phone ?? 'N/A' }}</span>
                    </div>
                    <div class="d-flex align-items-center">
                        <i class="bi bi-star text-warning me-2 fs-5"></i>
                        <span>{{ $farmer->specialization }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Products Section -->
<section class="py-5">
    <div class="container">
        <h3 class="fw-bold mb-4 pb-2 border-bottom">Products by {{ $farmer->farm_name }}</h3>
        
        @if($farmer->products->count() > 0)
        <div class="row g-4">
            @foreach($farmer->products as $product)
            <div class="col-md-6 col-lg-4">
                <div class="card product-card h-100 border-0 shadow-sm hover-lift">
                    <div class="product-image-wrapper position-relative">
                        <img src="{{ $product->image_path ? asset('assets/images/products/' . basename($product->image_path)) : asset('assets/images/default-product.png') }}" 
                             class="card-img-top" alt="{{ $product->name }}"
                             onerror="this.src='https://via.placeholder.com/400x300?text={{ urlencode($product->name) }}'">
                        <span class="badge bg-success position-absolute top-0 end-0 m-3">
                            {{ $product->category }}
                        </span>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title fw-bold">{{ $product->name }}</h5>
                        <p class="card-text text-muted small">{{ Str::limit($product->description, 80) }}</p>
                        
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <span class="h5 text-success mb-0">
                                Rs {{ number_format($product->price, 2) }}/{{ $product->unit }}
                            </span>
                            <div>
                                <button class="btn btn-success btn-sm add-to-cart-btn"
                                    data-id="{{ $product->id }}"
                                    data-name="{{ e($product->name) }}"
                                    data-price="{{ number_format($product->price, 2, '.', '') }}"
                                    data-image="{{ $product->image_path ? asset('assets/images/products/' . basename($product->image_path)) : asset('assets/images/default-product.png') }}"
                                    data-qty="1">
                                    <i class="bi bi-cart-plus me-1"></i> Add
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-5">
            <i class="bi bi-inbox text-muted display-1"></i>
            <p class="lead text-muted mt-3">No active products listed by this farmer yet.</p>
        </div>
        @endif
    </div>
</section>
@endsection
