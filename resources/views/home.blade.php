@extends('layouts.app')

@section('title', 'Home - AgriConnect')

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center min-vh-75">
            <div class="col-lg-6 text-center text-lg-start mb-4 mb-lg-0">
                <h1 class="display-3 fw-bold text-success mb-3 animate-fade-in">
                    Fresh From Farm to Your Table
                </h1>
                <p class="lead text-muted mb-4">
                    Connect directly with local farmers and enjoy fresh, organic produce delivered to your doorstep.
                </p>
                <div class="d-flex gap-3 justify-content-center justify-content-lg-start">
                    <a href="{{ route('products.index') }}" class="btn btn-success btn-lg px-4">
                        <i class="bi bi-basket me-2"></i>Shop Now
                    </a>
                    <a href="{{ route('farmers.index') }}" class="btn btn-outline-success btn-lg px-4">
                        <i class="bi bi-people me-2"></i>Meet Farmers
                    </a>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="hero-image text-center">
                    <i class="bi bi-basket3-fill text-success" style="font-size: 20rem; opacity: 0.1;"></i>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Reviews Section -->
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">What our customers say</h2>
            <p class="text-muted">Real feedback from people who buy from local farmers through AgriConnect</p>
        </div>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <p class="mb-3">"Excellent quality and fast delivery. The tomatoes were fresh and tasted amazing — I will order again."</p>
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <strong>Amna K.</strong>
                                <div class="text-muted small">Lahore, Pakistan</div>
                            </div>
                            <div class="text-warning" aria-hidden="true">★★★★★</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <p class="mb-3">"Great service and helpful farmers. The ordering process was simple and the produce arrived well packed."</p>
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <strong>Sajid R.</strong>
                                <div class="text-muted small">Karachi, Pakistan</div>
                            </div>
                            <div class="text-warning" aria-hidden="true">★★★★☆</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <p class="mb-3">"Love supporting local farmers here. The eggs and milk quality is top-notch — exactly what we want for our family."</p>
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <strong>Fatima Z.</strong>
                                <div class="text-muted small">Islamabad, Pakistan</div>
                            </div>
                            <div class="text-warning" aria-hidden="true">★★★★☆</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Why Choose AgriConnect?</h2>
            <p class="text-muted">Connecting you with the best local farmers</p>
        </div>
        
        <div class="row g-4">
            <div class="col-md-4">
                <div class="feature-card text-center p-4 bg-white rounded shadow-sm h-100">
                    <div class="icon-box bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                         style="width: 80px; height: 80px;">
                        <i class="bi bi-truck text-success fs-2"></i>
                    </div>
                    <h5 class="fw-bold mb-3">Fast Delivery</h5>
                    <p class="text-muted">
                        Get fresh produce delivered to your doorstep within 24 hours of harvest.
                    </p>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="feature-card text-center p-4 bg-white rounded shadow-sm h-100">
                    <div class="icon-box bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                         style="width: 80px; height: 80px;">
                        <i class="bi bi-award text-success fs-2"></i>
                    </div>
                    <h5 class="fw-bold mb-3">Quality Assured</h5>
                    <p class="text-muted">
                        All products are verified for quality and freshness by our team.
                    </p>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="feature-card text-center p-4 bg-white rounded shadow-sm h-100">
                    <div class="icon-box bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                         style="width: 80px; height: 80px;">
                        <i class="bi bi-shield-check text-success fs-2"></i>
                    </div>
                    <h5 class="fw-bold mb-3">100% Organic</h5>
                    <p class="text-muted">
                        Support sustainable farming with certified organic products.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Products Section -->
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Featured Products</h2>
            <p class="text-muted">Handpicked fresh products from our farmers</p>
        </div>
        
        <div class="row g-4">
            @foreach($featuredProducts as $product)
            <div class="col-md-4">
                <div class="card product-card h-100 border-0 shadow-sm">
                    <div class="product-image-wrapper">
                        <img src="{{ asset('assets/images/products/' . $product['image']) }}"
                             class="card-img-top" alt="{{ $product['name'] }}"
                             onerror="this.src='https://via.placeholder.com/400x300?text={{ urlencode($product['name']) }}'">
                        <span class="badge bg-success position-absolute top-0 end-0 m-3">
                            {{ $product['category'] }}
                        </span>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title fw-bold">{{ $product['name'] }}</h5>
                        <p class="text-muted small mb-2">
                            <i class="bi bi-shop me-1"></i>{{ $product['farmer'] }}
                        </p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="h5 text-success mb-0">
                                Rs {{ number_format($product['price'], 2) }}/{{ $product['unit'] }}
                            </span>
                            <div>
                                <button class="btn btn-success btn-sm add-to-cart-btn me-2"
                                    data-id="{{ $product['id'] ?? 'p' . $loop->index }}"
                                    data-name="{{ e($product['name']) }}"
                                    data-price="{{ number_format($product['price'], 2, '.', '') }}"
                                    data-image="{{ asset('assets/images/products/' . $product['image']) }}"
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
                                    data-location="{{ $product['location'] ?? 'Pakistan' }}"
                                    data-image="{{ asset('assets/images/products/' . $product['image']) }}">
                                    View Details
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="text-center mt-5">
            <a href="{{ route('products.index') }}" class="btn btn-success btn-lg">
                View All Products <i class="bi bi-arrow-right ms-2"></i>
            </a>
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

<!-- Call to Action Section -->
<section class="py-5 bg-success text-white">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h2 class="fw-bold mb-3">Join Our Farming Community</h2>
                <p class="lead mb-0">
                    Are you a farmer? Partner with us and reach thousands of customers directly.
                </p>
            </div>
            <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                <a href="{{ route('contact.index') }}" class="btn btn-light btn-lg">
                    <i class="bi bi-person-plus me-2"></i>Become a Partner
                </a>
            </div>
        </div>
    </div>
</section>

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