<?php

namespace App\Http\Middleware;

use Closure;
use Dingo\Api\Exception\InternalHttpException;
use Symfony\Component\CssSelector\Exception\InternalErrorException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class JwtClientTokenMiddleware
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
        $token = $request->header('xt-client-token');
        if($token){
            try{
                JWTAuth::setToken($token);
                $token = JWTAuth::getToken();
                $payload = JWTAuth::decode($token);
                if($payload['id'] && $payload['api_key'] && $payload['type'] === 'client'){
                    $clientArray = [
                        'id' => $payload['id'],
                        'api_key' => $payload['api_key'],
                        'type' => $payload['type'],
                    ];
                    $request->attributes->add(['client' => $clientArray]);
                    return $next($request);
                }

                throw new \Exception('invalid token', 500);

            }catch (TokenInvalidException $ex){
                throw new \Exception($ex->getMessage(), 500);
            }
        }

        throw new \Exception('missing token', 500);
    }
}
