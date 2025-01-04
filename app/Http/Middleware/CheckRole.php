<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, string $role)
    {
        // Pastikan user sudah login
        if (!Auth::check()) {
            return redirect('login');
        }

        // Debug untuk melihat role user
        // dd(Auth::user()->role);

        // Cek role user
        if (Auth::user()->role != $role) {
            return redirect('/')->with('error', 'Unauthorized access');
        }

        return $next($request);
    }
}
