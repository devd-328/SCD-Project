@extends('admin.layouts.admin')

@section('title', 'Manage Users')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-1">User Management</h2>
        <p class="text-muted">Approve or reject user registrations.</p>
    </div>
    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Back to Dashboard
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Registered At</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->created_at->format('M d, Y') }}</td>
                        <td>
                            @if($user->is_approved)
                                <span class="badge bg-success">Approved</span>
                            @else
                                <span class="badge bg-warning text-dark">Pending</span>
                            @endif
                        </td>
                        <td>
                            @if(!$user->is_approved)
                            <form action="{{ route('admin.users.approve', $user->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-sm btn-success" title="Approve">
                                    <i class="bi bi-check-lg"></i> Approve
                                </button>
                            </form>
                            @endif

                            <button type="button" class="btn btn-sm btn-danger" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#deleteConfirmationModal" 
                                    data-action="{{ route('admin.users.reject', $user->id) }}"
                                    title="Reject/Delete">
                                <i class="bi bi-trash"></i> Delete
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">No users found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection
