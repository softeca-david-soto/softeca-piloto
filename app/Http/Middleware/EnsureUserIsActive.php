<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Verifica si el usuario está autenticado y si su estatus es distinto de 'activo'
        if (auth()->check() && auth()->user()->activo !== 1) {
            $mensaje = 'Tu cuenta está desactivada. Contacta al administrador.';
            Auth::guard('web')->logout(); // Cierra la sesión
            return redirect()->route('login')->with('account_status', $mensaje);
        }
            return $next($request);
    }
}
