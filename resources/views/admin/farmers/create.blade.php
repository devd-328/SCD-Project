@extends('admin.layouts.admin')

@section('title', 'Add New Farmer')

@section('content')
<div class="mb-4">
    <h2 class="fw-bold mb-1">Add New Farmer</h2>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.farmers.index') }}">Farmers</a></li>
            <li class="breadcrumb-item active">Add New</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <form action="{{ route('admin.farmers.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Farmer Name -->
                    <div class="mb-3">
                        <label for="name" class="form-label">Farmer Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Farm Name -->
                    <div class="mb-3">
                        <label for="farm_name" class="form-label">Farm Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('farm_name') is-invalid @enderror" 
                               id="farm_name" name="farm_name" value="{{ old('farm_name') }}" required>
                        @error('farm_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Location -->
                    <div class="mb-3">
                        <label for="location" class="form-label">Location <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('location') is-invalid @enderror" 
                               id="location" name="location" value="{{ old('location') }}" required>
                        @error('location')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Phone and Email -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="phone" class="form-label">Phone <span class="text-danger">*</span></label>
                            <input type="tel" class="form-control @error('phone') is-invalid @enderror" 
                                   id="phone" name="phone" value="{{ old('phone') }}" required>
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email') }}">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Biography -->
                    <div class="mb-3">
                        <label for="bio" class="form-label">Biography</label>
                        <textarea class="form-control @error('bio') is-invalid @enderror" 
                                  id="bio" name="bio" rows="4">{{ old('bio') }}</textarea>
                        <small class="text-muted">Tell us about the farmer and their farming practices</small>
                        @error('bio')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Profile Image -->
                    <div class="mb-3">
                        <label for="profile_image" class="form-label">Profile Image</label>
                        <input type="file" class="form-control @error('profile_image') is-invalid @enderror" 
                               id="profile_image" name="profile_image" accept=".jpg,.jpeg,.png,.webp">
                        <small class="text-muted">Max size: 1MB. Allowed formats: JPG, PNG, WebP</small>
                        @error('profile_image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- User -->
                    <div class="mb-3">
                        <label for="user_id" class="form-label">Associated User</label>
                        <select class="form-select @error('user_id') is-invalid @enderror" 
                                id="user_id" name="user_id">
                            <option value="">Select User (Optional)</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }} ({{ $user->email }})
                                </option>
                            @endforeach
                        </select>
                        @error('user_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div class="mb-3">
                        <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                        <select class="form-select @error('status') is-invalid @enderror" 
                                id="status" name="status" required>
                            <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Submit Buttons -->
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-check-circle me-2"></i> Create Farmer
                        </button>
                        <a href="{{ route('admin.farmers.index') }}" class="btn btn-secondary">
                            <i class="bi bi-x-circle me-2"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Help Sidebar -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm bg-light">
            <div class="card-body">
                <h6 class="fw-bold mb-3">
                    <i class="bi bi-info-circle text-primary me-2"></i> Quick Tips
                </h6>
                <ul class="small text-muted">
                    <li class="mb-2">All fields marked with <span class="text-danger">*</span> are required</li>
                    <li class="mb-2">Use a clear, professional photo for the profile image</li>
                    <li class="mb-2">Write a compelling biography to help customers connect</li>
                    <li class="mb-2">Include accurate contact information</li>
                    <li class="mb-2">You can link an existing user account if available</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
