<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Technicien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Symfony\Component\HttpFoundation\Response;

class RememberMeMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if (Technicien::isAuthenticated()== false && Cookie::get('email') && Cookie::get('remember_me')) {

            $technicien = Technicien::where('email', Cookie::get('email'))->first();
            if ($technicien) {
                Technicien::loginCookie($technicien->email, true);
            }
        }
        return $next($request);
    }
}
