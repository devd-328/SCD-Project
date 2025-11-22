<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Display a listing of the products.
     */
    public function index()
    {
        $products = Product::latest()->paginate(15);
        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        // If a Farmer model exists, fetch farmers, otherwise pass empty collection
        $farmers = class_exists('\App\Models\Farmer') ? \App\Models\Farmer::all() : collect();
        return view('admin.products.create', compact('farmers'));
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|string|max:100',
            'price' => 'required|numeric|min:0',
            'unit' => 'required|string|max:50',
            'quantity_available' => 'required|integer|min:0',
            'farmer_id' => 'nullable|integer',
            'status' => 'nullable|string|in:active,inactive,out_of_stock',
            'is_organic' => 'nullable|boolean',
            'harvest_date' => 'nullable|date',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . Str::slug($request->input('name', 'product')) . '.' . $file->getClientOriginalExtension();
            $dir = public_path('assets/images/products');
            if (! File::exists($dir)) {
                File::makeDirectory($dir, 0755, true);
            }
            $file->move($dir, $filename);
            $data['image_path'] = $filename;
        }

        // Normalize boolean
        $data['is_organic'] = ! empty($data['is_organic']);

        Product::create($data);

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified product.
     */
    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('admin.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $farmers = class_exists('\App\Models\Farmer') ? \App\Models\Farmer::all() : collect();
        return view('admin.products.edit', compact('product', 'farmers'));
    }

    /**
     * Update the specified product in storage.
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|string|max:100',
            'price' => 'required|numeric|min:0',
            'unit' => 'required|string|max:50',
            'quantity_available' => 'required|integer|min:0',
            'farmer_id' => 'nullable|integer',
            'status' => 'nullable|string|in:active,inactive,out_of_stock',
            'is_organic' => 'nullable|boolean',
            'harvest_date' => 'nullable|date',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // delete old
            if ($product->image_path) {
                $old = public_path('assets/images/products/' . $product->image_path);
                if (File::exists($old)) {
                    @unlink($old);
                }
            }
            $file = $request->file('image');
            $filename = time() . '_' . Str::slug($request->input('name', 'product')) . '.' . $file->getClientOriginalExtension();
            $dir = public_path('assets/images/products');
            if (! File::exists($dir)) {
                File::makeDirectory($dir, 0755, true);
            }
            $file->move($dir, $filename);
            $data['image_path'] = $filename;
        }

        $data['is_organic'] = ! empty($data['is_organic']);

        $product->update($data);

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified product from storage.
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        if ($product->image_path) {
            $path = public_path('assets/images/products/' . $product->image_path);
            if (File::exists($path)) {
                @unlink($path);
            }
        }
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Product deleted.');
    }
}