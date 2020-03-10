<?php

namespace App\Http\Middleware;

use App\Role;
use Closure;
use Illuminate\Auth\TokenGuard;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;


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
