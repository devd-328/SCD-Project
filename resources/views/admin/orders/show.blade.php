@extends('admin.layouts.admin')

@section('title', 'Order #' . $order->id)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-1">Order #{{ $order->id }}</h2>
        <p class="text-muted mb-0">Placed on {{ $order->created_at->format('M d, Y h:i A') }}</p>
    </div>
    <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-1"></i> Back to List
    </a>
</div>

<div class="row">
    <!-- Order Items -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold">Order Items</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Product</th>
                                <th>Price</th>
                                <th>Qty</th>
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
                                        <img src="{{ $img }}" class="rounded me-3" style="width: 40px; height: 40px; object-fit: cover;">
                                        <div>
                                            <strong>{{ $item->product_name }}</strong>
                                            @if($item->product)
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
                                <td colspan="3" class="text-end fw-bold pt-3">Total Amount</td>
                                <td class="text-end pe-4 pt-3 fw-bold text-success h5">Rs. {{ number_format($order->total_amount, 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="col-lg-4">
        <!-- Status Update -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold">Update Status</h5>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success mb-3">{{ session('success') }}</div>
                @endif

                <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    
                    <div class="mb-3">
                        <label class="form-label">Current Status</label>
                        <select name="status" class="form-select">
                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="btn btn-success w-100">Update Status</button>
                </form>
            </div>
        </div>

        <!-- Customer Info -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h5 class="mb-0 fw-bold">Customer Details</h5>
            </div>
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="bg-light rounded-circle p-3 me-3">
                        <i class="bi bi-person text-muted fs-4"></i>
                    </div>
                    <div>
                        <h6 class="mb-0 fw-bold">{{ $order->user->name ?? 'Guest' }}</h6>
                        <small class="text-muted">Customer</small>
                    </div>
                </div>
                
                <div class="mb-2">
                    <i class="bi bi-envelope text-muted me-2"></i>
                    <span>{{ $order->user->email ?? 'N/A' }}</span>
                </div>
                
                <hr>
                
                <div class="mb-2">
                    <small class="text-muted d-block">Payment Method</small>
                    <strong>Cash on Delivery</strong>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
