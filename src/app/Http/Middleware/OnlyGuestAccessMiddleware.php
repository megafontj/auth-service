<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;
use Symfony\Component\HttpFoundation\Response;

class OnlyGuestAccessMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->bearerToken() !== null && PersonalAccessToken::findToken($request->bearerToken())) {
            abort(403, 'You are already logged in');
        }
        return $next($request);
    }
}
