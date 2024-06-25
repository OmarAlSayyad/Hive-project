<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class SeekerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {   $user=Auth::user();
            if ($request->input('token') !==  $user->remember_token) {
                return response()->json([
                    'data' => '',
                    'message' => 'not authenticate ( token is not valid )',
                    'status' => 500
                ]);
            }

        if($user->role==='seeker')
        {
            return $next($request);
        }
        return response()->json([
            'data' => '',
            'message'=>'unauthorized',
            'status' => 401
        ]);
     }
}
