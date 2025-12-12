@extends('admin.layouts.admin')

@section('title', 'Manage Orders')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-1">Order Management</h2>
        <p class="text-muted">Track and update customer orders</p>
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
                        <th>Order #</th>
                        <th>Customer</th>
                        <th>Date</th>
                        <th>Items</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                    <tr>
                        <td><strong>#{{ $order->id }}</strong></td>
                        <td>
                            <div>{{ $order->user->name ?? 'Guest' }}</div>
                            <small class="text-muted">{{ $order->user->email ?? 'N/A' }}</small>
                        </td>
                        <td>{{ $order->created_at->format('M d, Y') }}</td>
                        <td>{{ $order->items_count }}</td>
                        <td class="fw-bold text-success">Rs. {{ number_format($order->total_amount, 2) }}</td>
                        <td>
                            @if($order->status == 'pending')
                                <span class="badge bg-warning text-dark">Pending</span>
                            @elseif($order->status == 'completed')
                                <span class="badge bg-success">Completed</span>
                            @elseif($order->status == 'cancelled')
                                <span class="badge bg-danger">Cancelled</span>
                            @else
                                <span class="badge bg-secondary">{{ ucfirst($order->status) }}</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-primary">
                                Manage
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">No orders found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $orders->links() }}
        </div>
    </div>
</div>
@endsection
