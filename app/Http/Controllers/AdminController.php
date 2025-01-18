<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AdminController extends Controller
{
    public function profile()
    {
        $user = Auth::user();
        return view('admin.profile', compact('user'));
    }

    public function orders()
    {
        // Logika untuk menampilkan pesanan
        return view('admin.orders'); // Buat file view di resources/views/admin/orders.blade.php
    }

    // Reports
    public function reports()
    {
        // Logika untuk menampilkan laporan
        return view('admin.reports'); // Buat file view di resources/views/admin/reports.blade.php
    }

    // Manage Users
    public function users()
    {
        $customers = User::where('role', 'Customer')->get();
        return view('admin.users', compact('customers'));
    }

    public function toggleStatus($id)
    {
        $user = User::find($id);
        $user->status = $user->status === 'active' ? 'not active' : 'active';
        $user->save();

        return redirect()->back()->with('status', 'User status updated successfully!');
    }

    public function updateProfile(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:user,email,' . auth()->id(),
            'phone' => 'required|string|max:15',
            'password' => 'nullable|string|min:6|confirmed', // Password bersifat opsional
        ]);

        $user = auth()->user();

        // Update nama, email, dan telepon
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->phone = $validated['phone'];

        // Jika password diubah, kita akan mengenkripsi password dan menyimpannya
        if ($request->filled('password')) {
            $user->password = bcrypt($validated['password']);
        }

        $user->save();

        return redirect()->route('customer.profile')->with('success', 'Profile updated successfully.');
    }
}
