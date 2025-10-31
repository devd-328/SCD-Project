<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display all products with filtering
     */
    public function index(Request $request)
    {
        // Static products data
        $allProducts = [
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

        // Get filter parameters
        $category = $request->input('category');
        $search = $request->input('search');

        // Apply filters
        $products = $allProducts;

        if ($category && $category !== 'all') {
            $products = array_filter($products, function($product) use ($category) {
                return $product['category'] === $category;
            });
        }

        if ($search) {
            $products = array_filter($products, function($product) use ($search) {
                return stripos($product['name'], $search) !== false || 
                       stripos($product['description'], $search) !== false;
            });
        }

        // Get unique categories for filter
        $categories = array_unique(array_column($allProducts, 'category'));

        return view('products.index', compact('products', 'categories', 'category', 'search'));
    }
}