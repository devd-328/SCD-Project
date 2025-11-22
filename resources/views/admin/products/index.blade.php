@extends('admin.layouts.admin')

@section('title', 'Manage Products')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-1">Products Management</h2>
        <p class="text-muted">Manage all products in your inventory</p>
    </div>
    <a href="{{ route('admin.products.create') }}" class="btn btn-success">
        <i class="bi bi-plus-circle me-2"></i> Add New Product
    </a>
</div>

<!-- Products Table -->
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Image</th>
                        <th>Product Name</th>
                        <th>Farmer</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                    <tr>
                        <td>{{ $product->id }}</td>
                        <td>
                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" 
                                 class="img-thumbnail" style="width: 50px; height: 50px; object-fit: cover;">
                        </td>
                        <td>
                            <strong>{{ $product->name }}</strong>
                            @if($product->is_organic)
                            <span class="badge bg-success ms-1">Organic</span>
                            @endif
                        </td>
                        <td>{{ $product->farmer->farm_name ?? 'N/A' }}</td>
                        <td>
                            <span class="badge bg-primary">{{ $product->category }}</span>
                        </td>
                        <td class="fw-bold text-success">Rs. {{ number_format($product->price, 2) }}/{{ $product->unit }}</td>
                        <td>
                            @if($product->quantity_available > 20)
                            <span class="badge bg-success">{{ $product->quantity_available }}</span>
                            @elseif($product->quantity_available > 0)
                            <span class="badge bg-warning text-dark">{{ $product->quantity_available }}</span>
                            @else
                            <span class="badge bg-danger">Out of Stock</span>
                            @endif
                        </td>
                        <td>
                            @if($product->status === 'active')
                            <span class="badge bg-success">Active</span>
                            @elseif($product->status === 'inactive')
                            <span class="badge bg-secondary">Inactive</span>
                            @else
                            <span class="badge bg-danger">Out of Stock</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.products.show', $product->id) }}" 
                                   class="btn btn-info" title="View">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('admin.products.edit', $product->id) }}" 
                                   class="btn btn-warning" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.products.destroy', $product->id) }}" 
                                      method="POST" class="d-inline"
                                      onsubmit="return confirm('Are you sure you want to delete this product?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" title="Delete">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center py-4">
                            <i class="bi bi-inbox display-4 text-muted"></i>
                            <p class="text-muted mt-2">No products found. Add your first product!</p>
                            <a href="{{ route('admin.products.create') }}" class="btn btn-success">
                                <i class="bi bi-plus-circle me-2"></i> Add Product
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-3">
            {{ $products->links() }}
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mt-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm bg-primary text-white">
            <div class="card-body">
                <h6 class="text-white-50">Total Products</h6>
                <h3 class="fw-bold">{{ \App\Models\Product::count() }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm bg-success text-white">
            <div class="card-body">
                <h6 class="text-white-50">Active Products</h6>
                <h3 class="fw-bold">{{ \App\Models\Product::where('status', 'active')->count() }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm bg-warning text-dark">
            <div class="card-body">
                <h6>Low Stock</h6>
                <h3 class="fw-bold">{{ \App\Models\Product::whereBetween('quantity_available', [1, 20])->count() }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm bg-danger text-white">
            <div class="card-body">
                <h6 class="text-white-50">Out of Stock</h6>
                <h3 class="fw-bold">{{ \App\Models\Product::where('quantity_available', 0)->count() }}</h3>
            </div>
        </div>
    </div>
</div>
@endsection