@extends('admin.layouts.admin')

@section('title', 'Edit Farmer')

@section('content')
<div class="mb-4">
    <h2 class="fw-bold mb-1">Edit Farmer</h2>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.farmers.index') }}">Farmers</a></li>
            <li class="breadcrumb-item active">Edit: {{ $farmer->name }}</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <form action="{{ route('admin.farmers.update', $farmer->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Farmer Name -->
                    <div class="mb-3">
                        <label for="name" class="form-label">Farmer Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name', $farmer->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Farm Name -->
                    <div class="mb-3">
                        <label for="farm_name" class="form-label">Farm Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('farm_name') is-invalid @enderror" 
                               id="farm_name" name="farm_name" value="{{ old('farm_name', $farmer->farm_name) }}" required>
                        @error('farm_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Location -->
                    <div class="mb-3">
                        <label for="location" class="form-label">Location <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('location') is-invalid @enderror" 
                               id="location" name="location" value="{{ old('location', $farmer->location) }}" required>
                        @error('location')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Phone and Email -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="phone" class="form-label">Phone <span class="text-danger">*</span></label>
                            <input type="tel" class="form-control @error('phone') is-invalid @enderror" 
                                   id="phone" name="phone" value="{{ old('phone', $farmer->phone) }}" required>
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email', $farmer->email) }}">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Biography -->
                    <div class="mb-3">
                        <label for="bio" class="form-label">Biography</label>
                        <textarea class="form-control @error('bio') is-invalid @enderror" 
                                  id="bio" name="bio" rows="4">{{ old('bio', $farmer->bio) }}</textarea>
                        <small class="text-muted">Tell us about the farmer and their farming practices</small>
                        @error('bio')
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
                                <option value="{{ $user->id }}" {{ old('user_id', $farmer->user_id) == $user->id ? 'selected' : '' }}>
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
                            <option value="active" {{ old('status', $farmer->status) == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status', $farmer->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            <option value="pending" {{ old('status', $farmer->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Current Image Display -->
                    @if($farmer->profile_image)
                    <div class="mb-3">
                        <label class="form-label">Current Profile Image</label>
                        <div>
                            <img src="{{ asset('assets/images/farmers/' . $farmer->profile_image) }}" 
                                 alt="{{ $farmer->name }}" 
                                 class="img-thumbnail" style="max-width: 200px;">
                        </div>
                    </div>
                    @endif

                    <!-- Upload New Image -->
                    <div class="mb-3">
                        <label for="profile_image" class="form-label">Upload New Profile Image (Optional)</label>
                        <input type="file" class="form-control @error('profile_image') is-invalid @enderror" 
                               id="profile_image" name="profile_image" accept=".jpg,.jpeg,.png,.webp">
                        <small class="text-muted">Leave empty to keep current image. Max size: 1MB. Allowed formats: JPG, PNG, WebP</small>
                        @error('profile_image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Submit Buttons -->
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-check-circle me-2"></i> Update Farmer
                        </button>
                        <a href="{{ route('admin.farmers.index') }}" class="btn btn-secondary">
                            <i class="bi bi-x-circle me-2"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Farmer Info Sidebar -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h6 class="fw-bold mb-3">Farmer Information</h6>
                <div class="mb-2">
                    <small class="text-muted">Farmer ID:</small>
                    <div><strong>#{{ $farmer->id }}</strong></div>
                </div>
                <div class="mb-2">
                    <small class="text-muted">Created:</small>
                    <div>{{ $farmer->created_at->format('M d, Y') }}</div>
                </div>
                <div class="mb-2">
                    <small class="text-muted">Last Updated:</small>
                    <div>{{ $farmer->updated_at->format('M d, Y H:i') }}</div>
                </div>
                @if($farmer->user)
                <div class="mb-2">
                    <small class="text-muted">Associated User:</small>
                    <div>{{ $farmer->user->name }} ({{ $farmer->user->email }})</div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
