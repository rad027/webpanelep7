<?php

namespace App\Http\Middleware;

use Closure;

class installed
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
        if(config('app.app_config') != 1){
            return redirect('install');
        }
        return $next($request);
    }
}
