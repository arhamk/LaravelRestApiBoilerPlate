<?php

namespace App\Http\Middleware;

use App\Client;
use Closure;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class JwtApiKeyMiddleware
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
        if($request->header('xt-api-key')){
            //$host = $request->getHost();
            $host = 'localhost';
            $api_key = $request->header('xt-api-key');
            try {
                $client = Client::whereHost($host)->whereApiKey($api_key)->whereEnabled(true)->firstOrFail();
                $request->attributes->add(['client' => $client]);
                return $next($request);
            } catch (ModelNotFoundException $ex) {
                throw new UnprocessableEntityHttpException('Invalid api key, or user does not exist');
            }
        }
        throw new UnprocessableEntityHttpException('Invalid api key, or user does not exist');
    }
}
