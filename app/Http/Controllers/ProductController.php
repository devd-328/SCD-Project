<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Display all products with filtering — use DB-backed products with a fallback.
     */
    public function index(Request $request)
    {
        // Get filter parameters
        $category = $request->input('category');
        $search = $request->input('search');

        // Query DB products with farmer relation
        $query = Product::with('farmer')->orderBy('created_at', 'desc');

        if ($category && $category !== 'all') {
            $query->where('category', $category);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $dbProducts = $query->get();

        // Map DB products to the array shape expected by the view
        $products = $dbProducts->map(function (Product $p) {
            return [
                'id' => $p->id,
                'name' => $p->name,
                'description' => $p->description ?? '',
                'category' => $p->category ?? 'Other',
                'price' => (float) $p->price,
                'unit' => $p->unit ?? '',
                'farmer' => $p->farmer->farm_name ?? ($p->farmer->user->name ?? 'Unknown'),
                'location' => $p->farmer->location ?? null,
                // Provide both filename and a full URL for the view
                'image' => $p->image_path ? basename($p->image_path) : 'default-product.png',
                'image_url' => $p->image_path ? asset('assets/images/products/' . basename($p->image_path)) : asset('assets/images/default-product.png'),
                'quantity_available' => $p->quantity_available ?? 0,
                'is_organic' => $p->is_organic ?? false,
            ];
        })->toArray();

        // If DB empty, fall back to the bundled static sample products
        if (empty($products)) {
            $products = [
                [
                    'id' => 1,
                    'name' => 'Organic Tomatoes',
                    'description' => 'Fresh, juicy organic tomatoes grown without pesticides',
                    'category' => 'Vegetables',
                    'price' => 300,
                    'unit' => 'kg',
                    'farmer' => 'Green Valley Farm',
                    'location' => 'Punjab',
                    'image' => 'tomatoes.webp'
                ],
                [
                    'id' => 2,
                    'name' => 'Fresh Potatoes',
                    'description' => 'Farm-fresh potatoes perfect for any dish',
                    'category' => 'Vegetables',
                    'price' => 80,
                    'unit' => 'kg',
                    'farmer' => 'Harvest Hills',
                    'location' => 'Sindh',
                    'image' => 'fresh_potatoes.webp'
                ],
                [
                    'id' => 3,
                    'name' => 'Organic Carrots',
                    'description' => 'Sweet and crunchy organic carrots',
                    'category' => 'Vegetables',
                    'price' => 200,
                    'unit' => 'kg',
                    'farmer' => 'Harvest Hills',
                    'location' => 'Sindh',
                    'image' => 'fresh_carrots.webp'
                ],
                [
                    'id' => 4,
                    'name' => 'Fresh Milk',
                    'description' => 'Pure, fresh milk from grass-fed cows',
                    'category' => 'Dairy',
                    'price' => 260,
                    'unit' => 'liter',
                    'farmer' => 'Sunny Side Farm',
                    'location' => 'KPK',
                    'image' => 'fresh_milk.webp'
                ],
                [
                    'id' => 5,
                    'name' => 'Fresh Eggs',
                    'description' => 'Free-range eggs from happy chickens',
                    'category' => 'Dairy',
                    'price' => 300,
                    'unit' => 'dozen',
                    'farmer' => 'Sunny Side Farm',
                    'location' => 'KPK',
                    'image' => 'eggs.webp'
                ],
                [
                    'id' => 6,
                    'name' => 'Wheat Flour',
                    'description' => 'Stone-ground whole wheat flour',
                    'category' => 'Grains',
                    'price' => 120,
                    'unit' => 'kg',
                    'farmer' => 'Golden Harvest',
                    'location' => 'Punjab',
                    'image' => 'wheat_flour.webp'
                ]
            ];
        }

        // Build categories list from DB if available, otherwise from fallback
        $categories = !empty($dbProducts) ? $dbProducts->pluck('category')->unique()->values()->all() : array_unique(array_column($products, 'category'));

        return view('products.index', compact('products', 'categories', 'category', 'search'));
    }
}