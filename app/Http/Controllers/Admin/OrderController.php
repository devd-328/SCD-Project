<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of all orders.
     */
    public function index()
    {
        $orders = Order::with('user')
            ->withCount('items')
            ->latest()
            ->paginate(15);

        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Display the specified order.
     */
    public function show($id)
    {
        $order = Order::with(['items.product', 'user'])->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Update the order status.
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,completed,cancelled'
        ]);

        $order = Order::findOrFail($id);
        $order->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Order status updated successfully.');
    }
}
