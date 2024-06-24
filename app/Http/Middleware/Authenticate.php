<?php

namespace App\Http\Middleware;

use App\Models\Technicien;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        // Vérifie si un technicien est connecté
        if (!Technicien::isAuthenticated()) {
            // Redirige vers la page de connexion
            return redirect()->route('login');
        }

        // Laisse la requête continuer
        return $next($request);
    }
}
