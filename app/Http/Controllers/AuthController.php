<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    // Menampilkan form login
    public function showLogin()
    {
        return view('auth.login');
    }

    // Proses login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->remember)) {
            $request->session()->regenerate();

            // Redirect berdasarkan role
            if (Auth::user()->role === 'Admin') {
                return redirect()->intended('/admin/dashboard');
            }
            return redirect()->intended('/customer/dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    // Menampilkan form register
    public function showRegister()
    {
        return view('auth.register');
    }

    // Proses register
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255'
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users,email'
            ],
            'phone' => [
                'required',
                'numeric',
                'digits_between:10,15'
            ],
            'password' => [
                'required',
                'string',
                'min:5',
                'confirmed'
            ],
            'role' => [
                'required',
                'string',
                'in:Admin,Customer'
            ],
            'image' => [
                'nullable',
                'image',
                'mimes:jpeg,png,jpg,gif'
            ]
        ], [
            'name.required' => 'Name is required',
            'email.required' => 'Email is required',
            'email.email' => 'Please enter a valid email address',
            'email.unique' => 'This email is already registered',
            'phone.required' => 'Phone number is required',
            'phone.numeric' => 'Phone number must contain only numbers',
            'phone.digits_between' => 'Phone number must be between 10 and 15 digits',
            'password.required' => 'Password is required',
            'password.min' => 'Password must be at least 5 characters',
            'password.confirmed' => 'Password confirmation does not match',
            'role.required' => 'Please select a role',
            'role.in' => 'Invalid role selected',
            'image.image' => 'The file must be an image',
            'image.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif'
        ]);

        try {
            // Buat user baru
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'password' => Hash::make($validated['password']),
                'role' => $validated['role'],
                'url_image' => $request->hasFile('image') ? $request->file('image')->store('profile_images', 'public') : null
            ]);

            // Login user setelah register
            Auth::login($user);

            // Redirect berdasarkan role
            if ($user->role === 'Admin') {
                return redirect()->intended('/admin/dashboard')->with('success', 'Registration successful! Welcome to admin dashboard.');
            }

            return redirect()->intended('/customer/dashboard')->with('success', 'Registration successful! Welcome to Pool Essential.');

        } catch (\Exception $e) {
            return back()->withInput()
                ->withErrors(['error' => 'An error occurred during registration. Please try again.']);
        }
    }

    // Proses logout
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
