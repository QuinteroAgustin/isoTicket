<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Technicien;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Technicien::isAuthenticated()) {
            return redirect()->route('home');
        }

        return $next($request);
    }
}
