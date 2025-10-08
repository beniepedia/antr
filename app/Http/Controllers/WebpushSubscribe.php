<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WebpushSubscribe extends Controller
{
    public function subscribe(Request $request)
    {
        $request->validate([
            'endpoint' => 'required|url',
            'keys.p256dh' => 'required|string',
            'keys.auth' => 'required|string',
        ]);

        $user = Auth::guard('tenant')->user();

        $user->pushSubscriptions()->updateOrCreate(
            ['endpoint' => $request->endpoint],
            [
                'public_key' => $request->input('keys.p256dh'),
                'auth_token' => $request->input('keys.auth'),
                'content_encoding' => $request->input('contentEncoding', 'aesgcm'),
                'tenant_id' => session('tenant_id'),
                'last_used_at' => now(),
            ]
        );

        // Store subscription in database (you might want to create a table for this)
        // For now, we'll just return success
        // In a real app, save to user model or separate table

        return response()->json(['status' => 'subscribed']);
    }

    public function unsubscribe(Request $request)
    {
        $request->validate(['endpoint' => 'required|url']);
        $user = Auth::guard('tenant')->user();

        $user->pushSubscriptions()->where('endpoint', $request->endpoint)->delete();

        return response()->json(['status' => 'unsubscribed']);
    }
}
