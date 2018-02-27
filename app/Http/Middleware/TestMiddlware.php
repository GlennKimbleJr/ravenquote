<?php

namespace App\Http\Middleware;

use Closure;

class TestMiddlware
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
        $request->offsetSet('joe', 'bob');
        return $next($request);
    }
}
