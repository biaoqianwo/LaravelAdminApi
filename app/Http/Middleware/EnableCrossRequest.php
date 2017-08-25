<?php

namespace App\Http\Middleware;

use Closure;

class EnableCrossRequest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //https://developer.mozilla.org/en-US/docs/Web/HTTP/Access_control_CORS
        //http://www.ruanyifeng.com/blog/2016/04/cors.html

        $response = $next($request);
        $response->header('Access-Control-Allow-Origin', '*');
        $response->header('Access-Control-Allow-Methods', 'GET,POST,DELETE,PATCH,PUT,OPTIONS');//'*'
        $response->header('Access-Control-Allow-Headers', 'token');
        $response->header('Access-Control-Max-Age', 7200);//2小时
        //$response->header('Access-Control-Allow-Credentials', 'true');//cookie
        return $response;
    }
}
