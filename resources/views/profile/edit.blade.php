@extends('layouts.app')

@section('title', 'Profile - AgriConnect')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold mb-0">Profile Settings</h2>
                <a href="{{ route('home') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Back to Home
                </a>
            </div>

            <!-- Update Profile Information -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold text-success">Profile Information</h5>
                </div>
                <div class="card-body p-4">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <!-- Update Password -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold text-success">Update Password</h5>
                </div>
                <div class="card-body p-4">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <!-- Delete Account -->
            <div class="card border-0 shadow-sm border-danger">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold text-danger">Delete Account</h5>
                </div>
                <div class="card-body p-4">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
