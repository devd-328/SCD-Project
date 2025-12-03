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
        @if($farmers->count() > 0)
        <div class="row g-4">
            @foreach($farmers as $farmer)
            <div class="col-md-6 col-lg-3">
                <div class="card farmer-card h-100 border-0 shadow-sm text-center hover-lift">
                    <div class="card-body p-4">
                        <div class="farmer-image mb-3">
                            @if($farmer->profile_image)
                                <img src="{{ asset('assets/images/farmers/' . $farmer->profile_image) }}" 
                                     class="rounded-circle border border-success border-3" 
                                     alt="{{ $farmer->name }}"
                                     style="width: 120px; height: 120px; object-fit: cover;">
                            @else
                                <div class="rounded-circle border border-success border-3 d-flex align-items-center justify-content-center" 
                                     style="width: 120px; height: 120px; margin: 0 auto; background-color: #f0f0f0;">
                                    <i class="bi bi-person text-success" style="font-size: 3rem;"></i>
                                </div>
                            @endif
                        </div>
                        <h5 class="card-title fw-bold mb-1">{{ $farmer->name }}</h5>
                        <p class="text-success mb-2">{{ $farmer->farm_name }}</p>
                        <p class="text-muted small mb-3">{{ $farmer->bio ?? 'No description available' }}</p>
                        
                        <div class="mb-3">
                            <span class="badge bg-success bg-opacity-10 text-success mb-2">
                                <i class="bi bi-geo-alt me-1"></i>{{ $farmer->location }}
                            </span>
                            @if($farmer->specialization)
                            <br>
                            <span class="badge bg-success bg-opacity-10 text-success">
                                <i class="bi bi-award me-1"></i>{{ $farmer->specialization }}
                            </span>
                            @endif
                        </div>
                        
                        <div class="d-flex justify-content-center gap-2 mb-3">
                            <small class="text-muted">
                                <i class="bi bi-basket me-1"></i>{{ $farmer->products_count }} Product{{ $farmer->products_count !== 1 ? 's' : '' }}
                            </small>
                        </div>
                        
                        <div class="farmer-contact">
                            @if($farmer->phone)
                            <a href="tel:{{ $farmer->phone }}" class="btn btn-outline-success btn-sm w-100 mb-2">
                                <i class="bi bi-telephone me-1"></i>Call
                            </a>
                            @endif
                            @if($farmer->email)
                            <a href="mailto:{{ $farmer->email }}" class="btn btn-success btn-sm w-100">
                                <i class="bi bi-envelope me-1"></i>Email
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-5">
            <i class="bi bi-inbox display-4 text-muted mb-3 d-block"></i>
            <p class="text-muted fs-5">No farmers available yet. Check back soon!</p>
        </div>
        @endif
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