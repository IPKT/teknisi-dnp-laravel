<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = $request->user();

        // jika belum login
        if (!$user) {
            return redirect()->route('login');
        }

        // jika role user tidak cocok
        if (!in_array($user->role, $roles)) {
            abort(403, 'Akses ditolak - Anda tidak memiliki izin untuk halaman ini.');
        }

        return $next($request);
    }
}