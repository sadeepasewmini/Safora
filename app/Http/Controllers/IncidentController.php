<?php

namespace App\Http\Controllers;

use App\Models\Incident;
use App\Models\IncidentCategory;
use App\Models\IncidentImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class IncidentController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:incident_categories,id',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'area_name' => 'required|string|max:255',
            'severity' => 'required|in:low,medium,high,critical',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5048',
        ]);

        $incident = Incident::create([
            'user_id' => Auth::id(),
            'category_id' => $validated['category_id'],
            'title' => $validated['title'],
            'description' => $validated['description'],
            'latitude' => $validated['latitude'],
            'longitude' => $validated['longitude'],
            'address' => $request->input('address', $validated['area_name']),
            'area_name' => $validated['area_name'],
            'severity' => $validated['severity'],
            'status' => 'pending', // Requires moderator verification
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('incidents', 'public');
            IncidentImage::create([
                'incident_id' => $incident->id,
                'file_path' => $path,
                'file_type' => 'image',
            ]);
        }

        return redirect()->route('home')->with('success', 'Incident report submitted successfully! It is pending moderator verification.');
    }

    public function show($id)
    {
        $incident = Incident::with(['category', 'user', 'images', 'verifier', 'resolver'])->findOrFail($id);
        $incident->increment('views_count');

        return response()->json([
            'status' => 'success',
            'data' => [
                'id' => $incident->id,
                'title' => $incident->title,
                'description' => $incident->description,
                'category_name' => $incident->category->name,
                'category_type' => $incident->category->type,
                'category_icon' => $incident->category->icon,
                'latitude' => (float)$incident->latitude,
                'longitude' => (float)$incident->longitude,
                'address' => $incident->address,
                'area_name' => $incident->area_name,
                'severity' => $incident->severity,
                'status' => $incident->status,
                'reported_by' => $incident->user ? $incident->user->name : 'Anonymous Reporter',
                'created_at' => $incident->created_at->diffForHumans(),
                'images' => $incident->images->pluck('file_path')->map(fn($path) => asset('storage/' . $path)),
            ]
        ]);
    }

    // AI Feature Option 2: Smart Incident Classification API
    public function classifyAi(Request $request)
    {
        $text = strtolower($request->input('text', ''));

        $categories = IncidentCategory::all();
        $matchedCategory = null;
        $confidence = 80;

        // Keywords detection
        if (Str::contains($text, ['elephant', 'ali', 'aliyan', 'trunk'])) {
            $matchedCategory = $categories->where('name', 'Elephant Crossing')->first();
            $confidence = 96;
        } elseif (Str::contains($text, ['leopard', 'diviya', 'cheetah', 'spot'])) {
            $matchedCategory = $categories->where('name', 'Leopard Sighting')->first();
            $confidence = 94;
        } elseif (Str::contains($text, ['crocodile', 'kimbula', 'river', 'alligator'])) {
            $matchedCategory = $categories->where('name', 'Crocodile Sighting')->first();
            $confidence = 95;
        } elseif (Str::contains($text, ['stolen', 'steal', 'snatch', 'purse', 'bag', 'phone', 'thief', 'horaa'])) {
            $matchedCategory = $categories->where('name', 'Theft / Snatching')->first();
            $confidence = 92;
        } elseif (Str::contains($text, ['flood', 'water', 'wathura', 'rain', 'inundated'])) {
            $matchedCategory = $categories->where('name', 'Flood Warning')->first();
            $confidence = 91;
        } elseif (Str::contains($text, ['accident', 'car', 'bike', 'crash', 'collision'])) {
            $matchedCategory = $categories->where('name', 'Road Accident')->first();
            $confidence = 93;
        }

        if (!$matchedCategory) {
            $matchedCategory = $categories->where('name', 'Suspicious Activity')->first();
            $confidence = 70;
        }

        return response()->json([
            'status' => 'success',
            'category_id' => $matchedCategory ? $matchedCategory->id : null,
            'category_name' => $matchedCategory ? $matchedCategory->name : 'General Hazard',
            'confidence' => $confidence,
            'suggested_severity' => $matchedCategory ? $matchedCategory->risk_level : 'medium',
        ]);
    }

    // Community Verification (Upvote / Confirm report)
    public function vote(Request $request, $id)
    {
        $incident = Incident::findOrFail($id);
        $type = $request->input('type', 'upvote');

        if ($type === 'upvote') {
            $incident->increment('upvotes_count');
        } else {
            $incident->increment('downvotes_count');
        }

        return response()->json([
            'status' => 'success',
            'upvotes' => $incident->upvotes_count,
            'downvotes' => $incident->downvotes_count,
            'credibility_score' => $incident->credibility_score,
            'credibility_label' => $incident->credibility_label,
            'message' => 'Thank you! Your community verification vote has been recorded.',
        ]);
    }

    // AI Feature: Time-Series Risk Prediction Engine
    public function predictRisk(Request $request)
    {
        $area = $request->input('area_name', 'Colombo');
        $hour = (int)$request->input('hour', date('H'));

        // Query database for incidents matching area
        $totalIncidents = Incident::where('area_name', 'LIKE', "%{$area}%")->count();
        $recentHighRisk = Incident::where('area_name', 'LIKE', "%{$area}%")
            ->whereIn('severity', ['high', 'critical'])
            ->count();

        // Calculate dynamic base risk score (min 15%, max 95%)
        $areaBaseScore = ($totalIncidents * 14) + ($recentHighRisk * 22);
        
        // Calculate risk percentage for the selected hour
        $isNightHour = ($hour >= 20 || $hour <= 5);
        $timeMultiplier = $isNightHour ? 1.4 : 0.85;
        
        $baseRisk = (int)min(98, max(18, round(($areaBaseScore + 30) * $timeMultiplier)));
        if ($totalIncidents === 0) {
            $baseRisk = $isNightHour ? 42 : 20;
        }

        // Determine Risk Level Label
        if ($baseRisk >= 75) {
            $riskLevel = 'Critical';
            $riskReason = "Critical hazard risk predicted in {$area} due to night hours & historical severe incident reports ({$totalIncidents} active/reported hazards).";
            $recommendations = [
                "Avoid unlit street corridors & isolated areas after 8 PM in {$area}",
                "Keep 1-Click SOS quick-dial background trigger enabled",
                "Share your live GPS location with trusted contacts or emergency dispatchers"
            ];
        } elseif ($baseRisk >= 50) {
            $riskLevel = 'High';
            $riskReason = "High hazard probability detected in {$area} based on recent community reports ({$totalIncidents} active hazards).";
            $recommendations = [
                "Exercise caution when traveling alone after dusk",
                "Stick to well-lit main arterial roads and verified safe havens",
                "Keep emergency hotlines (119 Police / 1990 Suwa Seriya) ready"
            ];
        } else {
            $riskLevel = 'Moderate';
            $riskReason = "Moderate risk levels in {$area}. Active community safety patrols reporting normal conditions ({$totalIncidents} reported hazards).";
            $recommendations = [
                "Maintain standard situational awareness while commuting",
                "Report any unlit streets or suspicious activity to community map",
                "Check verified safe places locator for nearest emergency stations"
            ];
        }

        // Dynamic 24-Hour Time Series Risk Curve Calculation
        $timePoints = [0 => '00:00', 4 => '04:00', 8 => '08:00', 12 => '12:00', 16 => '16:00', 20 => '20:00', 23 => '23:59'];
        $riskTrends = [];

        foreach ($timePoints as $h => $label) {
            $hIsNight = ($h >= 20 || $h <= 5);
            $hMult = $hIsNight ? 1.35 : ($h == 8 || $h == 16 ? 0.9 : 0.75);
            $hScore = (int)min(98, max(15, round(($areaBaseScore + 25) * $hMult)));
            if ($totalIncidents === 0) {
                $hScore = $hIsNight ? (35 + ($h % 5)) : (18 + ($h % 4));
            }
            $riskTrends[] = $hScore;
        }

        // Dynamic Specific Risk Breakdown Calculation
        $harassmentRisk = (int)min(96, max(20, round($baseRisk * ($isNightHour ? 1.05 : 0.85))));
        $theftRisk = (int)min(92, max(15, round($baseRisk * ($isNightHour ? 0.95 : 0.9))));
        $unlitRisk = (int)min(98, max(25, round($baseRisk * ($isNightHour ? 1.25 : 0.6))));
        $wildlifeRisk = Str::contains(strtolower($area), ['habarana', 'trinco', 'hatton', 'polonnaruwa']) 
            ? (int)min(95, max(45, round($baseRisk * 1.1))) 
            : (int)max(5, round($baseRisk * 0.2));

        return response()->json([
            'status' => 'success',
            'area_name' => $area,
            'predicted_hour' => sprintf("%02d:00", $hour),
            'risk_percentage' => $baseRisk,
            'risk_level' => $riskLevel,
            'reason' => $riskReason,
            'recommendations' => $recommendations,
            'risk_breakdown' => [
                'harassment' => $harassmentRisk,
                'theft' => $theftRisk,
                'unlit_corridor' => $unlitRisk,
                'wildlife' => $wildlifeRisk,
            ],
            'chart_data' => [
                'labels' => array_values($timePoints),
                'risk_trends' => $riskTrends,
            ]
        ]);
    }

    // AI Safe Navigation Route & Risk Assessment API
    public function calculateSafeRoute(Request $request)
    {
        $startLat = (float)$request->input('start_lat', 7.3095438);
        $startLng = (float)$request->input('start_lng', 80.5694720);
        $destLat = (float)$request->input('dest_lat', 7.2906);
        $destLng = (float)$request->input('dest_lng', 80.6337);

        $minLat = min($startLat, $destLat) - 0.1;
        $maxLat = max($startLat, $destLat) + 0.1;
        $minLng = min($startLng, $destLng) - 0.1;
        $maxLng = max($startLng, $destLng) + 0.1;

        // Fetch active verified incidents near the travel corridor
        $nearbyIncidents = Incident::with('category')
            ->where('status', 'verified')
            ->whereBetween('latitude', [$minLat, $maxLat])
            ->whereBetween('longitude', [$minLng, $maxLng])
            ->get();

        $interceptedHazards = [];
        $safetyScore = 100;

        foreach ($nearbyIncidents as $inc) {
            $deduction = $inc->severity === 'critical' ? 25 : ($inc->severity === 'high' ? 15 : 5);
            $safetyScore = max(10, $safetyScore - $deduction);

            $interceptedHazards[] = [
                'id' => $inc->id,
                'title' => $inc->title,
                'category' => $inc->category ? $inc->category->name : 'Hazard',
                'severity' => strtoupper($inc->severity),
                'area_name' => $inc->area_name,
                'latitude' => (float)$inc->latitude,
                'longitude' => (float)$inc->longitude,
            ];
        }

        $rating = $safetyScore >= 80 ? 'Highly Safe Route' : ($safetyScore >= 50 ? 'Caution Advised' : 'High Hazard Travel Zone');
        $color = $safetyScore >= 80 ? '#059669' : ($safetyScore >= 50 ? '#d97706' : '#dc2626');

        return response()->json([
            'status' => 'success',
            'safety_score' => $safetyScore,
            'safety_rating' => $rating,
            'route_color' => $color,
            'hazards_count' => count($interceptedHazards),
            'intercepted_hazards' => $interceptedHazards,
            'advisories' => [
                'Maintain speed limit and stay alert near active hazard markers.',
                'Keep 1-Click SOS emergency quick-dial active.',
                'Avoid unlit street detours after sunset.'
            ]
        ]);
    }
}
