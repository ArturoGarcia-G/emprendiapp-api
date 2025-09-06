<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureAuthenticatedApi
{
    public function handle(Request $request, Closure $next)
    {
        // Usa el guard 'sanctum' para autenticar el token Bearer
        if (! Auth::guard('sanctum')->user()) {
            return response()->json([
                'message' => 'No autenticado.'
            ], 401);
        }

        return $next($request);
    }
}
