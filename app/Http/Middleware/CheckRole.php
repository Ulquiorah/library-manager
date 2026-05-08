<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();
        
        if (!$user) {
            abort(401, 'Non authentifié');
        }

        // Convertir les rôles en entiers et vérifier si le rôle de l'utilisateur est autorisé
        $allowedRoles = array_map('intval', $roles);
        
        if (!in_array($user->role_id, $allowedRoles)) {
            abort(403, 'Accès non autorisé');
        }

        return $next($request);
    }
}
