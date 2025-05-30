<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Cookie;

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

        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            // Check if the user is active
            if (Auth::user()->status !== 'active') {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Your account is not active.',
                ])->onlyInput('email');
            }

            // Save cookies if remember me is checked
            if ($remember) {
                Cookie::queue('email', $request->email, 43200); // 30 days
                Cookie::queue('password', $request->password, 43200); // 30 days
            } else {
                Cookie::queue(Cookie::forget('email'));
                Cookie::queue(Cookie::forget('password'));
            }

            // Redirect based on role
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
                'unique:user,email'
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
                'string'
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
        ]);

        try {
            // Buat user baru
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'password' => Hash::make($validated['password']),
                'role' => $validated['role'],
                'url_image' => $validated['image'] ?? null // Gunakan URL yang dimasukkan oleh pengguna
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
