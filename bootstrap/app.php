<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
            'verified' => \App\Http\Middleware\EnsureEmailIsVerified::class,
        ]);

        // Trust proxies for Render load balancer
        $middleware->append(\App\Http\Middleware\TrustProxies::class);

        // Force HTTPS in production
        if (app()->environment('production')) {
            $middleware->redirectToHttps();
        }

        // Force HTTPS scheme and secure cookies in production
        if (app()->environment('production')) {
            $middleware->prepend(function ($request, $next) {
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
            });
        }
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
