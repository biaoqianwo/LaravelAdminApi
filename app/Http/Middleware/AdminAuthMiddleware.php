<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;

class AdminAuthMiddleware
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
        $token = $request->header('_token');
        if (!$token) {
            $token = $request->input('token');
        }

        if (!$token) {
            return response()->json(config('tips.token.empty'));
        }

        $user = User::getUserByToken($token);
        if (!$user) {
            return response()->json(config('tips.token.invalid'));
        }

        $request->user = $user;
        return $next($request);
    }
}
