<?php

namespace App\Http\Middleware;

use Closure;

class AdminMiddleware
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
        if (!$request->user()->hasAdminRole()) {
            return \response()->json(
                [
                    "status" => "forbiden",
                    "message" => "Sorry, You hove not admin role",
                    "code" => 401
                ]
            );
        }

        return $next($request);
    }
}
