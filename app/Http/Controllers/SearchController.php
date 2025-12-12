<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Farmer;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');

        if (!$query) {
            return response()->json([]);
        }

        // Search Products
        $products = Product::where('name', 'like', "%{$query}%")
                            ->orWhere('category', 'like', "%{$query}%")
                            ->select('id', 'name', 'category', 'price', 'image_path')
                            ->limit(5)
                            ->get();

        // Transform products
        $products->transform(function ($product) {
            $product->type = 'product';
            $product->image_url = $product->image_path 
                ? asset('assets/images/products/' . basename($product->image_path)) 
                : asset('assets/images/default-product.png');
            // Product URL logic is handled in frontend (redirects to index with filter)
            // But we can provide a direct link if needed, for now frontend handles it.
            return $product;
        });

        // Search Farmers
        $farmers = Farmer::where('farm_name', 'like', "%{$query}%")
                          ->orWhere('name', 'like', "%{$query}%")
                          ->orWhere('location', 'like', "%{$query}%")
                          ->select('id', 'farm_name', 'name', 'location', 'profile_image')
                          ->limit(5)
                          ->get();

        // Transform farmers
        $farmers->transform(function ($farmer) {
            $farmer->type = 'farmer';
            $farmer->image_url = $farmer->profile_image 
                ? asset('assets/images/farmers/' . $farmer->profile_image) 
                : asset('assets/images/farmers/default.jpg');
            $farmer->url = route('farmers.show', $farmer->id);
            return $farmer;
        });

        // Merge results
        $results = $products->concat($farmers);

        return response()->json($results);
    }
}
