<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FarmerController extends Controller
{
    /**
     * Display all farmers/community members
     */
    public function index()
    {
        // Static farmers data
        $farmers = [
            [
                'id' => 1,
                'name' => 'Ahmed Khan',
                'farm_name' => 'Green Valley Farm',
                'bio' => 'Specializing in organic vegetables for over 15 years. Committed to sustainable farming practices.',
                'location' => 'Punjab',
                'specialization' => 'Organic Vegetables',
                'products_count' => 12,
                'image' => 'ahmed.jpg',
                'phone' => '+92 300 1234567',
                'email' => 'ahmed@greenvalley.com'
            ],
            [
                'id' => 2,
                'name' => 'Fatima Ali',
                'farm_name' => 'Sunny Side Farm',
                'bio' => 'Family-run dairy farm providing fresh milk and eggs to local communities.',
                'location' => 'KPK',
                'specialization' => 'Dairy Products',
                'products_count' => 8,
                'image' => 'fatima.jpeg',
                'phone' => '+92 301 2345678',
                'email' => 'fatima@sunnyside.com'
            ],
            [
                'id' => 3,
                'name' => 'Hassan Raza',
                'farm_name' => 'Harvest Hills',
                'bio' => 'Growing premium quality vegetables using modern farming techniques.',
                'location' => 'Sindh',
                'specialization' => 'Root Vegetables',
                'products_count' => 10,
                'image' => 'hassan.webp',
                'phone' => '+92 302 3456789',
                'email' => 'hassan@harvesthills.com'
            ],
            [
                'id' => 4,
                'name' => 'Zainab Malik',
                'farm_name' => 'Golden Harvest',
                'bio' => 'Traditional grain farming with focus on wheat and rice production.',
                'location' => 'Punjab',
                'specialization' => 'Grains & Cereals',
                'products_count' => 6,
                'image' => 'zainab.jpg',
                'phone' => '+92 303 4567890',
                'email' => 'zainab@goldenharvest.com'
            ]
        ];

        return view('farmers.index', compact('farmers'));
    }
}