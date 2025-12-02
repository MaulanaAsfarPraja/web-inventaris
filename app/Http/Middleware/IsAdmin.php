<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if (!$user || !method_exists($user, 'isAdmin') || !$user->isAdmin()) {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak. Hanya admin yang boleh mengakses halaman ini.');
        }

        return $next($request);
    }
}