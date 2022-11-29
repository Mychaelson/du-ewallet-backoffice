<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;

use Closure;

// use Illuminate\Http\Response;

class Ajax
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
        if(!$request->ajax())
        {
            if(!session('session_uid'))
            {
                $_provided = [
                    'status' => FALSE,
                    'error' => 'Login failure'
                ];

                return response()->json($_provided);
            }

            $_provided = [
                'status' => FALSE,
                'error' => 'Service Unavailable'
            ];

            return abort(403, 'Service Unavailable');
        }

        return $next($request);
    }
}
