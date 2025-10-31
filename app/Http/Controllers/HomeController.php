<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the homepage
     */
    public function index()
    {
        // Static featured products data
        $featuredProducts = [
            [
                'id' => 1,
                'name' => 'Organic Tomatoes',
                'category' => 'Vegetables',
                'price' => 175,
                'unit' => 'kg',
                'farmer' => 'Green Valley Farm',
                'image' => 'tomatoes.webp'
            ],
            [
                'id' => 2,
                'name' => 'Fresh Eggs',
                'category' => 'Dairy',
                'price' => 300,
                'unit' => 'dozen',
                'farmer' => 'Sunny Side Farm',
                'image' => 'eggs.webp'
            ],
            [
                'id' => 3,
                'name' => 'Organic Carrots',
                'category' => 'Vegetables',
                'price' => 200,
                'unit' => 'kg',
                'farmer' => 'Harvest Hills',
                'image' => 'fresh_carrots.webp'
            ]
        ];

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