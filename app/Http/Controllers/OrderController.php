<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;

class OrderController extends Controller
{
    /**
     * Display a listing of the user's orders.
     */
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
            ->withCount('items')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    /**
     * Display the specified order.
     */
    public function show($id)
    {
        $order = Order::where('user_id', Auth::id())
            ->with(['items.product'])
            ->findOrFail($id);

        return view('orders.show', compact('order'));
    }
}
