<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Jika belum login, arahkan ke login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Ambil role user
        $user = Auth::user();

        // Jika role user tidak ada dalam daftar role yang diizinkan
        if (!in_array($user->role, $roles)) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}
