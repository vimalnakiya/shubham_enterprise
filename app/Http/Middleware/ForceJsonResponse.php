<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ForceJsonResponse
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
   
    public function handle(Request $request, Closure $next)
    {   
        $request->headers->set('Accept', 'application/json');
        $response = $next($request);
        $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, Authorization, Accept, X-Socket-ID, X-HTTP-Method-Override');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set('Content-type', 'application/json');
        $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
        return $response;
    }
}
