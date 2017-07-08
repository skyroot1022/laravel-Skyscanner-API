<?php

namespace App\Http\Middleware;

use Closure;

class AddUUIDCookie
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
        if(\Cookie::has('uuid'))
        {
            return $next($request);
        }
        else
        {
            $uuid = \Uuid::generate();

            $response = $next($request);
            return $response->withCookie(\Cookie::forever('uuid', $uuid->__toString()));
        }
    }
}
