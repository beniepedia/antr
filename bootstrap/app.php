<?php

use App\Http\Middleware\EnsureTenantIsActive;
use App\Http\Middleware\TenantDomain;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'tenant.active' => EnsureTenantIsActive::class,
            'tenant.domain' => TenantDomain::class,
        ]);

        $middleware->web(append: [
            TenantDomain::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
