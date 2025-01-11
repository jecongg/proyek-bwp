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
}
