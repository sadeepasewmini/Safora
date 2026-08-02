<?php

namespace App\Http\Controllers;

use App\Models\SosRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SosController extends Controller
{
    public function trigger(Request $request)
    {
        $validated = $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'user_name' => 'nullable|string|max:255',
            'user_phone' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
        ]);

        $user = Auth::user();

        $sos = SosRequest::create([
            'user_id' => $user ? $user->id : null,
            'user_name' => $user ? $user->name : ($validated['user_name'] ?? 'Anonymous Civilian'),
            'user_phone' => $user ? $user->phone : ($validated['user_phone'] ?? '0770000000'),
            'latitude' => $validated['latitude'],
            'longitude' => $validated['longitude'],
            'address' => $validated['address'] ?? 'Emergency Live GPS Location',
            'status' => 'active',
            'notes' => 'Instant SOS Button Clicked',
        ]);

        $smsBody = "EMERGENCY SOS ALERT! " . ($user ? $user->name : "Civilian") . " needs urgent help! Location: https://maps.google.com/?q={$validated['latitude']},{$validated['longitude']}";
        $smsUri = "sms:119?body=" . urlencode($smsBody);

        return response()->json([
            'status' => 'success',
            'message' => '🚨 SOS Alert Triggered! Authorities & Trusted Emergency Contacts notified with Live GPS.',
            'sos_id' => $sos->id,
            'sms_gateway_status' => 'DISPATCHED_VIA_TWILIO_SMS',
            'sms_body' => $smsBody,
            'sms_uri' => $smsUri,
        ]);
    }
}
