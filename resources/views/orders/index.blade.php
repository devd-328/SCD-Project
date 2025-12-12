@extends('layouts.app')

@section('title', 'My Orders - AgriConnect')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12 mb-4">
            <h2 class="fw-bold mb-1">My Orders</h2>
            <p class="text-muted">Track and manage your recent purchases</p>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            @if($orders->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Order #</th>
                            <th>Date</th>
                            <th>Items</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        <tr>
                            <td class="fw-bold">#{{ $order->id }}</td>
                            <td>{{ $order->created_at->format('M d, Y') }}</td>
                            <td>{{ $order->items_count }} item(s)</td>
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
                                <a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm btn-outline-primary">
                                    View Details
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="mt-4">
                {{ $orders->links() }}
            </div>
            @else
            <div class="text-center py-5">
                <i class="bi bi-cart-x display-1 text-muted mb-3"></i>
                <h4>No orders found</h4>
                <p class="text-muted mb-4">Looks like you haven't made any purchases yet.</p>
                <a href="{{ route('products.index') }}" class="btn btn-success btn-lg">
                    Start Shopping
                </a>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
