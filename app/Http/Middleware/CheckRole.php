<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        if ($user->role !== $role) {
            abort(403, 'No tienes permisos para acceder a esta sección.');
        }

        if (!$user->active) {
            auth()->logout();
            return redirect()->route('login')->with('error', 'Tu cuenta ha sido desactivada. Contacta al administrador.');
        }

        return $next($request);
    }
}