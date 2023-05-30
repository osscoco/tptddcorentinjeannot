<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class Admin
{
    /**
     * Handle an incoming request.
     *
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::user()->isAdmin()) {
            return $next($request);
        }

        //Message JSON retourné
        return response()->json([
            'status' => true,
            'message' => 'Vous n\'êtes pas autorisé car vous n\'êtes pas administrateur'
        ], 200);
    }
}
