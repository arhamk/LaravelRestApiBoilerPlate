<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use Exception;

class JwtAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if($request->header('xt-user-token')) {
            try {
                $user = JWTAuth::parseToken()->authenticate();
            } catch (Exception $e) {
                if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                    return response()->json(['code' => 401, 'msg' => 'Invalid token'], 401);
                } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                    return response()->json(['code' => 401, 'msg' => 'Invalid token'], 401);
                } else {
                    return response()->json(['code' => 401, 'msg' => 'Invalid token'], 401);
                }
            }
            return $next($request);
        }else{
            throw new Exception('token missing');
        }
    }
}
