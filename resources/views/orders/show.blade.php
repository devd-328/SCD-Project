@extends('layouts.app')

@section('title', 'Order #' . $order->id . ' - AgriConnect')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Order #{{ $order->id }}</h2>
            <p class="text-muted mb-0">Placed on {{ $order->created_at->format('M d, Y h:i A') }}</p>
        </div>
        <div>
            <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Back to Orders
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Order Items -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold">Items</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th class="text-end pe-4">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                <tr>
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center">
                                            @php
                                                $img = $item->product && $item->product->image_path 
                                                    ? asset('assets/images/products/' . basename($item->product->image_path)) 
                                                    : asset('assets/images/default-product.png');
                                            @endphp
                                            <img src="{{ $img }}" alt="{{ $item->product_name }}" 
                                                 class="rounded me-3" style="width: 50px; height: 50px; object-fit: cover;">
                                            <div>
                                                <strong>{{ $item->product_name }}</strong>
                                                @if($item->product && $item->product->category)
                                                <div class="small text-muted">{{ $item->product->category }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>Rs. {{ number_format($item->price, 2) }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td class="text-end pe-4 fw-bold">Rs. {{ number_format($item->price * $item->quantity, 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="table-light">
                                <tr>
                                    <td colspan="3" class="text-end fw-bold pt-3">Subtotal</td>
                                    <td class="text-end pe-4 pt-3">Rs. {{ number_format($order->total_amount, 2) }}</td>
                                </tr>
                                <!-- Add tax/shipping if you store them separately, assuming total_amount is final for now -->
                                <tr>
                                    <td colspan="3" class="text-end fw-bold text-success border-0 pb-3">Grand Total</td>
                                    <td class="text-end pe-4 fw-bold text-success border-0 pb-3 h5 mb-0">Rs. {{ number_format($order->total_amount, 2) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Info -->
        <div class="col-lg-4">
            <!-- Status Card -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">Order Status</h5>
                    @if($order->status == 'pending')
                        <div class="alert alert-warning mb-0 d-flex align-items-center">
                            <i class="bi bi-clock me-2 fs-4"></i>
                            <div>
                                <strong>Pending</strong>
                                <div class="small">Your order is being processed.</div>
                            </div>
                        </div>
                    @elseif($order->status == 'completed')
                        <div class="alert alert-success mb-0 d-flex align-items-center">
                            <i class="bi bi-check-circle me-2 fs-4"></i>
                            <div>
                                <strong>Completed</strong>
                                <div class="small">Delivered on {{ $order->updated_at->format('M d, Y') }}</div>
                            </div>
                        </div>
                    @elseif($order->status == 'cancelled')
                        <div class="alert alert-danger mb-0 d-flex align-items-center">
                            <i class="bi bi-x-circle me-2 fs-4"></i>
                            <div>
                                <strong>Cancelled</strong>
                                <div class="small">This order was cancelled.</div>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-secondary mb-0">
                            <strong>{{ ucfirst($order->status) }}</strong>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Shipping Info -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold">Shipping Details</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <small class="text-muted d-block">Name</small>
                        <strong>{{ $order->user->name ?? 'Guest' }}</strong>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted d-block">Email</small>
                        <span>{{ $order->user->email ?? 'N/A' }}</span>
                    </div>
                    <!-- Add address/phone fields if you add them to the orders table/checkout form later -->
                    <div>
                        <small class="text-muted d-block">Payment Method</small>
                        <span class="badge bg-secondary">Cash on Delivery</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
