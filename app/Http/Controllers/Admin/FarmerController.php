<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Farmer;
use App\Models\User;
use Illuminate\Support\Str;

class FarmerController extends Controller
{
    /**
     * Display a listing of the farmers.
     */
    public function index()
    {
        $farmers = Farmer::with('user')->latest()->paginate(15);
        return view('admin.farmers.index', compact('farmers'));
    }

    /**
     * Show the form for creating a new farmer.
     */
    public function create()
    {
        $users = User::all();
        return view('admin.farmers.create', compact('users'));
    }

    /**
     * Store a newly created farmer in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'farm_name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'profile_image' => 'nullable|mimes:jpeg,jpg,png,webp|max:1024',
            'user_id' => 'nullable|integer|exists:users,id',
            'status' => 'required|string|in:active,inactive,pending',
        ]);

        // Handle image upload
        if ($request->hasFile('profile_image')) {
            $file = $request->file('profile_image');
            $filename = time() . '_' . Str::slug($request->input('farm_name')) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/images/farmers'), $filename);
            $data['profile_image'] = $filename;
        }

        Farmer::create($data);

        return redirect()->route('admin.farmers.index')->with('success', 'Farmer created successfully.');
    }

    /**
     * Display the specified farmer.
     */
    public function show($id)
    {
        $farmer = Farmer::with('user', 'products')->findOrFail($id);
        return view('admin.farmers.show', compact('farmer'));
    }

    /**
     * Show the form for editing the specified farmer.
     */
    public function edit($id)
    {
        $farmer = Farmer::findOrFail($id);
        $users = User::all();
        return view('admin.farmers.edit', compact('farmer', 'users'));
    }

    /**
     * Update the specified farmer in storage.
     */
    public function update(Request $request, $id)
    {
        $farmer = Farmer::findOrFail($id);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'farm_name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'profile_image' => 'nullable|mimes:jpeg,jpg,png,webp|max:1024',
            'user_id' => 'nullable|integer|exists:users,id',
            'status' => 'required|string|in:active,inactive,pending',
        ]);

        // Handle image upload
        if ($request->hasFile('profile_image')) {
            // Delete old image if it exists
            if ($farmer->profile_image && file_exists(public_path('assets/images/farmers/' . $farmer->profile_image))) {
                unlink(public_path('assets/images/farmers/' . $farmer->profile_image));
            }

            $file = $request->file('profile_image');
            $filename = time() . '_' . Str::slug($request->input('farm_name')) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/images/farmers'), $filename);
            $data['profile_image'] = $filename;
        }

        $farmer->update($data);

        return redirect()->route('admin.farmers.index')->with('success', 'Farmer updated successfully.');
    }

    /**
     * Remove the specified farmer from storage.
     */
    public function destroy($id)
    {
        $farmer = Farmer::findOrFail($id);

        // Delete farmer's profile image if it exists
        if ($farmer->profile_image && file_exists(public_path('assets/images/farmers/' . $farmer->profile_image))) {
            unlink(public_path('assets/images/farmers/' . $farmer->profile_image));
        }

        $farmer->delete();
        return redirect()->route('admin.farmers.index')->with('success', 'Farmer deleted successfully.');
    }
}
