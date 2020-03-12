<?php

namespace App\Http\Middleware;

use Closure;

class UserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!$request->user()->hasUserRole()) {

            return \response()->json(
                [
                    "status" => "forbiden",
                    "message" => "Sorry, You hove not user role",
                    "code" => 401
                ]
            );
        }

        return $next($request);
    }
}
