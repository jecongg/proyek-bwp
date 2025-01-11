<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function editAdmin()
    {
        $user = Auth::user();
        return view('admin.profile', compact('user'));
    }

    public function editCustomer()
    {
        $user = Auth::user();
        return view('customer.profile', compact('user'));
    }

    public function updateAdmin(Request $request)
    {
        $user = Auth::user();

        // Validation and profile update logic for Admin
        $this->validateProfile($request, $user);

        $this->updateUserProfile($request, $user);

        return redirect()->route('admin.profile.edit')->with('success', 'Profile updated successfully');
    }

    public function updateCustomer(Request $request)
    {
        $user = Auth::user();

        // Validation and profile update logic for Customer
        $this->validateProfile($request, $user);

        $this->updateUserProfile($request, $user);

        return redirect()->route('customer.profile.edit')->with('success', 'Profile updated successfully');
    }

    private function validateProfile(Request $request, $user)
    {
        // Apply common validation for both admin and customer
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:255',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    }

    private function updateUserProfile(Request $request, $user)
    {
        // Update profile logic (name, email, phone, password, and image)
        if ($request->hasFile('profile_image')) {
            $imagePath = $request->file('profile_image')->store('profile_images', 'public');
            $user->url_image = $imagePath;
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        if ($request->new_password) {
            $user->password = Hash::make($request->new_password);
        }
        $user->save();
    }
}
