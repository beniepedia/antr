<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class EmailVerificationController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            new Middleware('auth:tenant'),
            new Middleware('signed'),
            new Middleware('throttle:6,1'),
        ];
    }

    public function __invoke(Request $request)
    {
        if ($request->user('tenant')->hasVerifiedEmail()) {
            return redirect()->intended(route('tenant.dashboard'));
        }

        if ($request->user('tenant')->markEmailAsVerified()) {
            event(new \Illuminate\Auth\Events\Verified($request->user('tenant')));
        }

        return redirect()->intended(route('tenant.dashboard'));
    }
}
