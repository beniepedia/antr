<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
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

        // belum isi tenant
        if (is_null($user->tenant_id)) {
            return redirect()->route('tenant.onboarding');
        }

        // cek langganan aktif
        $subscription = $user->tenant->subscriptions();

        if ($subscription->get()->isEmpty()) {
            return redirect()->route('tenant.subscription');
        }

        return $next($request);
    }
}
