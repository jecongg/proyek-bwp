<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    public function profile()
    {
        $user = Auth::user();
        return view('customer.profile', compact('user'));
    }

    /**
     * Tampilkan halaman kontak.
     */
    public function contact()
    {
        return view('customer.contact');
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
