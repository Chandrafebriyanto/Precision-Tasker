<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PushController extends Controller
{
    public function store(Request $request)
    {
        // Validasi data token dari browser
        $request->validate([
            'endpoint'    => 'required',
            'keys.auth'   => 'required',
            'keys.p256dh' => 'required'
        ]);

        // Simpan token ke tabel push_subscriptions untuk user yang sedang login
        $request->user()->updatePushSubscription(
            $request->endpoint,
            $request->keys['p256dh'],
            $request->keys['auth']
        );

        return response()->json(['success' => true]);
    }
}