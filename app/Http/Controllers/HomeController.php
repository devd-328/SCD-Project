<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class HomeController extends Controller
{
    /**
     * Display the homepage
     */
    public function index()
    {
        // Get actual products from database, limit to 3
        $dbProducts = Product::with('farmer')->latest()->take(3)->get();

        // Map DB products to array format
        $featuredProducts = $dbProducts->map(function (Product $p) {
            return [
                'id' => $p->id,
                'name' => $p->name,
                'description' => $p->description ?? '',
                'category' => $p->category ?? 'Other',
                'price' => (float) $p->price,
                'unit' => $p->unit ?? 'kg',
                'farmer' => $p->farmer->farm_name ?? ($p->farmer->user->name ?? 'Unknown'),
                'image' => $p->image_path ? basename($p->image_path) : 'default-product.png',
                'image_url' => $p->image_path ? asset('assets/images/products/' . basename($p->image_path)) : asset('assets/images/default-product.png')
            ];
        })->toArray();

        // Fallback to static products if no database products exist
        if (empty($featuredProducts)) {
            $featuredProducts = [
                [
                    'id' => 1,
                    'name' => 'Organic Tomatoes',
                    'description' => 'Fresh, juicy organic tomatoes grown without pesticides',
                    'category' => 'Vegetables',
                    'price' => 175,
                    'unit' => 'kg',
                    'farmer' => 'Green Valley Farm',
                    'image' => 'tomatoes.webp'
                ],
                [
                    'id' => 2,
                    'name' => 'Fresh Eggs',
                    'description' => 'Free-range eggs from happy chickens',
                    'category' => 'Dairy',
                    'price' => 300,
                    'unit' => 'dozen',
                    'farmer' => 'Sunny Side Farm',
                    'image' => 'eggs.webp'
                ],
                [
                    'id' => 3,
                    'name' => 'Organic Carrots',
                    'description' => 'Sweet and crunchy organic carrots',
                    'category' => 'Vegetables',
                    'price' => 200,
                    'unit' => 'kg',
                    'farmer' => 'Harvest Hills',
                    'image' => 'fresh_carrots.webp'
                ]
            ];
        }

        return view('home', compact('featuredProducts'));
    }

    /**
     * Display the about page
     */
    public function about()
    {
        return view('about');
    }
}