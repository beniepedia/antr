<?php

namespace App\Http\Middleware;

use App\Models\Tenant;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TenantDomain
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $host = $request->getHost(); // contoh: test.antrian.test
        $parts = explode('.', $host);
        $subdomain = $parts[0] ?? null;

        // Cari tenant di DB
        $tenant = Tenant::where('url', strtolower($subdomain ?? ''))->first();

        if (! $tenant) {
            abort(404, 'Tenant tidak ditemukan'); // <- ini penting
        }

        app()->instance('tenant', $tenant);

        return $next($request);

    }
}
