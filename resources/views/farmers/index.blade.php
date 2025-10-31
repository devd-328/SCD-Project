@extends('layouts.app')

@section('title', 'Community - AgriConnect')

@section('content')
<!-- Page Header -->
<section class="page-header bg-light py-5">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <h1 class="display-4 fw-bold text-success">Our Community</h1>
                <p class="lead text-muted">Meet the farmers behind your fresh produce</p>
            </div>
        </div>
    </div>
</section>

<!-- Farmers Section -->
<section class="py-5">
    <div class="container">
        <div class="row g-4">
            @foreach($farmers as $farmer)
            <div class="col-md-6 col-lg-3">
                <div class="card farmer-card h-100 border-0 shadow-sm text-center hover-lift">
                    <div class="card-body p-4">
                        <div class="farmer-image mb-3">
                            <img src="{{ asset('assets/images/farmers/' . $farmer['image']) }}" 
                                 class="rounded-circle border border-success border-3" 
                                 alt="{{ $farmer['name'] }}"
                                 style="width: 120px; height: 120px; object-fit: cover;"
                                 onerror="this.src='https://via.placeholder.com/120x120?text={{ substr($farmer['name'], 0, 1) }}'">
                        </div>
                        <h5 class="card-title fw-bold mb-1">{{ $farmer['name'] }}</h5>
                        <p class="text-success mb-2">{{ $farmer['farm_name'] }}</p>
                        <p class="text-muted small mb-3">{{ $farmer['bio'] }}</p>
                        
                        <div class="mb-3">
                            <span class="badge bg-success bg-opacity-10 text-success mb-2">
                                <i class="bi bi-geo-alt me-1"></i>{{ $farmer['location'] }}
                            </span>
                            <br>
                            <span class="badge bg-success bg-opacity-10 text-success">
                                <i class="bi bi-award me-1"></i>{{ $farmer['specialization'] }}
                            </span>
                        </div>
                        
                        <div class="d-flex justify-content-center gap-2 mb-3">
                            <small class="text-muted">
                                <i class="bi bi-basket me-1"></i>{{ $farmer['products_count'] }} Products
                            </small>
                        </div>
                        
                        <div class="farmer-contact">
                            <a href="tel:{{ $farmer['phone'] }}" class="btn btn-outline-success btn-sm w-100 mb-2">
                                <i class="bi bi-telephone me-1"></i>Call
                            </a>
                            <a href="mailto:{{ $farmer['email'] }}" class="btn btn-success btn-sm w-100">
                                <i class="bi bi-envelope me-1"></i>Email
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Become Farmer Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8 mx-auto text-center">
                <div class="icon-box bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-4" 
                     style="width: 100px; height: 100px;">
                    <i class="bi bi-person-plus text-success fs-1"></i>
                </div>
                <h2 class="fw-bold mb-3">Become Part of Our Community</h2>
                <p class="lead text-muted mb-4">
                    Are you a farmer looking to connect directly with consumers? Join AgriConnect and grow your business while promoting sustainable agriculture.
                </p>
                <a href="{{ route('contact.index') }}" class="btn btn-success btn-lg">
                    <i class="bi bi-arrow-right-circle me-2"></i>Join Now
                </a>
            </div>
        </div>
    </div>
</section>
@endsection