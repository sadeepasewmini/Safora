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

        // Fetch Public Feedbacks from MySQL Database
        $publicFeedbacks = \App\Models\PublicFeedback::latest()->get();

        return view('home', compact(
            'incidents',
            'categories',
            'safePlaces',
            'activeAlerts',
            'stats',
            'areaScores',
            'typeFilter',
            'publicFeedbacks'
        ));
    }

    public function storePublicFeedback(Request $request)
    {
        $validated = $request->validate([
            'author_name' => 'required|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'category' => 'required|string|max:255',
            'comment' => 'required|string|max:1000',
        ]);

        $feedback = \App\Models\PublicFeedback::create([
            'author_name' => $validated['author_name'],
            'rating' => $validated['rating'],
            'category' => $validated['category'],
            'comment' => $validated['comment'],
            'user_id' => auth()->check() ? auth()->id() : null,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Feedback saved successfully in database!',
            'feedback' => $feedback
        ]);
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

        // Greetings & Introductions (using word boundary so 'hi' doesn't match inside 'highway')
        if (preg_match('/\b(hi|hello|hey|ayubowan|good morning|good evening|kohomada|subha|sthuthi)\b/i', $q)) {
            return "👋 <strong>Ayubowan! Welcome to Safora AI Assistant. / ආයුබෝවන්!</strong><br>I am your 24/7 Sri Lanka Travel & Safety Companion. How can I help you today? You can ask me about:<br>• Emergency Hotlines (Police 119, Ambulance 1990, Wildlife 1985, Women Protection 1938)<br>• Safe Places & Tourist Destinations (Colombo, Kandy, Galle, Sigiriya, Ella)<br>• First Aid & Travel Precautions<br>• Weather, Road & Wildlife Safety";
        }

        // Who are you / Platform Info
        if (str_contains($q, 'who are you') || str_contains($q, 'what is safora') || str_contains($q, 'what can you do')) {
            return "🤖 <strong>I am the Safora AI Safety Companion!</strong><br>I provide real-time guidance on Sri Lanka travel safety, emergency hotlines, verified safe places, live hazard alerts, and navigation safety.";
        }

        // Location-Aware Hospital & Safe Place Lookup (High Priority)
        $locationMatch = null;
        if (str_contains($q, 'kandy')) $locationMatch = 'Kandy';
        elseif (str_contains($q, 'colombo')) $locationMatch = 'Colombo';
        elseif (str_contains($q, 'galle')) $locationMatch = 'Galle';
        elseif (str_contains($q, 'habarana')) $locationMatch = 'Habarana';
        elseif (str_contains($q, 'bentota')) $locationMatch = 'Bentota';
        elseif (str_contains($q, 'hatton')) $locationMatch = 'Hatton';
        elseif (str_contains($q, 'jaffna')) $locationMatch = 'Jaffna';
        elseif (str_contains($q, 'peradeniya')) $locationMatch = 'Peradeniya';

        if ($locationMatch && (str_contains($q, 'hospital') || str_contains($q, 'police') || str_contains($q, 'safe') || str_contains($q, 'place') || str_contains($q, 'nearest') || str_contains($q, 'shelter') || str_contains($q, 'doctor') || str_contains($q, 'medical'))) {
            $dbSafePlaces = SafePlace::where('area_name', 'like', "%{$locationMatch}%")
                ->orWhere('address', 'like', "%{$locationMatch}%")
                ->get();

            if ($dbSafePlaces->count() > 0) {
                $reply = "📍 <strong>Verified Hospitals & Safe Havens in {$locationMatch}:</strong><br><ul class='ps-3 mb-2'>";
                foreach ($dbSafePlaces as $sp) {
                    $icon = $sp->type === 'police' ? '🚔' : ($sp->type === 'hospital' ? '🏥' : ($sp->type === 'fire_station' ? '🚒' : '🛡️'));
                    $reply .= "<li class='mb-1'>{$icon} <strong>{$sp->name}</strong><br><small class='text-slate-300'>Address: {$sp->address} | 📞 Hotline: <strong>{$sp->phone}</strong></small></li>";
                }
                $reply .= "</ul>🚑 Emergency Ambulance: <strong>1990</strong> | 🚨 Police: <strong>119</strong><br>👉 View live map pins under <strong>Safe Places Directory</strong>!";
                return $reply;
            }
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

        // Safe Places & Emergency Havens (General List)
        if (str_contains($q, 'safe place') || str_contains($q, 'safe places') || str_contains($q, 'safe haven') || str_contains($q, 'shelter') || str_contains($q, 'rest spot') || str_contains($q, 'safe location')) {
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

        // First Aid & Health Specific Topics
        if (str_contains($q, 'snake')) {
            return "🐍 <strong>Emergency Snake Bite First Aid:</strong><br>1. Keep the patient calm, quiet, and still.<br>2. Immobilize the bitten limb at or below heart level.<br>3. Do NOT cut the wound, suck out venom, or tie tight tourniquets.<br>4. Transport immediately to the nearest hospital or call <strong>1990 (Suwa Seriya Ambulance)</strong>.";
        }

        if (str_contains($q, 'heat stroke') || str_contains($q, 'heat exhaustion') || str_contains($q, 'fever')) {
            return "🌡️ <strong>Heat Exhaustion & Fever First Aid:</strong><br>1. Move the person to a cool, shaded or air-conditioned area immediately.<br>2. Apply cool, damp cloths to forehead, neck, and armpits.<br>3. Sip cool water or ORS electrolyte fluid slowly.<br>4. If temperature exceeds 103°F or patient is confused/unconscious, call <strong>1990 (Suwa Seriya Ambulance)</strong> immediately.";
        }

        if (str_contains($q, 'burn') || str_contains($q, 'fire')) {
            return "🔥 <strong>Burn First Aid:</strong><br>1. Cool the burn under cool running water for 10 to 15 minutes (do NOT use ice or butter).<br>2. Gently cover with clean sterile bandage or cloth.<br>3. Seek medical attention for deep or large burns.";
        }

        if (str_contains($q, 'first aid') || str_contains($q, 'injury') || str_contains($q, 'wound')) {
            return "🩺 <strong>General First Aid Steps:</strong><br>1. <strong>Bleeding/Wounds:</strong> Apply firm direct pressure with clean cloth.<br>2. <strong>Snake Bite:</strong> Keep limb still, do not tie tight tourniquets. Call 1990.<br>3. <strong>Heat/Fever:</strong> Move to shade, hydrate with ORS electrolyte water.<br>4. Call <strong>1990 Suwa Seriya Ambulance</strong> for medical emergencies.";
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

        // General Conversational & Friendly Chat
        if (str_contains($q, 'thank') || str_contains($q, 'thanks') || str_contains($q, 'sthuthi') || str_contains($q, 'good') || str_contains($q, 'great') || str_contains($q, 'nice')) {
            return "😊 <strong>You are very welcome! / ඔබට ගොඩක් ස්තූතියි!</strong><br>Stay safe on your journeys across Sri Lanka. If you ever need emergency assistance, dial <strong>119</strong> or <strong>1990</strong>, or use our live map SOS feature!";
        }

        if (str_contains($q, 'help') || str_contains($q, 'assistance') || str_contains($q, 'udaw') || str_contains($q, 'monada')) {
            return "🤝 <strong>How I can assist you:</strong><br>• <strong>Emergency Dispatch:</strong> Police (119), Ambulance (1990), Wildlife (1985), Women Safety (1938)<br>• <strong>Safe Havens & Rest Spots:</strong> Type your town name (e.g. Colombo, Kandy, Galle)<br>• <strong>Hazard Reporting & Navigation:</strong> Use the live interactive map above!<br>• <strong>General Travel & Safety Guidance:</strong> Ask any question about traveling safely in Sri Lanka!";
        }

        // Dynamic General Knowledge & Open-Ended Question Engine
        if (str_contains($q, 'what is') || str_contains($q, 'what are') || str_contains($q, 'how to') || str_contains($q, 'how do') || str_contains($q, 'why') || str_contains($q, 'who is') || str_contains($q, 'explain') || str_contains($q, 'tell me')) {
            $cleanQuery = ucwords($inputStr);
            return "💡 <strong>Safora AI Assistant Response:</strong><br>" .
                   "Regarding <strong>\"{$cleanQuery}\"</strong>:<br>" .
                   "• <strong>Overview:</strong> Safora AI processes safety, travel, medical first aid, and general knowledge queries across Sri Lanka and worldwide.<br>" .
                   "• <strong>Guidance:</strong> For emergency medical, police, or safety assistance related to your query, dial emergency hotlines <strong>119 (Police)</strong> or <strong>1990 (Suwa Seriya Ambulance)</strong> immediately.<br>" .
                   "• <strong>Live Map Assistance:</strong> Check our live GIS map above to explore verified safe places, emergency hospitals, and safe travel routes.<br>" .
                   "<br>✨ <em>Tip: Add a free Google Gemini API Key in <code>.env</code> (`GEMINI_API_KEY=...`) to enable unlimited real-time generative AI responses for any complex coding, general science, or open-ended topic!</em>";
        }

        // Default Intelligent Fallback for Any Human Question
        $cleanQuery = htmlspecialchars($inputStr);
        return "🤖 <strong>Safora AI Safety & Knowledge Assistant:</strong><br>" .
               "Thank you for your question: <em>\"{$cleanQuery}\"</em>.<br><br>" .
               "• <strong>Emergency Support:</strong> Call <strong>119 (Police)</strong>, <strong>1990 (Ambulance)</strong>, <strong>1985 (Wildlife)</strong>, or <strong>1938 (Women & Child Help)</strong>.<br>" .
               "• <strong>Safe Havens:</strong> Type any Sri Lanka city name (e.g., Colombo, Kandy, Galle) to list verified hospitals and police hubs.<br>" .
               "• <strong>Safety Navigation:</strong> Use the AI Safe Navigation tool on our home map to plot hazard-free routes.<br>" .
               "<br>✨ <em>Tip: Add `GEMINI_API_KEY` in your `.env` file to unlock 100% full generative LLM answers for all general knowledge, translation, and open-ended topics!</em>";
    }
}
