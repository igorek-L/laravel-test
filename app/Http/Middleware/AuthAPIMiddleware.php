<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AuthAPIMiddleware
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
        $user = Auth::guard('api')->user();

        if (empty($user)) {
            return \response()->json(
                [
                    "status" => "forbiden",
                    "message" => "Sorry, You have invalid credentials",
                    "code" => 400
                ]
            );
        }

        $request->merge(['user'=>$user]);

        return $next($request);
    }
}
