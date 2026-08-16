<?php

namespace App\Http\Controllers;

use App\Models\Incident;
use App\Models\IncidentCategory;
use App\Models\SafePlace;
use App\Models\Alert;
use App\Models\SosRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $typeFilter = $request->query('type');
        $areaFilter = $request->query('area');

        // Fetch verified incidents for map & public list
        $incidentsQuery = Incident::with(['category', 'user', 'images'])
            ->where('status', 'verified');

        if ($typeFilter) {
            $incidentsQuery->whereHas('category', function ($q) use ($typeFilter) {
                $q->where('type', $typeFilter);
            });
        }

        if ($areaFilter) {
            $incidentsQuery->where('area_name', 'like', "%{$areaFilter}%");
        }

        $incidents = $incidentsQuery->latest()->get();

        // Fetch Categories
        $categories = IncidentCategory::all();

        // Fetch Safe Places
        $safePlaces = SafePlace::all();

        // Fetch Active Alerts
        $activeAlerts = Alert::where('is_active', true)->latest()->take(5)->get();

        // Count Statistics
        $stats = [
            'total_incidents' => Incident::where('status', 'verified')->count(),
            'wildlife_count' => Incident::whereHas('category', fn($q) => $q->where('type', 'wildlife'))->count(),
            'crime_count' => Incident::whereHas('category', fn($q) => $q->where('type', 'crime'))->count(),
            'disaster_count' => Incident::whereHas('category', fn($q) => $q->where('type', 'disaster'))->count(),
            'resolved_count' => Incident::where('status', 'resolved')->count(),
            'safe_places_count' => $safePlaces->count(),
        ];

        // Area Safety Scores Demo Calculation
        $areaScores = $this->calculateAreaSafetyScores();

        return view('home', compact(
            'incidents',
            'categories',
            'safePlaces',
            'activeAlerts',
            'stats',
            'areaScores',
            'typeFilter'
        ));
    }

    public function apiLiveMapData()
    {
        $incidents = Incident::with(['category'])->where('status', 'verified')->latest()->get();
        $safePlaces = SafePlace::all();

        return response()->json([
            'status' => 'success',
            'incidents' => $incidents,
            'safePlaces' => $safePlaces,
            'timestamp' => now()->toIso8601String()
        ]);
    }

    private function calculateAreaSafetyScores()
    {
        $areas = ['Colombo', 'Habarana', 'Bentota', 'Kandy', 'Galle', 'Hatton'];
        $scores = [];

        foreach ($areas as $area) {
            $incidentsCount = Incident::where('area_name', 'like', "%{$area}%")->count();
            $highRiskCount = Incident::where('area_name', 'like', "%{$area}%")
                ->whereIn('severity', ['high', 'critical'])->count();

            // Formula: 100 base - (total incidents * 5) - (high risk * 10)
            $score = max(35, 100 - ($incidentsCount * 5) - ($highRiskCount * 10));
            
            $riskLevel = 'Low Risk';
            $badgeColor = 'success';
            if ($score < 60) {
                $riskLevel = 'High Risk';
                $badgeColor = 'danger';
            } elseif ($score < 80) {
                $riskLevel = 'Moderate Risk';
                $badgeColor = 'warning';
            }

            $scores[] = [
                'area' => $area,
                'score' => $score,
                'risk_level' => $riskLevel,
                'badge_color' => $badgeColor,
                'incidents' => $incidentsCount
            ];
        }

        return $scores;
    }

    public function aiChat(Request $request)
    {
        $message = $request->input('message', '');
        if (empty($message)) {
            return response()->json(['status' => 'error', 'reply' => 'Please ask a valid safety question.'], 400);
        }

        $apiKey = config('services.gemini.key') ?: env('GEMINI_API_KEY');

        if (!empty($apiKey)) {
            try {
                $response = Http::withHeaders([
                    'Content-Type' => 'application/json',
                ])->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key={$apiKey}", [
                    'contents' => [
                        [
                            'role' => 'user',
                            'parts' => [
                                [
                                    'text' => "You are Safora AI Safety Companion, an emergency safety AI assistant for Sri Lanka. Emergency hotlines: Police 119, Ambulance Suwa Seriya 1990, Wildlife Elephant 1985, Women & Child Protection 1938. User question: {$message}. Give a clear, helpful, supportive response."
                                ]
                            ]
                        ]
                    ]
                ]);

                if ($response->successful()) {
                    $json = $response->json();
                    $rawText = $json['candidates'][0]['content']['parts'][0]['text'] ?? null;
                    if (!empty($rawText)) {
                        // Parse Gemini markdown to clean HTML for visual brilliance
                        $formattedText = preg_replace('/\*\*(.*?)\*\*/s', '<strong>$1</strong>', $rawText);
                        $formattedText = preg_replace('/^\*\s+(.*)$/m', '• $1', $formattedText);
                        $formattedText = nl2br($formattedText);

                        return response()->json([
                            'status' => 'success',
                            'source' => 'gemini_api',
                            'reply' => $formattedText
                        ]);
                    }
                }
            } catch (\Exception $e) {
                // Fallback to local rule engine if API fails or network timeout
            }
        }

        // Local Emergency Knowledge Base fallback
        $reply = $this->generateLocalAiResponse($message);
        return response()->json([
            'status' => 'success',
            'source' => 'local_knowledge',
            'reply' => $reply
        ]);
    }

    private function generateLocalAiResponse($inputStr)
    {
        $q = strtolower(trim($inputStr));

        // Greetings & Introductions
        if (str_contains($q, 'hi') || str_contains($q, 'hello') || str_contains($q, 'ayubowan') || str_contains($q, 'hey') || str_contains($q, 'good morning') || str_contains($q, 'good evening') || str_contains($q, 'kohomada') || str_contains($q, 'subha') || str_contains($q, 'sthuthi') || str_contains($q, 'wada karanne')) {
            return "👋 <strong>Ayubowan! Welcome to Safora AI Assistant. / ආයුබෝවන්!</strong><br>I am your 24/7 Sri Lanka Travel & Safety Companion. How can I help you today? You can ask me about:<br>• Emergency Hotlines (Police 119, Ambulance 1990, Wildlife 1985, Women Protection 1938)<br>• Safe Places & Tourist Destinations (Colombo, Kandy, Galle, Sigiriya, Ella)<br>• First Aid & Travel Precautions<br>• Weather, Road & Wildlife Safety";
        }

        // Who are you / Platform Info
        if (str_contains($q, 'who are you') || str_contains($q, 'what is safora') || str_contains($q, 'what can you do')) {
            return "🤖 <strong>I am the Safora AI Safety Companion!</strong><br>I provide real-time guidance on Sri Lanka travel safety, emergency hotlines, verified safe places, live hazard alerts, and navigation safety.";
        }

        // Emergency Hotlines
        if (str_contains($q, 'police') || str_contains($q, '119') || str_contains($q, 'crime') || str_contains($q, 'thief')) {
            return "🚨 <strong>Police Emergency Hotline: 119</strong><br>For immediate police dispatch or reporting criminal activity, dial <strong>119</strong> directly. Tap the red <strong>SOS Button</strong> at the bottom-right for live GPS coordinates!";
        }

        if (str_contains($q, 'ambulance') || str_contains($q, 'hospital') || str_contains($q, '1990') || str_contains($q, 'suwa seriya') || str_contains($q, 'doctor') || str_contains($q, 'medical')) {
            return "🚑 <strong>Suwa Seriya Ambulance Hotline: 1990</strong><br>For free 24/7 emergency medical assistance and ambulance dispatch anywhere in Sri Lanka, call <strong>1990</strong> immediately.";
        }

        if (str_contains($q, 'elephant') || str_contains($q, 'wildlife') || str_contains($q, '1985') || str_contains($q, 'animal')) {
            return "🐘 <strong>Wildlife & Elephant Hotline: 1985</strong><br>If you encounter wild elephants on highways (e.g. Habarana, Dambulla, Udawalawe):<br>1. Do NOT flash high beams or honk.<br>2. Keep vehicle windows closed.<br>3. Call Wildlife Hotline <strong>1985</strong> immediately.";
        }

        if (str_contains($q, 'women') || str_contains($q, 'child') || str_contains($q, 'harassment') || str_contains($q, '1938') || str_contains($q, 'girl')) {
            return "🚺 <strong>Women & Child Protection Hotline: 1938</strong><br>If you experience street harassment or domestic distress, dial <strong>1938</strong>. You can also submit an incident report on Safora Map with precise location pin.";
        }

        // Safe Places & Emergency Havens (Dynamic Location-Aware Filtering)
        if (str_contains($q, 'safe place') || str_contains($q, 'safe places') || str_contains($q, 'safe haven') || str_contains($q, 'shelter') || str_contains($q, 'rest spot') || str_contains($q, 'safe location')) {
            $locationMatch = null;
            if (str_contains($q, 'kandy')) $locationMatch = 'Kandy';
            elseif (str_contains($q, 'colombo')) $locationMatch = 'Colombo';
            elseif (str_contains($q, 'galle')) $locationMatch = 'Galle';
            elseif (str_contains($q, 'habarana')) $locationMatch = 'Habarana';
            elseif (str_contains($q, 'bentota')) $locationMatch = 'Bentota';
            elseif (str_contains($q, 'hatton')) $locationMatch = 'Hatton';

            if ($locationMatch) {
                $dbSafePlaces = SafePlace::where('area_name', 'like', "%{$locationMatch}%")
                    ->orWhere('address', 'like', "%{$locationMatch}%")
                    ->get();

                if ($dbSafePlaces->count() > 0) {
                    $reply = "📍 <strong>Verified Safe Places in {$locationMatch}:</strong><br><ul class='ps-3 mb-2'>";
                    foreach ($dbSafePlaces as $sp) {
                        $icon = $sp->type === 'police' ? '🚔' : ($sp->type === 'hospital' ? '🏥' : ($sp->type === 'fire_station' ? '🚒' : '🛡️'));
                        $reply .= "<li class='mb-1'>{$icon} <strong>{$sp->name}</strong><br><small class='text-slate-300'>Address: {$sp->address} | 📞 Hotline: <strong>{$sp->phone}</strong></small></li>";
                    }
                    $reply .= "</ul>👉 View live 24/7 map navigation under <strong>Safe Places</strong>!";
                    return $reply;
                }
            }

            return "📍 <strong>Verified Safe Places & Emergency Havens:</strong><br>" .
                   "• <strong>Kandy:</strong> Kandy General Hospital (📞 081-2222261) & Kandy Police Response Hub<br>" .
                   "• <strong>Colombo:</strong> Fort Police Station (📞 011-2433333) & National Hospital (📞 011-2691111)<br>" .
                   "• <strong>Galle:</strong> Galle Fire Station (📞 091-2234000) & Galle Fort Police Hub<br>" .
                   "• <strong>Habarana:</strong> Habarana Police Station (📞 066-2270222)<br>" .
                   "<br>👉 Check the <strong>Safe Places</strong> section on the home map for live 24/7 navigation!";
        }

        // Tourist Destinations & Travel Advice
        if (str_contains($q, 'tourist destination') || str_contains($q, 'places to visit') || str_contains($q, 'travel advice') || str_contains($q, 'sigiriya') || str_contains($q, 'ella') || str_contains($q, 'mirissa')) {
            return "🏝️ <strong>Sri Lanka Safe Travel & Destination Guide:</strong><br>• <strong>Colombo:</strong> Modern capital with verified safe havens around Fort & Cinnamon Gardens.<br>• <strong>Kandy:</strong> Cultural center with safe rest spots near Kandy Lake.<br>• <strong>Galle & Mirissa:</strong> Coastal paradises with active marine safety patrols.<br>• <strong>Sigiriya & Ella:</strong> Scenic hiking destinations. Stay on marked trails and check wild elephant alerts!";
        }

        // First Aid & Health Tips
        if (str_contains($q, 'first aid') || str_contains($q, 'snake') || str_contains($q, 'burn') || str_contains($q, 'injury') || str_contains($q, 'fever')) {
            return "🩺 <strong>Emergency First Aid Guidance:</strong><br>1. <strong>Snake Bite:</strong> Immobilize the limb, keep patient calm, do NOT tie tightly. Call 1990.<br>2. <strong>Heat Exhaustion / Fever:</strong> Move to shade, rehydrate with ORS electrolyte water.<br>3. <strong>Minor Injuries:</strong> Clean with safe water and apply sterile bandage.";
        }

        // Weather & Disaster Safety
        if (str_contains($q, 'weather') || str_contains($q, 'rain') || str_contains($q, 'flood') || str_contains($q, 'landslide') || str_contains($q, 'monsoon')) {
            return "🌧️ <strong>Disaster & Weather Safety (DMC Hotline: 117):</strong><br>During heavy monsoon rains or flood warnings, avoid low-lying river corridors and steep hillside roads prone to landslides. For official disaster alerts, call Disaster Management Centre at <strong>117</strong>.";
        }

        // Transport & Tuktuks
        if (str_contains($q, 'tuk') || str_contains($q, 'tuktuk') || str_contains($q, 'tuk-tuk') || str_contains($q, 'taxi') || str_contains($q, 'bus') || str_contains($q, 'train') || str_contains($q, 'transport') || str_contains($q, 'three wheeler') || str_contains($q, 'ride')) {
            return "🛺 <strong>Sri Lanka Transport Safety Tips:</strong><br>• Use metered Tuk-Tuks or ride-hailing apps (PickMe / Uber) for transparent fares.<br>• Always verify driver details & agree on meter activation before starting your ride.<br>• For Expressways & Highway breakdowns, dial Expressway Emergency <strong>1969</strong>.";
        }

        // Food, Dining & Water Safety
        if (str_contains($q, 'food') || str_contains($q, 'tea') || str_contains($q, 'eat') || str_contains($q, 'restaurant') || str_contains($q, 'rice') || str_contains($q, 'curry') || str_contains($q, 'water')) {
            return "🍲 <strong>Sri Lanka Dining & Refreshment Tips:</strong><br>• Try authentic Ceylon Rice & Curry, Kottu Roti, and Fresh King Coconut (Thambili).<br>• Stick to bottled or boiled filtered water for safe drinking.<br>• World-famous Ceylon Tea is best sampled in Nuwara Eliya and Ella!";
        }

        // Currency, Money & Payments
        if (str_contains($q, 'money') || str_contains($q, 'currency') || str_contains($q, 'atm') || str_contains($q, 'card') || str_contains($q, 'rupee') || str_contains($q, 'cash') || str_contains($q, 'pay')) {
            return "💵 <strong>Currency & Payments Info:</strong><br>• Currency: Sri Lankan Rupee (LKR).<br>• ATMs are widely available across major cities (Commercial Bank, Sampath Bank, Bank of Ceylon).<br>• Major credit cards (Visa/Mastercard) are accepted in hotels and supermarkets, but keep LKR cash for local Tuk-Tuks and street stalls.";
        }

        // Distances & Expressway Travel
        if (str_contains($q, 'distance') || str_contains($q, 'far') || str_contains($q, 'highway') || str_contains($q, 'drive') || str_contains($q, 'map') || str_contains($q, 'route')) {
            return "🗺️ <strong>Sri Lanka Travel Distances & Routes:</strong><br>• <strong>Colombo ➔ Kandy:</strong> ~115 km (approx. 3 hours drive)<br>• <strong>Colombo ➔ Galle:</strong> ~120 km (approx. 1.5 - 2 hours via Southern Expressway)<br>• <strong>Colombo ➔ Ella:</strong> ~200 km (approx. 5-6 hours drive or scenic train ride)<br>👉 Use the <strong>Safe Route Finder</strong> on our map for live hazard analysis!";
        }

        // Best Time to Visit & Weather Season
        if (str_contains($q, 'season') || str_contains($q, 'best time') || str_contains($q, 'when to visit') || str_contains($q, 'month') || str_contains($q, 'climate')) {
            return "☀️ <strong>Best Time to Visit Sri Lanka:</strong><br>• <strong>West & South Coast (Colombo, Galle, Mirissa):</strong> December to April (Dry season & sunny beaches).<br>• <strong>East Coast (Trincomalee, Arugam Bay):</strong> May to September (Ideal for surfing & diving).<br>• <strong>Hill Country (Kandy, Nuwara Eliya, Ella):</strong> January to April.";
        }

        // Language & Local Greetings
        if (str_contains($q, 'language') || str_contains($q, 'speak') || str_contains($q, 'sinhala') || str_contains($q, 'tamil') || str_contains($q, 'words')) {
            return "🗣️ <strong>Local Language Guide:</strong><br>• Official Languages: Sinhala & Tamil. English is widely understood in tourist areas.<br>• <em>Ayubowan:</em> May you live long! (Traditional greeting)<br>• <em>Bohoma Isthuthi:</em> Thank you very much!<br>• <em>Kohomada?:</em> How are you?";
        }

        // How to Report / Hazards
        if (str_contains($q, 'report') || str_contains($q, 'hazard') || str_contains($q, 'how to')) {
            return "📝 <strong>How to Report a Hazard on Safora:</strong><br>1. Scroll to the <strong>Report Hazard Form</strong>.<br>2. Select category (Streetlight, Crime, Wildlife, Disaster).<br>3. Click <strong>'Use My GPS Location'</strong>.<br>4. Submit report for Moderator verification!";
        }

        // General Conversational Response for Any Open Question
        return "💡 <strong>Safora AI Safety Answer:</strong><br>Regarding <em>\"" . htmlspecialchars($inputStr) . "\"</em>:<br>Safora is equipped to assist you with emergency response (119 / 1990 / 1985 / 1938), safe navigation, and travel tips across Sri Lanka. <br><br>• For <strong>Emergency Help</strong>: Press the red <strong>SOS Button</strong>.<br>• For <strong>Safe Places</strong>: Search your city name (e.g. <em>\"Safe places in Kandy\"</em>).<br><br><small class='text-slate-400'>✨ <strong>Note:</strong> To enable unlimited open-domain Generative AI answers, insert your Google Gemini API key into <code>.env</code> as <code>GEMINI_API_KEY=your_key</code>.</small>";
    }
}
