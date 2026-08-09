<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureProfileIsComplete
{
    /**
     * Roles que requieren un registro propio en su tabla de perfil
     * (estudiantes / profesors / secretarias) además del rol de Spatie.
     */
    protected array $rolesConPerfil = ['estudiante', 'profesor', 'secretaria'];

    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if (!$user) {
            return $next($request);
        }

        // Evitar bucle de redirección en el propio formulario y en logout
        if ($request->routeIs('perfil.completar', 'perfil.completar.store', 'logout') || $request->is('logout')) {
            return $next($request);
        }

        foreach ($this->rolesConPerfil as $rol) {
            if ($user->hasRole($rol) && !$user->{$rol}) {
                return redirect()->route('perfil.completar');
            }
        }

        return $next($request);
    }
}
