<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * Usage: role:admin or role:admin,kaprodi
     */
    public function handle(Request $request, Closure $next, string $roles): Response
    {
        $user = $request->user();
        if (!$user) {
            return redirect()->route('beranda');
        }

        if (($user->status ?? 'aktif') !== 'aktif') {
            auth()->logout();
            return redirect()->route('login')->withErrors([
                'email' => 'Akun Anda tidak aktif.',
            ]);
        }

        $allowed = collect(explode(',', $roles))
            ->map(fn($r) => trim($r))
            ->filter()
            ->values();

        if ($allowed->isEmpty()) {
            return $next($request);
        }

        if (!in_array($user->role ?? null, $allowed->all(), true)) {
            abort(403);
        }

        return $next($request);
    }
}
