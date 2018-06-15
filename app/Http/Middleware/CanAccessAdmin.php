<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CanAccessAdmin
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

        if (Auth::check() && Auth::user()->role_id >= 2) {
            return $next($request);
        }

        if($request->ajax())
        {
            return response()->json('You are not authorized to access this resource.', 401);
        }

        return redirect('admin/login');
    }
}
