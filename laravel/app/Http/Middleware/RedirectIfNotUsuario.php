<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfNotUsuario
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::guard('usuarios')->check()) {
            return redirect()->route('usuario.login'); // Certifique-se de que essa rota está definida
        }

        return $next($request);
    }
}
