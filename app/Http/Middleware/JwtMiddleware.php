<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class JwtMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            JWTAuth::parseToken()->authenticate();
        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return response()->json([
                    'errors' =>[
                    'status_code' => 401,
                    'messages'    => 'Invalid token'
                    ]
                ], 401);
            } elseif ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return response()->json([
                    'errors' =>[
                    'status_code' => 401,
                    'messages'    => 'Token is Expired'
                    ]
                ], 401);
            } else {
                return response()->json([
                    'errors' =>[
                    'status_code' => 401,
                    'messages'    => 'Token not found'
                    ]
                ], 401);
            }
        }
            
        return $next($request);
    }
}
