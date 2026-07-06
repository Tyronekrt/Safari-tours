<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ForceHttps
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
        if (!$request->secure() && env('FORCE_HTTPS', false)) {
            return redirect()->secure($request->getRequestUri());
        }
        
        $response = $next($request);
        
        // Set secure cookie flags
        if ($request->secure()) {
            config(['session.secure' => true]);
            config(['cookie.secure' => true]);
            
            // Add HSTS headers
            $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains; preload');
        }
        
        return $response;
    }
}
