<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserOwnership
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Allow access if user is updating their own profile or is an admin
        if ($request->user()->id == $request->route('id') || $request->user()->role === 'admin') {
            return $next($request);
        }

        return response()->json([
            'is_success' => false,
            'message' => 'You do not have permission to update this user.'
        ], 403);
    }
}
