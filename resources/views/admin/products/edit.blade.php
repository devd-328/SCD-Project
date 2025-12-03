@extends('admin.layouts.admin')

@section('title', 'Edit Product')

@section('content')
<div class="mb-4">
    <h2 class="fw-bold mb-1">Edit Product</h2>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">Products</a></li>
            <li class="breadcrumb-item active">Edit: {{ $product->name }}</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Product Name -->
                    <div class="mb-3">
                        <label for="name" class="form-label">Product Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name', $product->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="4">{{ old('description', $product->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Category -->
                    <div class="mb-3">
                        <label for="category" class="form-label">Category <span class="text-danger">*</span></label>
                        <select class="form-select @error('category') is-invalid @enderror" 
                                id="category" name="category" required>
                            <option value="">Select Category</option>
                            <option value="Vegetables" {{ old('category', $product->category) == 'Vegetables' ? 'selected' : '' }}>Vegetables</option>
                            <option value="Fruits" {{ old('category', $product->category) == 'Fruits' ? 'selected' : '' }}>Fruits</option>
                            <option value="Dairy" {{ old('category', $product->category) == 'Dairy' ? 'selected' : '' }}>Dairy</option>
                            <option value="Grains" {{ old('category', $product->category) == 'Grains' ? 'selected' : '' }}>Grains</option>
                            <option value="Eggs" {{ old('category', $product->category) == 'Eggs' ? 'selected' : '' }}>Eggs & Poultry</option>
                            <option value="Honey" {{ old('category', $product->category) == 'Honey' ? 'selected' : '' }}>Honey</option>
                            <option value="Meat" {{ old('category', $product->category) == 'Meat' ? 'selected' : '' }}>Meat</option>
                            <option value="Other" {{ old('category', $product->category) == 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('category')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Price and Unit -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="price" class="form-label">Price (Rs.) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror" 
                                   id="price" name="price" value="{{ old('price', $product->price) }}" required>
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="unit" class="form-label">Unit <span class="text-danger">*</span></label>
                            <select class="form-select @error('unit') is-invalid @enderror" 
                                    id="unit" name="unit" required>
                                <option value="">Select Unit</option>
                                <option value="kg" {{ old('unit', $product->unit) == 'kg' ? 'selected' : '' }}>Kilogram (kg)</option>
                                <option value="liter" {{ old('unit', $product->unit) == 'liter' ? 'selected' : '' }}>Liter</option>
                                <option value="dozen" {{ old('unit', $product->unit) == 'dozen' ? 'selected' : '' }}>Dozen</option>
                                <option value="piece" {{ old('unit', $product->unit) == 'piece' ? 'selected' : '' }}>Piece</option>
                                <option value="bundle" {{ old('unit', $product->unit) == 'bundle' ? 'selected' : '' }}>Bundle</option>
                                <option value="box" {{ old('unit', $product->unit) == 'box' ? 'selected' : '' }}>Box</option>
                            </select>
                            @error('unit')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Quantity and Status -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="quantity_available" class="form-label">Quantity Available <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('quantity_available') is-invalid @enderror" 
                                   id="quantity_available" name="quantity_available" value="{{ old('quantity_available', $product->quantity_available) }}" required>
                            @error('quantity_available')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                            <select class="form-select @error('status') is-invalid @enderror" 
                                    id="status" name="status" required>
                                <option value="active" {{ old('status', $product->status) == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status', $product->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                <option value="out_of_stock" {{ old('status', $product->status) == 'out_of_stock' ? 'selected' : '' }}>Out of Stock</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Farmer -->
                    <div class="mb-3">
                        <label for="farmer_id" class="form-label">Farmer <span class="text-danger">*</span></label>
                        <select class="form-select @error('farmer_id') is-invalid @enderror" 
                                id="farmer_id" name="farmer_id" required>
                            <option value="">Select Farmer</option>
                            @foreach($farmers as $farmer)
                                <option value="{{ $farmer->id }}" {{ old('farmer_id', $product->farmer_id) == $farmer->id ? 'selected' : '' }}>
                                    {{ $farmer->farm_name }} - {{ $farmer->user?->name ?? 'Unknown' }}
                                </option>
                            @endforeach
                        </select>
                        @error('farmer_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Current Image Display -->
                    @if($product->image_path)
                    <div class="mb-3">
                        <label class="form-label">Current Image</label>
                        <div>
                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" 
                                 class="img-thumbnail" style="max-width: 200px;">
                        </div>
                    </div>
                    @endif

                    <!-- Upload New Image -->
                    <div class="mb-3">
                        <label for="image" class="form-label">Upload New Image (Optional)</label>
                        <input type="file" class="form-control @error('image') is-invalid @enderror" 
                               id="image" name="image" accept=".jpg,.jpeg,.png,.webp">
                        <small class="text-muted">Leave empty to keep current image. Max size: 1MB. Allowed formats: JPG, PNG, WebP</small>
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Harvest Date -->
                    <div class="mb-3">
                        <label for="harvest_date" class="form-label">Harvest Date</label>
                        <input type="date" class="form-control @error('harvest_date') is-invalid @enderror" 
                               id="harvest_date" name="harvest_date" 
                               value="{{ old('harvest_date', $product->harvest_date ? $product->harvest_date->format('Y-m-d') : '') }}">
                        @error('harvest_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Is Organic Checkbox -->
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="is_organic" name="is_organic" value="1" 
                               {{ old('is_organic', $product->is_organic) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_organic">
                            <i class="bi bi-patch-check-fill text-success"></i> This product is organically grown
                        </label>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-check-circle me-2"></i> Update Product
                        </button>
                        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                            <i class="bi bi-x-circle me-2"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Product Info Sidebar -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h6 class="fw-bold mb-3">Product Information</h6>
                <div class="mb-2">
                    <small class="text-muted">Product ID:</small>
                    <div><strong>#{{ $product->id }}</strong></div>
                </div>
                <div class="mb-2">
                    <small class="text-muted">Created:</small>
                    <div>{{ $product->created_at->format('M d, Y') }}</div>
                </div>
                <div class="mb-2">
                    <small class="text-muted">Last Updated:</small>
                    <div>{{ $product->updated_at->format('M d, Y H:i') }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection