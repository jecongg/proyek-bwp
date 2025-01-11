<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        // Logika untuk mengelola pengguna
        return view('admin.users'); // Buat file view di resources/views/admin/users.blade.php
    }

    public function updateProfile(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . auth()->id(),
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
