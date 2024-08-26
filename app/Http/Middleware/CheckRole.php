<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Technicien;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $roleId): Response
    {
        // Vérifie si un technicien est connecté
        if (!Technicien::isAuthenticated()) {
            // Redirige vers la page de connexion
            return redirect()->route('login');
        }

        $technicien = Technicien::findOrFail(Technicien::getTechId());
        $technicienRoleId = $technicien->role->id_role;

        // Vérifiez si l'ID du rôle de l'utilisateur est inférieur ou égal à l'ID requis
        if ($technicienRoleId > $roleId) {
            // Si l'utilisateur a un rôle avec un ID supérieur à celui requis, refuser l'accès
            abort(403, 'Vous n\'avez pas les permissions nécessaires pour accéder à cette page.');
        }


        return $next($request);
    }
}
