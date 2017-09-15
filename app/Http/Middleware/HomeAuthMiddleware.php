<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;

class HomeAuthMiddleware
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
        $uid = $request->header('uid');
        if (!$uid) {
            $uid = $request->input('uid');
        }

        if (!$uid) {
            return response()->json(config('tips.uid.empty'));
        }

        $user = User::getUserByUuid($uid);
        if (!$user) {
            return response()->json(config('tips.uid.invalid'));
        }

        $request->user = $user;
        return $next($request);
    }
}
