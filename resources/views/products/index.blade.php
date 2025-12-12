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
                        
                        <form action="{{ route('products.index') }}" method="GET" id="filterForm">
                            
                            <div class="mb-4">
                                <label class="form-label fw-semibold">Category</label>
                                <select name="category" class="form-select" onchange="document.getElementById('filterForm').submit()">
                                    <option value="all" {{ (!$category || $category == 'all') ? 'selected' : '' }}>All Categories</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat }}" {{ $category == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-success w-100 mb-2">
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
                            @php
                                // Prefer a pre-computed full URL when present (DB-backed products).
                                $imgUrl = $product['image_url'] ?? (isset($product['image']) ? asset('assets/images/products/' . $product['image']) : null);
                            @endphp
                            <img src="{{ $imgUrl }}" class="card-img-top" alt="{{ $product['name'] }}"
                                 onerror="this.src='https://via.placeholder.com/400x300?text={{ urlencode($product['name']) }}'">
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
                                <div>
                                    <button class="btn btn-success btn-sm add-to-cart-btn me-1"
                                        data-id="{{ $product['id'] ?? 'p' . $loop->index }}"
                                        data-name="{{ e($product['name']) }}"
                                        data-price="{{ number_format($product['price'], 2, '.', '') }}"
                                        data-image="{{ $product['image_url'] ?? asset('assets/images/products/' . $product['image']) }}"
                                        data-qty="1">
                                        <i class="bi bi-cart-plus me-1"></i>Add to Cart
                                    </button>
                                    <button class="btn btn-outline-success btn-sm view-details-btn"
                                        data-bs-toggle="modal"
                                        data-bs-target="#productModal"
                                        data-id="{{ $product['id'] ?? 'p' . $loop->index }}"
                                        data-name="{{ e($product['name']) }}"
                                        data-description="{{ e($product['description']) }}"
                                        data-price="{{ number_format($product['price'], 2, '.', '') }}"
                                        data-unit="{{ $product['unit'] }}"
                                        data-farmer="{{ e($product['farmer']) }}"
                                        data-category="{{ $product['category'] }}"
                                        data-location="{{ e($product['location']) }}"
                                        data-image="{{ $product['image_url'] ?? asset('assets/images/products/' . $product['image']) }}">
                                        Details
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

<!-- Product Details Modal -->
<div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold" id="productModalLabel">Product Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <img id="modal-product-image" src="" alt="Product" class="img-fluid rounded shadow-sm w-100" style="max-height: 400px; object-fit: cover;">
                    </div>
                    <div class="col-md-6">
                        <span id="modal-product-category" class="badge bg-success mb-3"></span>
                        <h3 id="modal-product-name" class="fw-bold mb-3"></h3>
                        <p id="modal-product-description" class="text-muted mb-4"></p>
                        
                        <div class="mb-3">
                            <h4 class="text-success fw-bold">
                                Rs <span id="modal-product-price"></span>/<span id="modal-product-unit"></span>
                            </h4>
                        </div>
                        
                        <div class="mb-3">
                            <p class="mb-2">
                                <i class="bi bi-shop text-success me-2"></i>
                                <strong>Farmer:</strong> <span id="modal-product-farmer"></span>
                            </p>
                            <p class="mb-0">
                                <i class="bi bi-geo-alt text-success me-2"></i>
                                <strong>Location:</strong> <span id="modal-product-location"></span>
                            </p>
                        </div>
                        
                        <div class="d-grid gap-2 mt-4">
                            <button id="modal-add-to-cart" class="btn btn-success btn-lg">
                                <i class="bi bi-cart-plus me-2"></i>Add to Cart
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle View Details button clicks
    document.querySelectorAll('.view-details-btn').forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.getAttribute('data-id');
            const productName = this.getAttribute('data-name');
            const productDescription = this.getAttribute('data-description');
            const productPrice = this.getAttribute('data-price');
            const productUnit = this.getAttribute('data-unit');
            const productFarmer = this.getAttribute('data-farmer');
            const productCategory = this.getAttribute('data-category');
            const productLocation = this.getAttribute('data-location');
            const productImage = this.getAttribute('data-image');
            // Update modal content
            document.getElementById('modal-product-name').textContent = productName;
            document.getElementById('modal-product-description').textContent = productDescription;
            document.getElementById('modal-product-price').textContent = productPrice;
            document.getElementById('modal-product-unit').textContent = productUnit;
            document.getElementById('modal-product-farmer').textContent = productFarmer;
            document.getElementById('modal-product-category').textContent = productCategory;
            document.getElementById('modal-product-location').textContent = productLocation;
            document.getElementById('modal-product-image').src = productImage;
            document.getElementById('modal-product-image').alt = productName;
            // Update Add to Cart button in modal
            const modalCartBtn = document.getElementById('modal-add-to-cart');
            modalCartBtn.setAttribute('data-id', productId);
            modalCartBtn.setAttribute('data-name', productName);
            modalCartBtn.setAttribute('data-price', productPrice);
            modalCartBtn.setAttribute('data-image', productImage);
            modalCartBtn.setAttribute('data-qty', '1');
            modalCartBtn.classList.add('add-to-cart-btn');
        });
    });
});
</script>
@endpush
@endsection