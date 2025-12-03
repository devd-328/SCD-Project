@extends('admin.layouts.admin')

@section('title', 'Farmer Details')

@section('content')
<div class="mb-4">
    <h2 class="fw-bold mb-1">Farmer Details</h2>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.farmers.index') }}">Farmers</a></li>
            <li class="breadcrumb-item active">{{ $farmer->name }}</li>
        </ol>
    </nav>
</div>

<div class="row">
    <!-- Farmer Information -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 text-center">
                        @if($farmer->profile_image)
                            <img src="{{ asset('assets/images/farmers/' . $farmer->profile_image) }}" 
                                 alt="{{ $farmer->name }}" 
                                 class="img-thumbnail" style="max-width: 150px; width: 100%;">
                        @else
                            <div class="bg-light d-flex align-items-center justify-content-center" style="height: 150px; border-radius: 4px;">
                                <i class="bi bi-person display-1 text-muted"></i>
                            </div>
                        @endif
                    </div>
                    <div class="col-md-9">
                        <h4 class="fw-bold">{{ $farmer->name }}</h4>
                        <p class="text-muted mb-2">
                            <i class="bi bi-house text-primary"></i>
                            <strong>Farm Name:</strong> {{ $farmer->farm_name }}
                        </p>
                        <p class="text-muted mb-2">
                            <i class="bi bi-geo-alt text-primary"></i>
                            <strong>Location:</strong> {{ $farmer->location }}
                        </p>
                        <p class="text-muted mb-2">
                            <i class="bi bi-telephone text-primary"></i>
                            <strong>Phone:</strong> <a href="tel:{{ $farmer->phone }}">{{ $farmer->phone }}</a>
                        </p>
                        @if($farmer->email)
                        <p class="text-muted mb-2">
                            <i class="bi bi-envelope text-primary"></i>
                            <strong>Email:</strong> <a href="mailto:{{ $farmer->email }}">{{ $farmer->email }}</a>
                        </p>
                        @endif
                        <div class="mt-3">
                            @if($farmer->status === 'active')
                            <span class="badge bg-success">Active</span>
                            @elseif($farmer->status === 'inactive')
                            <span class="badge bg-secondary">Inactive</span>
                            @else
                            <span class="badge bg-warning text-dark">Pending</span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Biography Section -->
                @if($farmer->bio)
                <div class="mt-4 pt-4 border-top">
                    <h6 class="fw-bold mb-2">About the Farmer</h6>
                    <p class="text-muted">{{ $farmer->bio }}</p>
                </div>
                @endif

                <!-- Action Buttons -->
                <div class="mt-4 d-flex gap-2">
                    <a href="{{ route('admin.farmers.edit', $farmer->id) }}" class="btn btn-warning">
                        <i class="bi bi-pencil me-2"></i> Edit Farmer
                    </a>
                    <form action="{{ route('admin.farmers.destroy', $farmer->id) }}" method="POST" class="d-inline"
                          onsubmit="return confirm('Are you sure you want to delete this farmer? This action cannot be undone.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="bi bi-trash me-2"></i> Delete Farmer
                        </button>
                    </form>
                    <a href="{{ route('admin.farmers.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left me-2"></i> Back to List
                    </a>
                </div>
            </div>
        </div>

        <!-- Associated Products -->
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h6 class="fw-bold mb-3">Products from this Farmer</h6>
                @if($farmer->products && $farmer->products->count() > 0)
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead class="table-light">
                            <tr>
                                <th>Product</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>Stock</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($farmer->products as $product)
                            <tr>
                                <td>
                                    <a href="{{ route('admin.products.show', $product->id) }}">
                                        {{ $product->name }}
                                    </a>
                                </td>
                                <td><span class="badge bg-primary">{{ $product->category }}</span></td>
                                <td class="fw-bold text-success">Rs. {{ number_format($product->price, 2) }}</td>
                                <td>
                                    @if($product->quantity_available > 0)
                                    <span class="badge bg-success">{{ $product->quantity_available }}</span>
                                    @else
                                    <span class="badge bg-danger">Out of Stock</span>
                                    @endif
                                </td>
                                <td>
                                    @if($product->status === 'active')
                                    <span class="badge bg-success">Active</span>
                                    @else
                                    <span class="badge bg-secondary">{{ ucfirst($product->status) }}</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <p class="text-muted text-center py-3">No products associated with this farmer yet.</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Sidebar Information -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h6 class="fw-bold mb-3">Farmer Information</h6>
                <div class="mb-3">
                    <small class="text-muted">Farmer ID</small>
                    <div><strong>#{{ $farmer->id }}</strong></div>
                </div>
                <div class="mb-3">
                    <small class="text-muted">Status</small>
                    <div>
                        @if($farmer->status === 'active')
                        <span class="badge bg-success">Active</span>
                        @elseif($farmer->status === 'inactive')
                        <span class="badge bg-secondary">Inactive</span>
                        @else
                        <span class="badge bg-warning text-dark">Pending</span>
                        @endif
                    </div>
                </div>
                <div class="mb-3">
                    <small class="text-muted">Created Date</small>
                    <div>{{ $farmer->created_at->format('M d, Y') }}</div>
                </div>
                <div class="mb-3">
                    <small class="text-muted">Last Updated</small>
                    <div>{{ $farmer->updated_at->format('M d, Y H:i A') }}</div>
                </div>
                @if($farmer->user)
                <div class="mb-3 pt-3 border-top">
                    <small class="text-muted">Associated User</small>
                    <div>
                        <strong>{{ $farmer->user->name }}</strong>
                        <br>
                        <small>{{ $farmer->user->email }}</small>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
