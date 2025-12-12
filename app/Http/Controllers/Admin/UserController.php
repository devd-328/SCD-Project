<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('is_admin', false)->latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function approve($id)
    {
        $user = User::findOrFail($id);
        $user->update(['is_approved' => true]);
        return redirect()->back()->with('success', 'User approved successfully.');
    }

    public function reject($id)
    {
        $user = User::findOrFail($id);
        $user->delete(); // Or just set is_approved = false if you want to keep the record
        return redirect()->back()->with('success', 'User rejected/deleted successfully.');
    }
}
