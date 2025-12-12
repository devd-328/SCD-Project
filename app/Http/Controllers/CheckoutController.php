<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;

class CheckoutController extends Controller
{
    /**
     * Handle a checkout request and decrement product stock.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:50',
            'address' => 'required|string',
            'paymentMethod' => 'required|string',
            'cart' => 'required|array',
            'cart.*.id' => 'nullable|integer',
            'cart.*.qty' => 'required|integer|min:1',
        ]);

        $cart = $data['cart'];

        // perform stock decrement and create order inside a DB transaction
        try {
            DB::beginTransaction();

            // compute server-side totals and persist order
            $subtotal = 0;
            $itemsToCreate = [];

            foreach ($cart as $item) {
                $qty = intval($item['qty']);
                $unitPrice = 0;
                $productId = null;

                if (!empty($item['id'])) {
                    // lock the row for update to prevent race conditions
                    $product = Product::where('id', $item['id'])->lockForUpdate()->first();
                    if (! $product) {
                        DB::rollBack();
                        return response()->json(['message' => 'Product not found: ' . ($item['id'] ?? 'unknown')], 404);
                    }
                    if ($product->quantity_available < $qty) {
                        DB::rollBack();
                        return response()->json(['message' => 'Insufficient stock for: ' . $product->name], 422);
                    }

                    // use authoritative price from DB
                    $unitPrice = (float) $product->price;
                    $productId = $product->id;

                    // decrement stock
                    $product->quantity_available = max(0, $product->quantity_available - $qty);
                    $product->save();
                } else {
                    // fallback item, use client-supplied price
                    $unitPrice = isset($item['price']) ? (float) $item['price'] : 0;
                }

                $lineTotal = +($unitPrice * $qty);
                $subtotal += $lineTotal;

                $itemsToCreate[] = [
                    'product_id' => $productId,
                    'product_name' => $item['name'] ?? 'Item',
                    'unit_price' => $unitPrice,
                    'quantity' => $qty,
                    'line_total' => $lineTotal,
                ];
            }

            $tax = round($subtotal * 0.05, 2);
            $total = round($subtotal + $tax, 2);

            // create order
            $orderNumber = 'ORD' . now()->format('YmdHis') . rand(100, 999);
            $order = Order::create([
                'user_id' => Auth::id(),
                'order_number' => $orderNumber,
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'address' => $data['address'],
                'payment_method' => $data['paymentMethod'] ?? null,
                'subtotal' => $subtotal,
                'tax' => $tax,
                'total' => $total,
            ]);

            // create items
            foreach ($itemsToCreate as $it) {
                $it['order_id'] = $order->id;
                OrderItem::create($it);
            }

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json(['message' => 'Failed to process order.'], 500);
        }

        return response()->json(['success' => true, 'order_number' => $order->order_number]);
    }
}
