<?php

namespace App\Http\Middleware;

use Closure;

class AdminMiddleware
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
        if ($request->user()->user_type != 0)
        {
            // abort(403, 'Unauthorized action.');
            // return "Access Denied.";
            return redirect('results');
        }

        return $next($request);
    }

}
