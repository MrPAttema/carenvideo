<?php

/**
 * [...]
 * Deze middleware check of er een
 * authenticatie token vanuit Caren
 * is ge-set.

 * 
 * @author  Patrick Attema
 * @version V0.1 29-03-2018
 * @since   V0.1
 */

namespace App\Http\Middleware;

use Closure;

class CheckToken
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
        if (session()->has('carenAuthToken')) {

        }
        return $next($request);

    }
}
