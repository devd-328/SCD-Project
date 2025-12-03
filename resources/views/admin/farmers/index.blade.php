@extends('admin.layouts.admin')

@section('title', 'Manage Farmers')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-1">Farmers Management</h2>
        <p class="text-muted">Manage all farmers in your community</p>
    </div>
    <a href="{{ route('admin.farmers.create') }}" class="btn btn-success">
        <i class="bi bi-plus-circle me-2"></i> Add New Farmer
    </a>
</div>

<!-- Farmers Table -->
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Profile Image</th>
                        <th>Name</th>
                        <th>Farm Name</th>
                        <th>Location</th>
                        <th>Phone</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($farmers as $farmer)
                    <tr>
                        <td>{{ $farmer->id }}</td>
                        <td>
                            @if($farmer->profile_image)
                            <img src="{{ asset('assets/images/farmers/' . $farmer->profile_image) }}" 
                                 alt="{{ $farmer->name }}" 
                                 class="img-thumbnail" style="width: 50px; height: 50px; object-fit: cover;">
                            @else
                            <div class="bg-light d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; border-radius: 4px;">
                                <i class="bi bi-person text-muted"></i>
                            </div>
                            @endif
                        </td>
                        <td>
                            <strong>{{ $farmer->name }}</strong>
                            @if(optional($farmer->user)->name)
                            <br><small class="text-muted">User: {{ $farmer->user->name }}</small>
                            @endif
                        </td>
                        <td>{{ $farmer->farm_name }}</td>
                        <td>{{ $farmer->location }}</td>
                        <td>{{ $farmer->phone }}</td>
                        <td>
                            @if($farmer->status === 'active')
                            <span class="badge bg-success">Active</span>
                            @elseif($farmer->status === 'inactive')
                            <span class="badge bg-secondary">Inactive</span>
                            @else
                            <span class="badge bg-warning text-dark">Pending</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.farmers.show', $farmer->id) }}" 
                                   class="btn btn-info" title="View">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('admin.farmers.edit', $farmer->id) }}" 
                                   class="btn btn-warning" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.farmers.destroy', $farmer->id) }}" 
                                      method="POST" class="d-inline"
                                      onsubmit="return confirm('Are you sure you want to delete this farmer?');">
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
                        <td colspan="8" class="text-center py-4">
                            <i class="bi bi-inbox display-4 text-muted"></i>
                            <p class="text-muted mt-2">No farmers found. Add your first farmer!</p>
                            <a href="{{ route('admin.farmers.create') }}" class="btn btn-success">
                                <i class="bi bi-plus-circle me-2"></i> Add Farmer
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-3">
            {{ $farmers->links() }}
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mt-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm bg-primary text-white">
            <div class="card-body">
                <h6 class="text-white-50">Total Farmers</h6>
                <h3 class="fw-bold">{{ \App\Models\Farmer::count() }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm bg-success text-white">
            <div class="card-body">
                <h6 class="text-white-50">Active Farmers</h6>
                <h3 class="fw-bold">{{ \App\Models\Farmer::where('status', 'active')->count() }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm bg-warning text-dark">
            <div class="card-body">
                <h6>Inactive Farmers</h6>
                <h3 class="fw-bold">{{ \App\Models\Farmer::where('status', 'inactive')->count() }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm bg-info text-white">
            <div class="card-body">
                <h6 class="text-white-50">Total Products</h6>
                <h3 class="fw-bold">{{ \App\Models\Product::count() }}</h3>
            </div>
        </div>
    </div>
</div>
@endsection
