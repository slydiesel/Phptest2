<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Versioner
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // config(['app.api.request' =>['controller'=>['namespace'=>]];
        return $next($request);
    }
}
