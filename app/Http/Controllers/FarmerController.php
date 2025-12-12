<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Farmer;

class FarmerController extends Controller
{
    /**
     * Display all farmers/community members
     */
    public function index()
    {
        // Fetch active farmers from database with their product count
        $farmers = Farmer::where('status', 'active')
            ->withCount('products')
            ->get();

        return view('farmers.index', compact('farmers'));
    }

    /**
     * Display the specified farmer and their products.
     */
    public function show($id)
    {
        $farmer = Farmer::with(['products' => function($query) {
            $query->where('status', 'active');
        }])->findOrFail($id);

        return view('farmers.show', compact('farmer'));
    }
}