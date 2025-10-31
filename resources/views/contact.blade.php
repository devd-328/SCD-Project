@extends('layouts.app')

@section('title', 'Contact Us - AgriConnect')

@section('content')
<!-- Page Header -->
<section class="page-header bg-light py-5">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <h1 class="display-4 fw-bold text-success">Contact Us</h1>
                <p class="lead text-muted">We'd love to hear from you</p>
            </div>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section class="py-5">
    <div class="container">
        <div class="row g-4">
            <!-- Contact Form -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <h4 class="fw-bold mb-4">Send Us a Message</h4>
                        
                        @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @endif
                        
                        @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            <strong>Please fix the following errors:</strong>
                            <ul class="mb-0 mt-2">
                                @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @endif
                        
                        <form action="{{ route('contact.submit') }}" method="POST" id="contactForm">
                            @csrf
                            
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ old('name') }}" required>
                                    @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-6">
                                    <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                           id="email" name="email" value="{{ old('email') }}" required>
                                    @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-12">
                                    <label for="subject" class="form-label">Subject <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('subject') is-invalid @enderror" 
                                           id="subject" name="subject" value="{{ old('subject') }}" required>
                                    @error('subject')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-12">
                                    <label for="message" class="form-label">Message <span class="text-danger">*</span></label>
                                    <textarea class="form-control @error('message') is-invalid @enderror" 
                                              id="message" name="message" rows="5" required>{{ old('message') }}</textarea>
                                    @error('message')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Minimum 10 characters</small>
                                </div>
                                
                                <div class="col-12">
                                    <button type="submit" class="btn btn-success btn-lg">
                                        <i class="bi bi-send me-2"></i>Send Message
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Contact Information -->
            <div class="col-lg-4">
                <!-- Contact Info Card -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4">Contact Information</h5>
                        
                        <div class="contact-info mb-3">
                            <div class="d-flex align-items-start mb-3">
                                <div class="icon-box bg-success bg-opacity-10 rounded d-flex align-items-center justify-content-center me-3" 
                                     style="width: 45px; height: 45px; flex-shrink: 0;">
                                    <i class="bi bi-geo-alt text-success"></i>
                                </div>
                                <div>
                                    <h6 class="fw-semibold mb-1">Address</h6>
                                    <p class="text-muted small mb-0">123 Farm Road, Karachi, Pakistan</p>
                                </div>
                            </div>
                            
                            <div class="d-flex align-items-start mb-3">
                                <div class="icon-box bg-success bg-opacity-10 rounded d-flex align-items-center justify-content-center me-3" 
                                     style="width: 45px; height: 45px; flex-shrink: 0;">
                                    <i class="bi bi-telephone text-success"></i>
                                </div>
                                <div>
                                    <h6 class="fw-semibold mb-1">Phone</h6>
                                    <p class="text-muted small mb-0">+92 300 1234567</p>
                                </div>
                            </div>
                            
                            <div class="d-flex align-items-start mb-3">
                                <div class="icon-box bg-success bg-opacity-10 rounded d-flex align-items-center justify-content-center me-3" 
                                     style="width: 45px; height: 45px; flex-shrink: 0;">
                                    <i class="bi bi-envelope text-success"></i>
                                </div>
                                <div>
                                    <h6 class="fw-semibold mb-1">Email</h6>
                                    <p class="text-muted small mb-0">info@agriconnect.pk</p>
                                </div>
                            </div>
                            
                            <div class="d-flex align-items-start">
                                <div class="icon-box bg-success bg-opacity-10 rounded d-flex align-items-center justify-content-center me-3" 
                                     style="width: 45px; height: 45px; flex-shrink: 0;">
                                    <i class="bi bi-clock text-success"></i>
                                </div>
                                <div>
                                    <h6 class="fw-semibold mb-1">Working Hours</h6>
                                    <p class="text-muted small mb-0">Mon - Sat: 8AM - 6PM<br>Sunday: Closed</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Social Media Card -->
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4 text-center">
                        <h5 class="fw-bold mb-3">Follow Us</h5>
                        <div class="social-links d-flex justify-content-center gap-3">
                            <a href="#" class="btn btn-outline-success btn-sm rounded-circle" title="Facebook" style="width: 45px; height: 45px; display: flex; align-items: center; justify-content: center;">
                                <img src="{{ asset('assets/images/social/facebook.svg') }}" alt="Facebook" style="width:22px;height:22px;" />
                            </a>
                            <a href="#" class="btn btn-outline-success btn-sm rounded-circle" title="Twitter" style="width: 45px; height: 45px; display: flex; align-items: center; justify-content: center;">
                                <img src="{{ asset('assets/images/social/twitter.svg') }}" alt="Twitter" style="width:22px;height:22px;" />
                            </a>
                            <a href="#" class="btn btn-outline-success btn-sm rounded-circle" title="Instagram" style="width: 45px; height: 45px; display: flex; align-items: center; justify-content: center;">
                                <img src="{{ asset('assets/images/social/instagram.svg') }}" alt="Instagram" style="width:22px;height:22px;" />
                            </a>
                            <a href="#" class="btn btn-outline-success btn-sm rounded-circle" title="LinkedIn" style="width: 45px; height: 45px; display: flex; align-items: center; justify-content: center;">
                                <img src="{{ asset('assets/images/social/linkedin.svg') }}" alt="LinkedIn" style="width:22px;height:22px;" />
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection