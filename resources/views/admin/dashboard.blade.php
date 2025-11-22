@extends('admin.layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
<div class="mb-4">
    <h2 class="fw-bold mb-1">Dashboard</h2>
    <p class="text-muted">Welcome back, Admin! Here's what's happening with your store today.</p>
</div>

<!-- Statistics Cards -->
<div class="row g-4 mb-4">
    <div class="col-lg-3 col-md-6">
        <div class="card border-0 shadow-sm bg-primary text-white h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-white-50 mb-2">Total Products</h6>
                        <h2 class="fw-bold mb-0">{{ \App\Models\Product::count() }}</h2>
                    </div>
                    <div>
                        <i class="bi bi-basket3 display-4 opacity-50"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-transparent border-0">
                <a href="{{ route('admin.products.index') }}" class="text-white text-decoration-none small">
                    View All <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="card border-0 shadow-sm bg-success text-white h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-white-50 mb-2">Active Products</h6>
                        <h2 class="fw-bold mb-0">{{ \App\Models\Product::where('status', 'active')->count() }}</h2>
                    </div>
                    <div>
                        <i class="bi bi-check-circle display-4 opacity-50"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-transparent border-0">
                <a href="{{ route('admin.products.index') }}?status=active" class="text-white text-decoration-none small">
                    View Active <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="card border-0 shadow-sm bg-warning text-dark h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-2">Low Stock</h6>
                        <h2 class="fw-bold mb-0">{{ \App\Models\Product::whereBetween('quantity_available', [1, 20])->count() }}</h2>
                    </div>
                    <div>
                        <i class="bi bi-exclamation-triangle display-4 opacity-50"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-transparent border-0">
                <a href="{{ route('admin.products.index') }}" class="text-dark text-decoration-none small">
                    View Stock <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="card border-0 shadow-sm bg-danger text-white h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-white-50 mb-2">Total Farmers</h6>
                        <h2 class="fw-bold mb-0">{{ \App\Models\Farmer::count() }}</h2>
                    </div>
                    <div>
                        <i class="bi bi-people display-4 opacity-50"></i>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-transparent border-0">
                <a href="{{ route('farmers.index') }}" class="text-white text-decoration-none small">
                    View Farmers <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Recent Products & Quick Actions -->
<div class="row">
    <!-- Recent Products -->
    <div class="col-lg-8 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold">Recent Products</h5>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Product</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>Stock</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse(\App\Models\Product::with('farmer')->latest()->take(5)->get() as $product)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" 
                                             class="rounded me-2" style="width: 40px; height: 40px; object-fit: cover;">
                                        <div>
                                            <strong>{{ $product->name }}</strong>
                                            <br><small class="text-muted">{{ $product->farmer->farm_name ?? 'N/A' }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="badge bg-primary">{{ $product->category }}</span></td>
                                <td class="fw-bold text-success">Rs. {{ number_format($product->price, 2) }}</td>
                                <td>{{ $product->quantity_available }}</td>
                                <td>
                                    @if($product->status === 'active')
                                    <span class="badge bg-success">Active</span>
                                    @else
                                    <span class="badge bg-secondary">{{ ucfirst($product->status) }}</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.products.edit', $product->id) }}" 
                                       class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <i class="bi bi-inbox display-4 text-muted"></i>
                                    <p class="text-muted mt-2">No products yet. Start by adding one!</p>
                                    <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                                        <i class="bi bi-plus-circle me-2"></i> Add Product
                                    </a>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions & Info -->
    <div class="col-lg-4">
        <!-- Quick Actions -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0 fw-bold">Quick Actions</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.products.create') }}" class="btn btn-success">
                        <i class="bi bi-plus-circle me-2"></i> Add New Product
                    </a>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-outline-primary">
                        <i class="bi bi-list-ul me-2"></i> Manage Products
                    </a>
                    <a href="{{ route('home') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-globe me-2"></i> View Website
                    </a>
                </div>
            </div>
        </div>

        <!-- Category Overview -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0 fw-bold">Products by Category</h5>
            </div>
            <div class="card-body">
                @php
                    $categories = \App\Models\Product::select('category', \DB::raw('count(*) as total'))
                        ->groupBy('category')
                        ->get();
                @endphp
                
                @forelse($categories as $cat)
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span>{{ $cat->category }}</span>
                    <span class="badge bg-primary">{{ $cat->total }}</span>
                </div>
                @empty
                <p class="text-muted text-center small">No products yet</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection