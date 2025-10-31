@extends('layouts.app')

@section('title', 'Products - AgriConnect')

@section('content')
<!-- Page Header -->
<section class="page-header bg-light py-5">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <h1 class="display-4 fw-bold text-success">Our Products</h1>
                <p class="lead text-muted">Fresh produce directly from local farmers</p>
            </div>
        </div>
    </div>
</section>

<!-- Products Section -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <!-- Filters Sidebar -->
            <div class="col-lg-3 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="fw-bold mb-4">
                            <i class="bi bi-funnel me-2"></i>Filters
                        </h5>
                        
                        <!-- Search -->
                        <form action="{{ route('products.index') }}" method="GET" id="filterForm">
                            <div class="mb-4">
                                <label class="form-label fw-semibold">Search Products</label>
                                <input type="text" name="search" class="form-control" 
                                       placeholder="Search..." value="{{ $search ?? '' }}">
                            </div>
                            
                               <!--   Category Filter -->
<div class="mb-4">
<label class="form-label fw-semibold">Category</label>
<select name="category" class="form-select" onchange="document.getElementById('filterForm').submit()">
<option value="all" {{ (!$category || $category == 'all') ? 'selected' : '' }}>All Categories</option>
@foreach($categories as $cat)
<option value="{{ $cat }}" {{ $category == $cat ? 'selected' : '' }}>
{{ $cat }}
</option>
@endforeach
</select>
</div>
<button type="submit" class="btn btn-success w-100">
                            <i class="bi bi-search me-2"></i>Apply Filters
                        </button>
                        
                        @if($category || $search)
                        <a href="{{ route('products.index') }}" class="btn btn-outline-secondary w-100 mt-2">
                            <i class="bi bi-x-circle me-2"></i>Clear Filters
                        </a>
                        @endif
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Products Grid -->
        <div class="col-lg-9">
            <!-- Results Info -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="mb-0">
                    Showing {{ count($products) }} product(s)
                    @if($category && $category != 'all')
                        in <span class="text-success">{{ $category }}</span>
                    @endif
                    @if($search)
                        for <span class="text-success">"{{ $search }}"</span>
                    @endif
                </h5>
            </div>
            
            @if(count($products) > 0)
            <div class="row g-4">
                @foreach($products as $product)
                <div class="col-md-6 col-lg-4">
                    <div class="card product-card h-100 border-0 shadow-sm hover-lift">
                        <div class="product-image-wrapper position-relative">
                            <?php $base = preg_replace('/\.[^.]+$/', '', $product['image']); $ext = pathinfo($product['image'], PATHINFO_EXTENSION); ?>
                            <picture>
                                <source srcset="{{ asset('assets/images/products/' . $base . '.webp') }}" type="image/webp">
                                <img src="{{ asset('assets/images/products/' . $base . '.' . $ext) }}"
                                     class="card-img-top" alt="{{ $product['name'] }}"
                                     onerror="this.src='https://via.placeholder.com/400x300?text={{ urlencode($product['name']) }}'">
                            </picture>
                            <span class="badge bg-success position-absolute top-0 end-0 m-3">
                                {{ $product['category'] }}
                            </span>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title fw-bold">{{ $product['name'] }}</h5>
                            <p class="card-text text-muted small">{{ $product['description'] }}</p>
                            <div class="mb-2">
                                <small class="text-muted">
                                    <i class="bi bi-shop me-1"></i>{{ $product['farmer'] }}
                                </small>
                            </div>
                            <div class="mb-2">
                                <small class="text-muted">
                                    <i class="bi bi-geo-alt me-1"></i>{{ $product['location'] }}
                                </small>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <span class="h5 text-success mb-0">
                                    Rs {{ number_format($product['price'], 2) }}/{{ $product['unit'] }}
                                </span>
                                <button class="btn btn-success btn-sm add-to-cart-btn"
                                    data-id="{{ $product['id'] ?? 'p' . $loop->index }}"
                                    data-name="{{ e($product['name']) }}"
                                    data-price="{{ number_format($product['price'], 2, '.', '') }}"
                                    data-image="{{ asset('assets/images/products/' . $product['image']) }}"
                                    data-qty="1">
                                    <i class="bi bi-cart-plus me-1"></i>Add to Cart
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-5">
                <i class="bi bi-inbox text-muted" style="font-size: 5rem;"></i>
                <h4 class="mt-3 text-muted">No products found</h4>
                <p class="text-muted">Try adjusting your filters or search terms</p>
                <a href="{{ route('products.index') }}" class="btn btn-success mt-3">
                    View All Products
                </a>
            </div>
            @endif
        </div>
    </div>
</div>
</section>
@endsection