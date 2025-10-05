<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class EnsureTenantIsActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth('tenant')->user();

        // Belum punya tenant → redirect onboarding
        if (is_null($user->tenant_id)) {
            return redirect()->route('tenant.onboarding');
        }

        $tenant = $user->tenant;
        $cacheKey = "tenant:{$tenant->id}:active";

        // Cache status aktif selama 1 jam (3600 detik)
        $isActive = Cache::remember($cacheKey, 3600, function () use ($tenant) {
            return $tenant->hasActiveSubscription();
        });

        // Jika tidak aktif, arahkan ke halaman upgrade
        if (!$isActive) {
            return redirect()->route('tenant.upgrade');
        }

        return $next($request);
    }
}
