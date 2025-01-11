<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{

    /**
     * Tampilkan halaman kontak.
     */
    public function contact()
    {
        return view('customer.contact');
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        // Validasi input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:255',
            'current_password' => 'required_with:new_password|current_password',
            'new_password' => ['nullable', 'confirmed', Password::min(8)->mixedCase()->numbers()->symbols()],
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Update nama, email, dan telepon
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->phone = $validated['phone'];

        // Handle perubahan password
        if ($request->filled('current_password') && $request->filled('new_password')) {
            if (Hash::check($validated['current_password'], $user->password)) {
                $user->password = Hash::make($validated['new_password']);
            } else {
                return redirect()->back()->withErrors(['current_password' => 'The provided password does not match our records.']);
            }
        }

        // Handle pembaruan gambar profil
        if ($request->hasFile('profile_image')) {
            // Jika ada gambar baru, unggah gambar dan simpan di kolom url_image
            $imagePath = $request->file('profile_image')->store('profile_images', 'public');
            $user->url_image = $imagePath;
        }

        // Simpan data pengguna
        $user->save();

        // Redirect berdasarkan role
        if ($user->role == 'Admin') {
            return redirect()->route('admin.profile')->with('success', 'Profile updated successfully');
        } else {
            return redirect()->route('customer.profile')->with('success', 'Profile updated successfully');
        }
    }

}
