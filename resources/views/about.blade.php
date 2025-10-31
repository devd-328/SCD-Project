@extends('layouts.app')

@section('title', 'About Us - AgriConnect')

@section('content')
<!-- Page Header -->
<section class="page-header bg-light py-5">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <h1 class="display-4 fw-bold text-success">About AgriConnect</h1>
                <p class="lead text-muted">Bridging the gap between farmers and consumers</p>
            </div>
        </div>
    </div>
</section>

<!-- Mission Section -->
<section class="py-5">
    <div class="container">
        <div class="row align-items-center mb-5">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <div class="about-image">
                    <i class="bi bi-globe text-success" style="font-size: 15rem; opacity: 0.1;"></i>
                </div>
            </div>
            <div class="col-lg-6">
                <h2 class="fw-bold mb-4">Our Mission</h2>
                <p class="lead text-muted mb-3">
                    At AgriConnect, we believe in connecting local farmers directly with consumers, eliminating middlemen and ensuring fair prices for both parties.
                </p>
                <p class="text-muted">
                    We're committed to promoting sustainable agriculture, supporting local economies, and providing fresh, organic produce to families across Pakistan. Our platform empowers farmers to showcase their products and reach a wider audience while giving consumers access to the freshest produce available.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Values Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Our Core Values</h2>
            <p class="text-muted">What drives us every day</p>
        </div>
        
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center p-4">
                        <div class="icon-box bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                             style="width: 80px; height: 80px;">
                            <i class="bi bi-heart text-success fs-2"></i>
                        </div>
                        <h5 class="fw-bold mb-3">Sustainability</h5>
                        <p class="text-muted">
                            We promote eco-friendly farming practices that protect our environment for future generations.
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center p-4">
                        <div class="icon-box bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                             style="width: 80px; height: 80px;">
                            <i class="bi bi-star text-success fs-2"></i>
                        </div>
                        <h5 class="fw-bold mb-3">Quality</h5>
                        <p class="text-muted">
                            Every product on our platform meets strict quality standards to ensure customer satisfaction.
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center p-4">
                        <div class="icon-box bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                             style="width: 80px; height: 80px;">
                            <i class="bi bi-people text-success fs-2"></i>
                        </div>
                        <h5 class="fw-bold mb-3">Community</h5>
                        <p class="text-muted">
                            We build strong relationships between farmers and consumers, creating a supportive community.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Statistics Section -->
<section class="py-5">
    <div class="container">
        <div class="row text-center g-4">
            <div class="col-md-3">
                <div class="stat-card">
                    <h2 class="display-4 fw-bold text-success mb-2">500+</h2>
                    <p class="text-muted mb-0">Active Farmers</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <h2 class="display-4 fw-bold text-success mb-2">2000+</h2>
                    <p class="text-muted mb-0">Products Listed</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <h2 class="display-4 fw-bold text-success mb-2">10k+</h2>
                    <p class="text-muted mb-0">Happy Customers</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card">
                    <h2 class="display-4 fw-bold text-success mb-2">15+</h2>
                    <p class="text-muted mb-0">Cities Covered</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Team Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Our Story</h2>
            <p class="text-muted">How AgriConnect came to be</p>
        </div>
        
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <p class="text-muted text-center">
                    AgriConnect was founded in 2023 with a simple vision: to create a direct connection between farmers and consumers. We saw how middlemen were affecting both farmers' incomes and consumers' access to fresh produce. Today, we're proud to serve hundreds of farmers and thousands of customers across Pakistan, making fresh, organic produce accessible to everyone while ensuring farmers get fair compensation for their hard work.
                </p>
            </div>
        </div>
    </div>
</section>
@endsection