<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BffAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->session()->has('api_token')) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthenticated.'], 401);
            }

            return redirect('/login');
        }

        // Inject token and tenant ID into request attributes for easy access
        $request->attributes->add(['api_token' => $request->session()->get('api_token')]);
        $request->attributes->add(['tenant_corporate_id' => $request->session()->get('tenant_corporate_id', 1)]);
        $request->attributes->add(['user_data' => $request->session()->get('user_data')]);

        return $next($request);
    }
}
