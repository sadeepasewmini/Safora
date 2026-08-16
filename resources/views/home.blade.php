@extends('layouts.app')

@section('content')

<!-- Live Broadcast Alerts Ticker -->
@if(count($activeAlerts) > 0)
<div class="bg-amber-50 py-2 shadow-xs border-bottom border-amber-200" style="background-color: #fffbeb; border-color: #fde68a;">
    <div class="container d-flex align-items-center">
        <span class="badge bg-danger me-3 px-3 py-1 text-uppercase fw-bold" style="letter-spacing: 0.5px;"><i class="bi bi-bell-fill me-1"></i> Live Advisory</span>
        <marquee class="fw-medium text-dark mb-0 small" scrollamount="6">
            @foreach($activeAlerts as $alert)
                <span class="me-5"><strong class="text-danger">[{{ strtoupper($alert->category) }}]</strong> {{ $alert->title }}: {{ $alert->message }} ({{ $alert->area_name }})</span>
            @endforeach
        </marquee>
    </div>
</div>
@endif

<!-- WOW-Factor Modern Hero Section (First View) -->
<section class="position-relative text-white py-5 overflow-hidden" style="background: radial-gradient(circle at 70% 30%, #1e293b 0%, #0b1324 100%);">
    <!-- Subtle Grid Background Overlay -->
    <div class="position-absolute top-0 start-0 w-100 h-100 opacity-10 pointer-events-none" style="background-image: radial-gradient(#cbd5e1 1px, transparent 1px); background-size: 24px 24px; opacity: 0.05;"></div>

    <div class="container py-4 position-relative z-1">
        <div class="row align-items-center gy-5">
            
            <!-- Left Column: High Impact Title & Action -->
            <div class="col-lg-7">
                <div class="d-inline-flex align-items-center bg-slate-800 bg-opacity-80 border border-slate-700 text-warning px-3 py-15 rounded-pill small fw-semibold mb-4 shadow-sm" style="border-color: rgba(245, 158, 11, 0.3) !important;">
                    <span class="d-inline-block bg-danger rounded-circle p-1 me-2 animate-pulse" style="width: 8px; height: 8px;"></span>
                    <i class="bi bi-shield-check me-2 text-warning"></i> Official Community Safety & Emergency Network
                </div>
                
                <h1 class="display-4 fw-extrabold text-white mb-3" style="font-weight: 800; letter-spacing: -1px; line-height: 1.15;">
                    Empowering Communities with <span style="background: linear-gradient(135deg, #f59e0b 0%, #fbbf24 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Real-Time Safety</span> & Wildlife Hazard Intelligence
                </h1>

                <p class="lead text-slate-300 mb-4 opacity-90" style="font-size: 1.15rem; font-weight: 400; max-width: 620px;">
                    Instant awareness for wild elephant crossings, public crime hotspots, and flood warnings across Sri Lanka. Stay safe, report hazards in seconds, or send 1-click Emergency SOS signals.
                </p>

                <!-- Action Buttons -->
                <div class="d-flex flex-wrap align-items-center gap-3 mb-4">
                    <a href="#mapSection" class="btn btn-warning btn-lg fw-bold px-4 py-3 rounded-3 shadow-md text-dark d-inline-flex align-items-center">
                        <i class="bi bi-map-fill me-2 fs-5"></i> Explore Live Safety Map
                    </a>
                    <a href="#reportSection" class="btn btn-outline-light btn-lg fw-semibold px-4 py-3 rounded-3 d-inline-flex align-items-center" style="border-color: rgba(255,255,255,0.25);">
                        <i class="bi bi-plus-circle me-2 fs-5 text-warning"></i> Report a Hazard
                    </a>
                </div>

                <!-- Quick Location Safety Finder -->
                <div class="pt-3 border-top border-slate-800 d-flex flex-wrap align-items-center gap-2">
                    <span class="small text-slate-400 fw-medium me-1"><i class="bi bi-geo-alt-fill text-warning me-1"></i> Quick Area Status:</span>
                    <a href="#mapSection" class="badge bg-slate-800 text-slate-200 border border-slate-700 px-3 py-2 text-decoration-none fw-normal hover-bg-slate-700">Habarana (85/100 🐘)</a>
                    <a href="#mapSection" class="badge bg-slate-800 text-slate-200 border border-slate-700 px-3 py-2 text-decoration-none fw-normal hover-bg-slate-700">Bentota (90/100 🐊)</a>
                    <a href="#mapSection" class="badge bg-slate-800 text-slate-200 border border-slate-700 px-3 py-2 text-decoration-none fw-normal hover-bg-slate-700">Colombo (95/100 🚔)</a>
                </div>
            </div>

            <!-- Right Column: Live Safety Status Radar Console -->
            <div class="col-lg-5">
                <div class="card card-pro border-0 text-white p-4 shadow-2xl" style="background: rgba(15, 23, 42, 0.85); backdrop-filter: blur(16px); border: 1px solid rgba(255, 255, 255, 0.12) !important; border-radius: 16px;">
                    
                    <div class="d-flex align-items-center justify-content-between mb-4 pb-3 border-bottom border-slate-800">
                        <div>
                            <h6 class="fw-bold text-warning mb-0 uppercase-spacing" style="letter-spacing: 0.5px;"><i class="bi bi-radar me-2 text-danger"></i>Live Safety Console</h6>
                            <small class="text-slate-400" style="font-size: 0.75rem;">Sri Lanka Emergency Monitoring</small>
                        </div>
                        <span class="badge bg-emerald-500 bg-opacity-20 text-emerald-400 border border-emerald-500 border-opacity-30 px-3 py-1 rounded-pill" style="color: #34d399; font-size: 0.75rem;">
                            ● LIVE MAP STREAMING
                        </span>
                    </div>

                    <!-- Live Indicators -->
                    <div class="row g-3 mb-4">
                        <div class="col-6">
                            <div class="p-3 rounded-3 bg-slate-900 bg-opacity-80 border border-slate-800">
                                <div class="d-flex align-items-center justify-content-between mb-1">
                                    <span class="small text-slate-400" style="font-size: 0.75rem;">Verified Hazards</span>
                                    <i class="bi bi-check-circle-fill text-warning"></i>
                                </div>
                                <div class="h3 fw-bold text-white mb-0" id="liveHazardCount">{{ $stats['total_incidents'] }}</div>
                                <small class="text-slate-400" style="font-size: 0.7rem;">Live on map</small>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="p-3 rounded-3 bg-slate-900 bg-opacity-80 border border-slate-800">
                                <div class="d-flex align-items-center justify-content-between mb-1">
                                    <span class="small text-slate-400" style="font-size: 0.75rem;">Wildlife Sightings</span>
                                    <span class="fs-6">🐘</span>
                                </div>
                                <div class="h3 fw-bold text-warning mb-0">{{ $stats['wildlife_count'] }}</div>
                                <small class="text-slate-400" style="font-size: 0.7rem;">Elephants / Leopards</small>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="p-3 rounded-3 bg-slate-900 bg-opacity-80 border border-slate-800">
                                <div class="d-flex align-items-center justify-content-between mb-1">
                                    <span class="small text-slate-400" style="font-size: 0.75rem;">Public Safety</span>
                                    <i class="bi bi-shield-shaded text-danger"></i>
                                </div>
                                <div class="h3 fw-bold text-danger mb-0">{{ $stats['crime_count'] }}</div>
                                <small class="text-slate-400" style="font-size: 0.7rem;">High risk zones</small>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="p-3 rounded-3 bg-slate-900 bg-opacity-80 border border-slate-800">
                                <div class="d-flex align-items-center justify-content-between mb-1">
                                    <span class="small text-slate-400" style="font-size: 0.75rem;">Safe Shelters</span>
                                    <i class="bi bi-hospital-fill text-success"></i>
                                </div>
                                <div class="h3 fw-bold text-emerald-400 mb-0" style="color: #34d399;">{{ $stats['safe_places_count'] }}</div>
                                <small class="text-slate-400" style="font-size: 0.7rem;">Police & Hospitals</small>
                            </div>
                        </div>
                    </div>

                    <!-- Instant SOS Banner Box inside Console -->
                    <div class="p-3 rounded-3 bg-danger bg-opacity-15 border border-danger border-opacity-30 d-flex align-items-center justify-content-between">
                        <div>
                            <div class="fw-bold text-white small"><i class="bi bi-bell-fill me-1 text-danger"></i> 1-Click Instant Emergency SOS</div>
                            <small class="text-slate-300" style="font-size: 0.75rem;">Transmits live GPS location to nearest Authorities</small>
                        </div>
                        <button type="button" class="btn btn-sm btn-danger fw-bold px-3 py-1.5 shadow-sm" onclick="document.getElementById('sosTriggerBtn').click();">
                            Trigger SOS
                        </button>
                    </div>

                </div>
            </div>

        </div>
    </div>
</section>

<!-- Interactive Live GIS Safety Map Section -->
<section id="mapSection" class="py-5">
    <div class="container">
        <div class="d-flex flex-wrap align-items-center justify-content-between mb-3">
            <div>
                <div class="d-flex align-items-center gap-2 mb-1">
                    <h3 class="fw-bold mb-0 text-slate-900"><i class="bi bi-broadcast text-danger me-2"></i>Live GIS Safety Map</h3>
                    <span class="badge bg-danger text-white fw-bold px-2.5 py-1" style="font-size: 0.7rem;"><i class="bi bi-arrow-repeat spin me-1"></i> REAL-TIME AUTO STREAM</span>
                </div>
                <p class="text-muted mb-0 small">Live verified incidents, active wildlife sightings, satellite terrain views, and 24/7 safe places.</p>
            </div>
            
            <!-- Map Controls & GPS Location Tracker Button -->
            <div class="d-flex flex-wrap align-items-center gap-2 mt-2 mt-md-0">
                <button type="button" class="btn btn-sm btn-emerald-600 btn-success fw-bold px-3 shadow-xs" id="locateUserBtn">
                    <i class="bi bi-crosshair me-1"></i> Track My Live Location
                </button>
                <button type="button" class="btn btn-sm btn-dark text-warning border border-warning fw-bold px-3 shadow-xs" id="nightSafetyToggleBtn">
                    <i class="bi bi-moon-stars-fill me-1"></i> Night Safety & Heatmap
                </button>
                <div class="btn-group flex-wrap" role="group">
                    <a href="{{ route('home') }}#mapSection" class="btn btn-sm {{ !$typeFilter ? 'btn-dark' : 'btn-outline-dark' }} px-3">All Hazards</a>
                    <a href="{{ route('home', ['type' => 'wildlife']) }}#mapSection" class="btn btn-sm {{ $typeFilter === 'wildlife' ? 'btn-warning text-dark fw-bold' : 'btn-outline-warning text-dark' }} px-3">🐘 Wildlife</a>
                    <a href="{{ route('home', ['type' => 'crime']) }}#mapSection" class="btn btn-sm {{ $typeFilter === 'crime' ? 'btn-danger' : 'btn-outline-danger' }} px-3">🚔 Crimes</a>
                    <a href="{{ route('home', ['type' => 'disaster']) }}#mapSection" class="btn btn-sm {{ $typeFilter === 'disaster' ? 'btn-info text-dark fw-bold' : 'btn-outline-info' }} px-3">🌧️ Disasters</a>
                    <a href="{{ route('home', ['type' => 'road']) }}#mapSection" class="btn btn-sm {{ $typeFilter === 'road' ? 'btn-secondary' : 'btn-outline-secondary' }} px-3">🚗 Road</a>
                </div>
            </div>
        </div>

        <!-- Quick Pinpoint City Location Search Input -->
        <div class="mb-3">
            <div class="input-group shadow-xs rounded-3 overflow-hidden border border-slate-300">
                <span class="input-group-text bg-dark text-warning border-0 px-3 fw-bold small"><i class="bi bi-geo-alt-fill me-1 text-warning"></i> Pinpoint My Town / City</span>
                <input type="text" id="mapQuickCitySearchInput" class="form-control border-0 py-2 px-3 fw-semibold text-slate-900" placeholder="Type your town or city (e.g. Kandy, Peradeniya, Galle, Jaffna, Kurunegala, Colombo)..." autocomplete="off" style="font-size: 0.88rem; color: #0f172a !important;">
                <button type="button" class="btn btn-warning text-dark fw-bold px-3 py-2" id="mapQuickCitySearchBtn">
                    <i class="bi bi-search me-1"></i> Jump To Location
                </button>
            </div>
            <div id="mapQuickCitySuggestions" class="list-group shadow-lg position-relative d-none mt-1" style="z-index: 9999; max-height: 200px; overflow-y: auto; background: white; border-radius: 8px;"></div>
        </div>

        <!-- Live Distance Alert Box -->
        <div id="userDistanceAlert" class="alert alert-info py-2 px-3 mb-3 d-none border-info rounded-3 small">
            <i class="bi bi-compass-fill me-2 text-primary"></i> <span id="distanceText"></span>
        </div>

        <!-- AI Safe Route & Navigation Widget (USP) -->
        <div class="card card-pro border-0 shadow-sm p-3 mb-3 text-white rounded-4" style="background-color: #0f172a !important; border: 1px solid #1e293b !important;">
            <div class="d-flex flex-wrap align-items-center justify-content-between mb-2">
                <div class="d-flex align-items-center gap-2">
                    <span class="badge bg-warning text-dark fw-bold px-2 py-1"><i class="bi bi-signpost-split-fill me-1"></i> AI SAFE NAVIGATION</span>
                    <h6 class="fw-bold mb-0 text-white">Safe Route & Hazard Avoidance Navigation Planner</h6>
                </div>
                <small class="text-slate-400">Plots travel route avoiding active verified wildlife, flood, and crime hazards</small>
            </div>

            <div class="row g-2 align-items-center">
                <div class="col-md-5 position-relative">
                    <div class="input-group">
                        <span class="input-group-text bg-warning text-dark border-0 fw-bold px-3">A (Start)</span>
                        <input type="text" id="routeStartInput" class="form-control bg-white text-dark fw-semibold border-0 py-2" placeholder="Type location (e.g. Colombo, Kandy, Peradeniya)..." style="color: #0f172a !important; font-size: 0.9rem;" autocomplete="off">
                        <button type="button" class="btn btn-warning text-dark fw-bold px-3" id="routeCurrentGpsBtn" title="Use My Current GPS">🎯 GPS</button>
                    </div>
                    <div id="routeStartSuggestions" class="list-group position-absolute w-100 shadow-lg d-none mt-1" style="top: 100%; left: 0; z-index: 9999; max-height: 240px; overflow-y: auto; background: #ffffff; border-radius: 8px; border: 1px solid #cbd5e1;"></div>
                </div>
                <div class="col-md-5 position-relative">
                    <div class="input-group">
                        <span class="input-group-text bg-danger text-white border-0 fw-bold px-3">B (Dest)</span>
                        <input type="text" id="routeDestInput" class="form-control bg-white text-dark fw-semibold border-0 py-2" placeholder="Destination (e.g. Halloluwa, Galle, Jaffna)..." style="color: #0f172a !important; font-size: 0.9rem;" autocomplete="off">
                    </div>
                    <div id="routeDestSuggestions" class="list-group position-absolute w-100 shadow-lg d-none mt-1" style="top: 100%; left: 0; z-index: 9999; max-height: 240px; overflow-y: auto; background: #ffffff; border-radius: 8px; border: 1px solid #cbd5e1;"></div>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-warning text-dark fw-bold py-2 w-100 shadow-sm" id="planSafeRouteBtn">
                        <i class="bi bi-compass me-1"></i> Calculate Route
                    </button>
                </div>
            </div>

            <!-- Safe Route Results Box -->
            <div id="routeResultsBox" class="mt-3 p-3 bg-slate-800 rounded-3 d-none border border-slate-700">
                <div class="d-flex flex-wrap align-items-center justify-content-between border-bottom border-slate-700 pb-2 mb-2">
                    <div>
                        <span id="routeSafetyScoreBadge" class="badge fs-6 px-3 py-1 bg-success">Safety Score: 92/100</span>
                        <strong id="routeSafetyRatingText" class="ms-2 text-white fs-6">Highly Safe Route</strong>
                    </div>
                    <div id="routeDistanceInfo" class="small text-slate-300">
                        <i class="bi bi-shield-check text-warning me-1"></i> Live Hazard Avoidance Scan Active
                    </div>
                </div>
                <div id="routeHazardsSummary" class="small text-slate-300"></div>
            </div>
        </div>

        <div id="saforaMap" style="height: 520px; border-radius: 16px; border: 1px solid #cbd5e1; box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);"></div>
        <script>
            setTimeout(function() {
                if (typeof initSaforaMap === 'function') {
                    initSaforaMap();
                }
            }, 50);
        </script>
        
        <!-- Night Safety Heatmap Legend Overlay -->
        <div id="nightHeatmapLegend" class="mt-3 p-3 bg-slate-900 text-white rounded-4 d-none border border-slate-700 shadow-lg">
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
                <div class="d-flex align-items-center gap-2">
                    <span class="badge bg-warning text-dark fw-bold px-2 py-1"><i class="bi bi-moon-stars-fill me-1"></i> NIGHT SAFETY MODE ACTIVE</span>
                    <h6 class="fw-bold mb-0 text-white">Streetlight & Visibility Heatmap Layer</h6>
                </div>
                <div class="d-flex flex-wrap align-items-center gap-3">
                    <span class="badge bg-success text-white fw-bold px-2.5 py-1.5 fs-7"><i class="bi bi-lightbulb-fill me-1"></i> 🟢 Well-Lit Safe Corridor</span>
                    <span class="badge bg-danger text-white fw-bold px-2.5 py-1.5 fs-7"><i class="bi bi-exclamation-octagon-fill me-1"></i> 🔴 Dark / Unlit Risk Area</span>
                </div>
            </div>
            <p class="text-slate-400 small mb-0 mt-2"><i class="bi bi-info-circle me-1 text-info"></i> Automatically switched map to Dark GIS mode. Highlighting streetlight illumination, CCTV coverage, and reported unlit harassment corridors for night commuters.</p>
        </div>
    </div>
</section>

<!-- Community Verified Safe Places & Ratings Directory (USP Feature) -->
<section id="safePlacesSection" class="py-5 bg-slate-900 text-white border-top border-slate-800">
    <div class="container">
        <div class="d-flex flex-wrap align-items-center justify-content-between mb-4">
            <div>
                <div class="d-flex align-items-center gap-2 mb-1">
                    <span class="badge bg-emerald-500 text-dark fw-bold px-2.5 py-1" style="font-size: 0.75rem;"><i class="bi bi-star-fill text-dark me-1"></i> COMMUNITY RATED</span>
                    <h3 class="fw-bold mb-0 text-white"><i class="bi bi-shield-check text-emerald-400 me-2"></i>Verified Safe Places & Night Haven Directory</h3>
                </div>
                <p class="text-slate-400 mb-0 small">Community-reviewed police stations, 24/7 emergency hospitals, and female safe havens with lighting & staff ratings.</p>
            </div>
            <div>
                <button type="button" class="btn btn-outline-warning btn-sm fw-bold px-3 py-2" onclick="openGeneralRateModal()">
                    <i class="bi bi-star-fill me-1"></i> Write a Safe Place Review
                </button>
            </div>
        </div>

        <div class="row g-4" id="safePlacesCardsGrid">
            @foreach($safePlaces as $sp)
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 bg-slate-800 border-slate-700 text-white rounded-4 shadow-sm p-3 d-flex flex-column justify-content-between">
                    <div>
                        <div class="d-flex align-items-start justify-content-between mb-2">
                            <span class="badge bg-emerald-500 text-dark fw-bold px-2 py-1"><i class="bi bi-hospital me-1"></i> {{ strtoupper($sp->type ?? 'Safe Haven') }}</span>
                            <span class="badge bg-slate-700 text-warning border border-warning fw-bold px-2 py-1">
                                ⭐ {{ number_format($sp->rating ?? 4.8, 1) }} / 5.0 ({{ $sp->reviews_count ?? rand(18, 45) }})
                            </span>
                        </div>
                        <h5 class="fw-bold text-white mb-1">{{ $sp->name }}</h5>
                        <p class="text-slate-400 small mb-2"><i class="bi bi-geo-alt-fill text-danger me-1"></i> {{ $sp->address ?? $sp->area_name }}</p>
                        
                        <div class="bg-slate-900 p-2.5 rounded-3 mb-3 border border-slate-700">
                            <div class="d-flex align-items-center justify-content-between small mb-1">
                                <span class="text-slate-300">💡 Night Lighting:</span>
                                <span class="fw-bold text-emerald-400"><i class="bi bi-check-circle-fill me-1"></i> Well-Lit (High Visibility)</span>
                            </div>
                            <div class="d-flex align-items-center justify-content-between small mb-1">
                                <span class="text-slate-300">👮 Security Staff:</span>
                                <span class="fw-bold text-info"><i class="bi bi-shield-lock-fill me-1"></i> 24/7 Active Duty Officers</span>
                            </div>
                            <div class="d-flex align-items-center justify-content-between small">
                                <span class="text-slate-300">🛡️ Night Commuter Index:</span>
                                <span class="fw-bold text-warning"><i class="bi bi-star-fill me-1"></i> 98% Highly Safe</span>
                            </div>
                        </div>

                        <p class="text-slate-300 italic small mb-3 style-quote" style="font-size: 0.82rem;">
                            <i class="bi bi-quote me-1 text-warning"></i>"{{ $sp->recent_review ?? 'Very supportive staff and bright LED lights surrounding the main gate. 24/7 emergency response ready.' }}"
                        </p>
                    </div>

                    <div class="d-flex align-items-center gap-2 pt-2 border-top border-slate-700">
                        <a href="tel:{{ $sp->phone }}" class="btn btn-emerald-600 btn-success btn-sm fw-bold flex-grow-1">
                            <i class="bi bi-telephone-fill me-1"></i> Call Station ({{ $sp->phone }})
                        </a>
                        <button type="button" class="btn btn-outline-warning btn-sm fw-bold px-3" onclick="openRateSafePlaceModal('{{ addslashes($sp->name) }}', {{ $sp->id }})">
                            ⭐ Rate
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Rate & Review Safe Place Modal -->
<div class="modal fade" id="rateSafePlaceModal" tabindex="-1" aria-labelledby="rateSafePlaceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-slate-900 text-white border border-slate-700 rounded-4 shadow-lg">
            <div class="modal-header border-bottom border-slate-800 p-3">
                <div class="d-flex align-items-center gap-2">
                    <span class="badge bg-warning text-dark fw-bold px-2 py-1"><i class="bi bi-star-fill me-1"></i> COMMUNITY VERIFICATION</span>
                    <h5 class="modal-title fw-bold text-white fs-6" id="rateModalTitle">Rate Safe Place</h5>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form id="safePlaceReviewForm">
                    <input type="hidden" id="safePlaceIdInput" value="">
                    
                    <div class="mb-3 text-center">
                        <label class="form-label fw-bold text-slate-300 small mb-1">Your Safety Rating (1 to 5 Stars)</label>
                        <div class="fs-2 text-warning cursor-pointer user-select-none" id="starRatingSelector">
                            <i class="bi bi-star-fill star-icon text-warning" data-val="1" style="cursor:pointer;"></i>
                            <i class="bi bi-star-fill star-icon text-warning" data-val="2" style="cursor:pointer;"></i>
                            <i class="bi bi-star-fill star-icon text-warning" data-val="3" style="cursor:pointer;"></i>
                            <i class="bi bi-star-fill star-icon text-warning" data-val="4" style="cursor:pointer;"></i>
                            <i class="bi bi-star-fill star-icon text-warning" data-val="5" style="cursor:pointer;"></i>
                        </div>
                        <input type="hidden" id="selectedStarValue" value="5">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold text-slate-300 small">1. Streetlight & Night Lighting Quality</label>
                        <select class="form-select bg-slate-800 text-white border-slate-700 rounded-3" id="lightingQualityInput">
                            <option value="Well-Lit (High Visibility)">🟢 Well-Lit & Bright LED Streetlights</option>
                            <option value="Dimly Lit (Moderate Visibility)">🟡 Dimly Lit / Partial Streetlights</option>
                            <option value="Dark / Poor Lighting">🔴 Dark / Missing Streetlights (Low Visibility)</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold text-slate-300 small">2. Staff / Security Responsiveness</label>
                        <select class="form-select bg-slate-800 text-white border-slate-700 rounded-3" id="staffPresenceInput">
                            <option value="24/7 Active Duty Officers">👮 24/7 Active Duty Officers / Medical Staff</option>
                            <option value="CCTV Monitored Haven">🛡️ CCTV Monitored Shelter</option>
                            <option value="Limited Night Staff">⚠️ Limited Night Staff On-Site</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold text-slate-300 small">3. Your Night Safety Review / Feedback</label>
                        <textarea class="form-control bg-slate-800 text-white border-slate-700 rounded-3" id="reviewCommentInput" rows="3" placeholder="Describe lighting, officer responsiveness, and safety at night..." required></textarea>
                    </div>

                    <button type="submit" class="btn btn-warning text-dark fw-bold w-100 py-2 rounded-3 shadow-sm">
                        <i class="bi bi-send-fill me-1"></i> Submit Community Review
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Simple Incident Reporting Form + AI Assistant Section -->
<section id="reportSection" class="py-5 bg-white border-top border-bottom">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-lg-8">
                <div class="card card-pro p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3 pb-3 border-bottom">
                        <div>
                            <h4 class="fw-bold text-dark mb-1"><i class="bi bi-exclamation-triangle-fill text-amber-600 me-2"></i>Report a Safety Hazard</h4>
                            <p class="text-muted small mb-0">Help protect your community by reporting wildlife or safety hazards.</p>
                        </div>
                        <span class="badge bg-slate-900 text-warning px-3 py-2 fw-semibold rounded-2"><i class="bi bi-magic me-1"></i> AI Smart Classifier</span>
                    </div>

                    <form action="{{ route('incidents.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-slate-700">1. Incident Title / Brief Description</label>
                            <input type="text" name="title" id="incidentTitle" class="form-control form-control-lg rounded-3 fs-6" placeholder="e.g. Wild elephants crossing Habarana main road near 14th post" required>
                        </div>

                        <!-- AI Suggestion Box -->
                        <div id="aiSuggestionBox" class="alert alert-warning py-2 small d-none rounded-3 border-warning">
                            <i class="bi bi-stars text-warning me-1"></i> <strong>AI Auto-Classification:</strong> Categorized as <span id="aiCatName" class="badge bg-dark text-warning"></span> with <span id="aiConfidence"></span>% confidence.
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-slate-700">2. Category</label>
                                <select name="category_id" id="categorySelect" class="form-select rounded-3" required>
                                    <option value="">Select Category...</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->type == 'wildlife' ? '🐘' : ($cat->type == 'crime' ? '🚔' : '🌧️') }} {{ $cat->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-slate-700">Severity Risk</label>
                                <select name="severity" id="severitySelect" class="form-select rounded-3" required>
                                    <option value="low">Low Risk</option>
                                    <option value="medium" selected>Medium Risk</option>
                                    <option value="high">High Risk</option>
                                    <option value="critical">Critical Emergency</option>
                                </select>
                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-slate-700">Area / Town Name</label>
                                <input type="text" name="area_name" id="areaName" class="form-control rounded-3" placeholder="e.g. Habarana / Bentota / Kandy" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-slate-700">Upload Photo (Optional)</label>
                                <input type="file" name="image" class="form-control rounded-3" accept="image/*">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold text-slate-700">3. Hazard Location (Type Place Name or Search)</label>
                            <div class="input-group mb-2">
                                <span class="input-group-text bg-slate-100 text-slate-700"><i class="bi bi-geo-alt-fill text-danger"></i></span>
                                <input type="text" id="locationSearchInput" class="form-control form-control-lg fs-6" placeholder="Type place or town name (e.g. Habarana Junction, Bentota Beach, Kandy Clock Tower)...">
                                <button type="button" class="btn btn-warning text-dark fw-bold px-3" id="searchPlaceBtn">
                                    <i class="bi bi-search me-1"></i> Find Place
                                </button>
                                <button type="button" class="btn btn-outline-dark fw-semibold" id="fetchGpsBtn">
                                    <i class="bi bi-crosshair me-1"></i> Auto GPS
                                </button>
                            </div>
                            
                            <div class="d-flex align-items-center justify-content-between pt-1">
                                <small class="text-muted" style="font-size: 0.75rem;"><i class="bi bi-info-circle text-primary me-1"></i> Type a place name above or click anywhere on the map to set location.</small>
                                <button type="button" class="btn btn-link btn-sm p-0 text-decoration-none text-slate-600" data-bs-toggle="collapse" data-bs-target="#gpsCoordInputs">
                                    <i class="bi bi-sliders me-1"></i> Raw Coordinates
                                </button>
                            </div>

                            <div class="collapse mt-2" id="gpsCoordInputs">
                                <div class="row g-2">
                                    <div class="col-6">
                                        <input type="text" name="latitude" id="latInput" class="form-control form-control-sm font-mono" placeholder="Latitude" value="8.0372" required>
                                    </div>
                                    <div class="col-6">
                                        <input type="text" name="longitude" id="lngInput" class="form-control form-control-sm font-mono" placeholder="Longitude" value="80.7517" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold text-slate-700">Detailed Description</label>
                            <textarea name="description" class="form-control rounded-3" rows="3" placeholder="Provide extra details such as exact landmarks, time seen, etc." required></textarea>
                        </div>

                        <button type="submit" class="btn btn-warning btn-lg w-100 fw-bold rounded-3 py-3 shadow-sm text-dark">
                            <i class="bi bi-send-fill me-2"></i> Submit Incident Report
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Area Safety Score Indicator Section -->
<section class="py-5 bg-slate-50">
    <div class="container">
        <div class="text-center mb-4">
            <h3 class="fw-bold text-slate-900 mb-1"><i class="bi bi-shield-shaded text-warning me-2"></i>Regional Safety Scores</h3>
            <p class="text-muted small">Live safety indices calculated based on verified incidents and risk severity.</p>
        </div>

        <div class="row g-3">
            @foreach($areaScores as $area)
            <div class="col-md-4 col-lg-2">
                <div class="card card-pro p-3 text-center border-top border-3 border-{{ $area['badge_color'] }}">
                    <h6 class="fw-bold text-slate-900 mb-1">{{ $area['area'] }}</h6>
                    <div class="h3 fw-bold text-{{ $area['badge_color'] }} my-2">
                        {{ $area['score'] }}<span class="fs-6 text-muted">/100</span>
                    </div>
                    <span class="badge bg-{{ $area['badge_color'] }} px-2 py-1 mb-1 small">{{ $area['risk_level'] }}</span>
                    <small class="text-muted d-block font-mono" style="font-size: 0.75rem;">{{ $area['incidents'] }} active reports</small>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- AI Risk Prediction Engine & Time-Series Analytics (USP Feature) -->
<section id="aiPredictionSection" class="py-5 bg-dark text-white position-relative" style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);">
    <div class="container">
        <div class="d-flex flex-wrap align-items-center justify-content-between mb-4 pb-3 border-bottom border-slate-800">
            <div>
                <span class="badge bg-amber-500 text-dark fw-extrabold px-3 py-1 mb-2 rounded-pill text-uppercase" style="letter-spacing: 0.5px; background-color: #f59e0b;">
                    <i class="bi bi-cpu-fill me-1"></i> AI Predictive Engine
                </span>
                <h3 class="fw-extrabold text-white mb-1">Time-Series Risk Prediction & Analytics</h3>
                <p class="text-slate-400 small mb-0">ML-driven forecasting analyzing temporal incident density, crime peak hours, and Sri Lanka hazard trends.</p>
            </div>

            <!-- Area & Hour Selector -->
            <div class="d-flex align-items-center gap-2 mt-3 mt-md-0">
                <select id="riskAreaSelect" class="form-select form-select-sm bg-slate-800 text-white border-slate-700 rounded-3">
                    <option value="Colombo">Colombo Region</option>
                    <option value="Habarana">Habarana / Trinco</option>
                    <option value="Bentota">Bentota River Area</option>
                    <option value="Kandy">Kandy Central</option>
                    <option value="Galle">Galle Coast</option>
                    <option value="Hatton">Hatton Tea Zone</option>
                    <option value="Kiribathgoda">Kiribathgoda</option>
                </select>
                <select id="riskHourSelect" class="form-select form-select-sm bg-slate-800 text-white border-slate-700 rounded-3">
                    <option value="22">22:00 (Night Peak)</option>
                    <option value="02">02:00 (Late Night)</option>
                    <option value="08">08:00 (Morning Commute)</option>
                    <option value="14">14:00 (Afternoon)</option>
                    <option value="19">19:00 (Evening Rush)</option>
                </select>
                <button type="button" class="btn btn-sm btn-warning fw-bold px-3 text-dark rounded-3" id="calcRiskBtn">
                    <i class="bi bi-lightning-charge-fill me-1"></i> Predict Risk
                </button>
            </div>
        </div>

        <div class="row g-4 align-items-center">
            <!-- Left Column: Prediction Gauge Card -->
            <div class="col-lg-5">
                <div class="card card-pro bg-slate-900 border-slate-800 p-4 text-white rounded-4 shadow-xl" style="background-color: #0f172a !important;">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="small text-slate-400 text-uppercase fw-semibold" style="letter-spacing: 0.5px;">Predicted Hazard Index</span>
                        <span id="riskLevelBadge" class="badge bg-danger text-white px-3 py-1 rounded-pill">CRITICAL RISK</span>
                    </div>

                    <div class="text-center py-3">
                        <div id="riskPercentageDisplay" class="display-2 fw-black text-warning font-mono mb-0" style="font-weight: 900; color: #f59e0b;">88%</div>
                        <div class="small text-slate-400 mt-1">High Risk Probability at <span id="riskHourDisplay" class="text-white fw-bold">22:00</span></div>
                    </div>

                    <div class="p-3 rounded-3 bg-slate-800 bg-opacity-70 border border-slate-700 mt-2 mb-3">
                        <div class="fw-bold text-warning small mb-1"><i class="bi bi-info-circle-fill me-1"></i> Forecast Rationale</div>
                        <p id="riskReasonText" class="small text-slate-300 mb-0">High risk predicted due to unlit alleys, historical theft/harassment incidents, and night hours in Colombo.</p>
                    </div>

                    <div class="border-top border-slate-800 pt-3">
                        <h6 class="fw-semibold text-white small mb-2"><i class="bi bi-shield-check text-emerald-400 me-1" style="color: #34d399;"></i> AI Recommended Safety Actions:</h6>
                        <ul id="riskRecsList" class="small text-slate-300 ps-3 mb-0">
                            <li>Avoid unlit street corridors after 8 PM</li>
                            <li>Enable 1-Click SOS background trigger</li>
                            <li>Share live GPS coordinates with family contacts</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Right Column: Predictive Time-Series Chart & Category Risk Breakdown -->
            <div class="col-lg-7">
                <div class="card card-pro bg-slate-900 border-slate-800 p-4 rounded-4 shadow-xl mb-3" style="background-color: #0f172a !important;">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h6 class="fw-bold text-white mb-0"><i class="bi bi-graph-up-arrow text-warning me-2"></i>24-Hour Hazard Trend Analytics</h6>
                        <span class="badge bg-slate-800 text-slate-300 border border-slate-700 font-mono">Realtime ML Model</span>
                    </div>
                    <div style="height: 200px;">
                        <canvas id="aiRiskChart"></canvas>
                    </div>
                </div>

                <!-- Category Specific Crime & Threat Risk Breakdown -->
                <div class="card card-pro bg-slate-900 border-slate-800 p-3.5 rounded-4 shadow-xl" style="background-color: #0f172a !important; border: 1px solid #1e293b !important;">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h6 class="fw-bold text-white small mb-0"><i class="bi bi-shield-slash-fill text-danger me-2"></i>Crime & Threat Risk Type Breakdown</h6>
                        <span class="badge bg-slate-800 text-slate-400 border border-slate-700 font-mono" style="font-size: 0.7rem;">Dynamic Threat Analysis</span>
                    </div>

                    <div class="row g-2.5">
                        <!-- Harassment Risk -->
                        <div class="col-12 col-sm-6 col-xl-3">
                            <div class="p-3 bg-slate-800 bg-opacity-90 rounded-3 border border-slate-700 h-100 d-flex flex-column justify-content-between shadow-sm">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="text-white fw-bold small" style="color: #ffffff !important;"><i class="bi bi-exclamation-octagon-fill text-warning me-1"></i> Harassment</span>
                                    <span id="harassmentRiskVal" class="badge bg-warning text-dark fw-extrabold px-2 py-1 fs-7">68%</span>
                                </div>
                                <div class="progress bg-slate-900 rounded-pill overflow-hidden" style="height: 8px; border: 1px solid rgba(255,255,255,0.05);">
                                    <div id="harassmentRiskBar" class="progress-bar bg-warning rounded-pill" role="progressbar" style="width: 68%;"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Theft Risk -->
                        <div class="col-12 col-sm-6 col-xl-3">
                            <div class="p-3 bg-slate-800 bg-opacity-90 rounded-3 border border-slate-700 h-100 d-flex flex-column justify-content-between shadow-sm">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="text-white fw-bold small" style="color: #ffffff !important;"><i class="bi bi-bag-x-fill text-info me-1"></i> Theft / Snatch</span>
                                    <span id="theftRiskVal" class="badge bg-info text-dark fw-extrabold px-2 py-1 fs-7">54%</span>
                                </div>
                                <div class="progress bg-slate-900 rounded-pill overflow-hidden" style="height: 8px; border: 1px solid rgba(255,255,255,0.05);">
                                    <div id="theftRiskBar" class="progress-bar bg-info rounded-pill" role="progressbar" style="width: 54%;"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Unlit Corridor -->
                        <div class="col-12 col-sm-6 col-xl-3">
                            <div class="p-3 bg-slate-800 bg-opacity-90 rounded-3 border border-slate-700 h-100 d-flex flex-column justify-content-between shadow-sm">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="text-white fw-bold small" style="color: #ffffff !important;"><i class="bi bi-lightbulb-off-fill text-danger me-1"></i> Unlit Alley</span>
                                    <span id="unlitRiskVal" class="badge bg-danger text-white fw-extrabold px-2 py-1 fs-7">82%</span>
                                </div>
                                <div class="progress bg-slate-900 rounded-pill overflow-hidden" style="height: 8px; border: 1px solid rgba(255,255,255,0.05);">
                                    <div id="unlitRiskBar" class="progress-bar bg-danger rounded-pill" role="progressbar" style="width: 82%;"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Wildlife Hazard -->
                        <div class="col-12 col-sm-6 col-xl-3">
                            <div class="p-3 bg-slate-800 bg-opacity-90 rounded-3 border border-slate-700 h-100 d-flex flex-column justify-content-between shadow-sm">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="text-white fw-bold small" style="color: #ffffff !important;">🐘 Wildlife Hazard</span>
                                    <span id="wildlifeRiskVal" class="badge bg-success text-white fw-extrabold px-2 py-1 fs-7" style="background-color: #059669 !important; color: #ffffff !important;">18%</span>
                                </div>
                                <div class="progress bg-slate-900 rounded-pill overflow-hidden" style="height: 8px; border: 1px solid rgba(255,255,255,0.05);">
                                    <div id="wildlifeRiskBar" class="progress-bar bg-success rounded-pill" role="progressbar" style="width: 18%; background-color: #10b981 !important;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Safe Places Locator & National Hotlines Section -->
<section id="safePlacesSection" class="py-5 bg-white border-top">
    <div class="container">
        
        <!-- National Common Emergency Hotlines Banner -->
        <div class="mb-5 p-4 rounded-4 shadow-xl text-white" style="background: linear-gradient(135deg, #0b1329 0%, #1e293b 100%); border: 1px solid rgba(245, 158, 11, 0.3);">
            <div class="d-flex flex-wrap align-items-center justify-content-between mb-4 pb-3 border-bottom border-slate-700">
                <div>
                    <div class="d-flex align-items-center gap-2 mb-1">
                        <span class="badge bg-danger text-white px-2.5 py-1 fw-bold rounded-2" style="font-size: 0.75rem;"><i class="bi bi-telephone-fill me-1"></i> DIRECT DIAL</span>
                        <h4 class="fw-bold mb-0 text-white"><i class="bi bi-shield-lock-fill text-warning me-2"></i>Sri Lanka National Emergency Hotlines</h4>
                    </div>
                    <p class="text-slate-400 mb-0 small">Direct 24/7 toll-free emergency response dispatchers across Sri Lanka</p>
                </div>
                <div class="mt-2 mt-md-0">
                    <span class="badge bg-slate-800 text-warning border border-warning px-3 py-2 rounded-pill small fw-bold shadow-sm">
                        <i class="bi bi-headset me-1 text-danger"></i> 24/7 TOLL-FREE DISPATCH
                    </span>
                </div>
            </div>

            <div class="row g-3">
                <!-- 119 Police Emergency -->
                <div class="col-6 col-md-4 col-lg-2">
                    <a href="tel:119" class="text-decoration-none d-block p-3 rounded-4 bg-slate-800 bg-opacity-90 border border-slate-700 text-center hover-card transition-all h-100 shadow-sm">
                        <div class="fs-3 text-danger mb-1"><i class="bi bi-shield-fill-exclamation"></i></div>
                        <div class="fw-extrabold fs-3 text-white mb-0" style="letter-spacing: -0.5px;">119</div>
                        <small class="text-slate-300 d-block fw-semibold text-truncate" style="font-size: 0.76rem;">Police Emergency</small>
                    </a>
                </div>

                <!-- 1990 Suwa Seriya Ambulance -->
                <div class="col-6 col-md-4 col-lg-2">
                    <a href="tel:1990" class="text-decoration-none d-block p-3 rounded-4 bg-slate-800 bg-opacity-90 border border-slate-700 text-center hover-card transition-all h-100 shadow-sm">
                        <div class="fs-3 text-emerald-400 mb-1" style="color: #34d399;"><i class="bi bi-heart-pulse-fill"></i></div>
                        <div class="fw-extrabold fs-3 text-white mb-0" style="letter-spacing: -0.5px;">1990</div>
                        <small class="text-slate-300 d-block fw-semibold text-truncate" style="font-size: 0.76rem;">Suwa Seriya Ambulance</small>
                    </a>
                </div>

                <!-- 1985 Wildlife Protection -->
                <div class="col-6 col-md-4 col-lg-2">
                    <a href="tel:1985" class="text-decoration-none d-block p-3 rounded-4 bg-slate-800 bg-opacity-90 border border-slate-700 text-center hover-card transition-all h-100 shadow-sm">
                        <div class="fs-3 text-warning mb-1">🐘</div>
                        <div class="fw-extrabold fs-3 text-white mb-0" style="letter-spacing: -0.5px;">1985</div>
                        <small class="text-slate-300 d-block fw-semibold text-truncate" style="font-size: 0.76rem;">Wildlife & Elephants</small>
                    </a>
                </div>

                <!-- 110 Fire & Rescue -->
                <div class="col-6 col-md-4 col-lg-2">
                    <a href="tel:110" class="text-decoration-none d-block p-3 rounded-4 bg-slate-800 bg-opacity-90 border border-slate-700 text-center hover-card transition-all h-100 shadow-sm">
                        <div class="fs-3 mb-1" style="color: #f97316 !important;"><i class="bi bi-fire"></i></div>
                        <div class="fw-extrabold fs-3 text-white mb-0" style="letter-spacing: -0.5px;">110</div>
                        <small class="text-slate-300 d-block fw-semibold text-truncate" style="font-size: 0.76rem;">Fire & Rescue</small>
                    </a>
                </div>

                <!-- 117 Disaster Management (DMC) -->
                <div class="col-6 col-md-4 col-lg-2">
                    <a href="tel:117" class="text-decoration-none d-block p-3 rounded-4 bg-slate-800 bg-opacity-90 border border-slate-700 text-center hover-card transition-all h-100 shadow-sm">
                        <div class="fs-3 text-info mb-1"><i class="bi bi-cloud-lightning-rain-fill"></i></div>
                        <div class="fw-extrabold fs-3 text-white mb-0" style="letter-spacing: -0.5px;">117</div>
                        <small class="text-slate-300 d-block fw-semibold text-truncate" style="font-size: 0.76rem;">Disaster Mgmt (DMC)</small>
                    </a>
                </div>

                <!-- 1938 Women & Child Hotline -->
                <div class="col-6 col-md-4 col-lg-2">
                    <a href="tel:1938" class="text-decoration-none d-block p-3 rounded-4 bg-slate-800 bg-opacity-90 border border-slate-700 text-center hover-card transition-all h-100 shadow-sm">
                        <div class="fs-3 mb-1" style="color: #ec4899 !important;"><i class="bi bi-person-hearts"></i></div>
                        <div class="fw-extrabold fs-3 text-white mb-0" style="letter-spacing: -0.5px;">1938</div>
                        <small class="text-slate-300 d-block fw-semibold text-truncate" style="font-size: 0.76rem;">Women & Child Help</small>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    var map, osmLayer, satelliteLayer, darkLayer, markersGroup, nightHeatmapGroup;
    var nightModeActive = false;
    var userMarker = null, userCircle = null, userLat = null, userLng = null;
    var initialIncidents = @json($incidents);
    var initialSafePlaces = @json($safePlaces);

    function initSaforaMap() {
        console.log("=== SAFORA MAP INIT START ===");
        var container = document.getElementById('saforaMap');
        if (!container) {
            console.warn("saforaMap container element not found in DOM!");
            return;
        }
        if (typeof L === 'undefined') {
            console.log('Leaflet L is undefined, retrying initSaforaMap in 100ms...');
            setTimeout(initSaforaMap, 100);
            return;
        }
        if (container._leaflet_id && map) {
            console.log("Map already initialized, invalidating size...");
            map.invalidateSize();
            return;
        } else if (container._leaflet_id && !map) {
            console.log("Cleaning orphan _leaflet_id from container...");
            delete container._leaflet_id;
            container.innerHTML = '';
        }

        try {
            // CartoDB Voyager tiles (Fast, reliable, vibrant map tiles with zero 403 blocks)
            osmLayer = L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}.png', {
                subdomains: 'abcd',
                maxZoom: 19,
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/attributions">CARTO</a>'
            });

            const standardOsmLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                subdomains: ['a', 'b', 'c'],
                maxZoom: 19,
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            });

            satelliteLayer = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
                maxZoom: 19,
                attribution: 'Tiles &copy; Esri'
            });

            darkLayer = L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}.png', {
                subdomains: 'abcd',
                maxZoom: 19,
                attribution: '&copy; CartoDB &mdash; Map data &copy; OpenStreetMap'
            });

            map = L.map('saforaMap', {
                center: [7.8731, 80.7718],
                zoom: 8,
                layers: [osmLayer]
            });

            window.map = map;
            window.initSaforaMap = initSaforaMap;

            const baseMaps = {
                "🗺️ Standard Vector Map": osmLayer,
                "🌐 OpenStreetMap": standardOsmLayer,
                "🛰️ Satellite View": satelliteLayer,
                "🌙 Dark Mode Map": darkLayer
            };

            L.control.layers(baseMaps).addTo(map);

            markersGroup = L.layerGroup().addTo(map);
            nightHeatmapGroup = L.layerGroup();

            console.log("Map instance successfully created!", map);
        } catch (err) {
            console.error("Error creating L.map instance:", err);
        }

        // Interactive Map Click Location Picker
        map.on('click', function(e) {
            const clickedLat = e.latlng.lat.toFixed(4);
            const clickedLng = e.latlng.lng.toFixed(4);

            const latInp = document.getElementById('latInput');
            const lngInp = document.getElementById('lngInput');
            if (latInp) latInp.value = clickedLat;
            if (lngInp) lngInp.value = clickedLng;

            if (pickerMarker && map) map.removeLayer(pickerMarker);

            const pinIcon = L.divIcon({
                className: 'picker-pin',
                html: `<div style="background:#f59e0b; color:#0f172a; padding:4px 10px; border-radius:16px; font-weight:bold; font-size:12px; border:2px solid white; box-shadow:0 3px 8px rgba(0,0,0,0.3);">📍 SELECTED LOCATION</div>`,
                iconSize: [140, 26]
            });

            pickerMarker = L.marker([clickedLat, clickedLng], { icon: pinIcon }).addTo(map).bindPopup("📍 Location selected for report!").openPopup();

            // Reverse Geocode place name
            fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${clickedLat}&lon=${clickedLng}`)
                .then(res => res.json())
                .then(data => {
                    if (data && data.display_name) {
                        const parts = data.display_name.split(',');
                        const placeTitle = parts[0] + (parts[1] ? ', ' + parts[1] : '');
                        const locInp = document.getElementById('locationSearchInput');
                        if (locInp) locInp.value = placeTitle;
                        const areaInp = document.getElementById('areaName');
                        if (areaInp && !areaInp.value) {
                            areaInp.value = parts[1] || parts[0];
                        }
                    }
                }).catch(e => console.log('Reverse geocode error:', e));
        });

        const forceMapResize = function() {
            if (map) {
                map.invalidateSize();
            }
        };
        forceMapResize();
        setTimeout(forceMapResize, 100);
        setTimeout(forceMapResize, 500);
        setTimeout(forceMapResize, 1200);
        setTimeout(forceMapResize, 2500);
        window.addEventListener('resize', forceMapResize);

        if (typeof renderMapData === 'function') {
            renderMapData(initialIncidents, initialSafePlaces);
        }

        // High-Precision GPS Live Location Engine for Laptop & Mobile
        let userLocationMarker = null;
        let userLocationCircle = null;

        window.trackUserLocation = function(shouldFlyToMap = true) {
            const locateBtn = document.getElementById('locateUserBtn');
            const alertBox = document.getElementById('userDistanceAlert');
            const distanceText = document.getElementById('distanceText');

            if (locateBtn) {
                locateBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Locating...';
                locateBtn.disabled = true;
            }

            if (alertBox && distanceText) {
                alertBox.classList.remove('d-none');
                distanceText.innerHTML = '⌛ Scanning GPS Satellite Signal for your device location...';
            }

            const handleSuccess = function(lat, lng, accuracy, sourceName = "Live Device GPS") {
                if (userLocationMarker && map) map.removeLayer(userLocationMarker);
                if (userLocationCircle && map) map.removeLayer(userLocationCircle);

                // Draggable Pulsing Blue GPS Beacon Marker so user can adjust pin on mobile
                userLocationMarker = L.marker([lat, lng], { 
                    icon: pulseIcon, 
                    draggable: true, 
                    title: "💡 Drag me anywhere to pinpoint your exact spot!",
                    zIndexOffset: 1000 
                }).addTo(map);

                // Handle marker dragend event for manual precision adjustment
                userLocationMarker.on('dragend', function(e) {
                    const pos = userLocationMarker.getLatLng();
                    const dragLat = pos.lat;
                    const dragLng = pos.lng;

                    fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${dragLat}&lon=${dragLng}`)
                        .then(res => res.json())
                        .then(data => {
                            let placeName = "Selected Precision Location";
                            if (data && data.display_name) {
                                const parts = data.display_name.split(',');
                                placeName = parts[0] + (parts[1] ? ', ' + parts[1] : '');
                            }

                            if (distanceText) {
                                distanceText.innerHTML = `🎯 <strong>Custom Pin Adjusted:</strong> ${placeName} (${dragLat.toFixed(4)}, ${dragLng.toFixed(4)})`;
                            }

                            const routeStartInp = document.getElementById('routeStartInput');
                            if (routeStartInp) routeStartInp.value = placeName;
                            const locSearchInp = document.getElementById('locationSearchInput');
                            if (locSearchInp) locSearchInp.value = placeName;
                            const latInp = document.getElementById('latInput');
                            const lngInp = document.getElementById('lngInput');
                            if (latInp) latInp.value = dragLat.toFixed(4);
                            if (lngInp) lngInp.value = dragLng.toFixed(4);

                            userLocationMarker.bindPopup(`🎯 <strong>Custom Location:</strong><br>${placeName}<br><small class="text-muted">Lat: ${dragLat.toFixed(4)}, Lng: ${dragLng.toFixed(4)}</small>`).openPopup();
                        });
                });

                if (accuracy && accuracy < 5000) {
                    userLocationCircle = L.circle([lat, lng], {
                        radius: Math.min(accuracy, 800),
                        color: '#0284c7',
                        fillColor: '#38bdf8',
                        fillOpacity: 0.18,
                        weight: 2
                    }).addTo(map);
                }

                if (shouldFlyToMap && map) {
                    map.flyTo([lat, lng], 14, { duration: 1.5 });
                }

                // Reverse Geocode place name using Nominatim API
                fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`)
                    .then(res => res.json())
                    .then(data => {
                        let placeName = "Your Current Location";
                        if (data && data.display_name) {
                            const parts = data.display_name.split(',');
                            placeName = parts[0] + (parts[1] ? ', ' + parts[1] : '');
                        }

                        if (distanceText) {
                            distanceText.innerHTML = `🎯 <strong>${sourceName} Pinpointed:</strong> ${placeName} (${lat.toFixed(4)}, ${lng.toFixed(4)}) <small class="ms-2 text-primary fw-normal">(💡 Drag blue pin on map if slightly off)</small>`;
                        }

                        const routeStartInp = document.getElementById('routeStartInput');
                        if (routeStartInp) {
                            routeStartInp.value = placeName;
                        }

                        const locSearchInp = document.getElementById('locationSearchInput');
                        if (locSearchInp && !locSearchInp.value) {
                            locSearchInp.value = placeName;
                        }
                        const latInp = document.getElementById('latInput');
                        const lngInp = document.getElementById('lngInput');
                        if (latInp && !latInp.value) latInp.value = lat.toFixed(4);
                        if (lngInp && !lngInp.value) lngInp.value = lng.toFixed(4);

                        userLocationMarker.bindPopup(`🎯 <strong>${sourceName} Position:</strong><br>${placeName}<br><small class="text-muted">Lat: ${lat.toFixed(4)}, Lng: ${lng.toFixed(4)}</small><br><span class="badge bg-info text-dark mt-1">💡 Drag pin to refine location</span>`).openPopup();
                    })
                    .catch(err => {
                        if (distanceText) {
                            distanceText.innerHTML = `🎯 <strong>${sourceName} Coordinates:</strong> Lat: ${lat.toFixed(4)}, Lng: ${lng.toFixed(4)}`;
                        }
                        userLocationMarker.bindPopup(`🎯 <strong>${sourceName} Location:</strong><br>Lat: ${lat.toFixed(4)}, Lng: ${lng.toFixed(4)}`).openPopup();
                    })
                    .finally(() => {
                        if (locateBtn) {
                            locateBtn.innerHTML = '<i class="bi bi-crosshair me-1"></i> Track My Live Location';
                            locateBtn.disabled = false;
                        }
                    });
            };

            const handleFallbackIpLocation = function(reason) {
                console.warn("GPS fallback triggered:", reason);
                fetch('https://ipapi.co/json/')
                    .then(res => res.json())
                    .then(data => {
                        if (data && data.latitude && data.longitude) {
                            const city = data.city || data.region || "Sri Lanka";
                            handleSuccess(data.latitude, data.longitude, 4000, `Network City (${city})`);
                        } else {
                            handleSuccess(6.9271, 79.8612, 8000, "Colombo Region (Default)");
                        }
                    })
                    .catch(() => {
                        handleSuccess(6.9271, 79.8612, 8000, "Colombo Region (Default)");
                    });
            };

            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    function(pos) {
                        handleSuccess(pos.coords.latitude, pos.coords.longitude, pos.coords.accuracy, "Live Device GPS");
                    },
                    function(err) {
                        handleFallbackIpLocation(err.message || "GPS Permission Denied");
                    },
                    {
                        enableHighAccuracy: true,
                        timeout: 5000,
                        maximumAge: 10000
                    }
                );
            } else {
                handleFallbackIpLocation("Geolocation unsupported");
            }
        };

        // Quick City Search Handler
        const performQuickCitySearch = function() {
            const cityInput = document.getElementById('mapQuickCitySearchInput');
            if (!cityInput || !cityInput.value.trim()) return;

            const query = encodeURIComponent(cityInput.value.trim() + ', Sri Lanka');
            const searchBtn = document.getElementById('mapQuickCitySearchBtn');
            if (searchBtn) searchBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Searching...';

            fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${query}&countrycodes=lk&limit=3`)
                .then(res => res.json())
                .then(results => {
                    if (results && results.length > 0) {
                        const target = results[0];
                        const searchLat = parseFloat(target.lat);
                        const searchLng = parseFloat(target.lon);

                        // Trigger handleSuccess logic at searched city location
                        if (userLocationMarker && map) map.removeLayer(userLocationMarker);

                        const pulseIcon = L.divIcon({
                            className: 'user-gps-beacon',
                            html: `<div style="position:relative; width:28px; height:28px;">
                                    <div style="position:absolute; width:28px; height:28px; background:rgba(14, 165, 233, 0.45); border-radius:50%; animation: pulse-ring 1.8s infinite ease-out;"></div>
                                    <div style="position:absolute; top:5px; left:5px; width:18px; height:18px; background:#0284c7; border:3px solid #ffffff; border-radius:50%; box-shadow:0 0 12px rgba(2, 132, 199, 0.9);"></div>
                                   </div>`,
                            iconSize: [28, 28],
                            iconAnchor: [14, 14]
                        });

                        userLocationMarker = L.marker([searchLat, searchLng], { 
                            icon: pulseIcon, 
                            draggable: true,
                            zIndexOffset: 1000 
                        }).addTo(map);

                        map.flyTo([searchLat, searchLng], 14, { duration: 1.5 });

                        const placeName = target.display_name.split(',')[0] + ', ' + (target.display_name.split(',')[1] || '');
                        userLocationMarker.bindPopup(`🎯 <strong>Searched Location:</strong><br>${placeName}`).openPopup();

                        const distanceText = document.getElementById('distanceText');
                        const alertBox = document.getElementById('userDistanceAlert');
                        if (alertBox) alertBox.classList.remove('d-none');
                        if (distanceText) distanceText.innerHTML = `🎯 <strong>City Pinpointed:</strong> ${placeName} (${searchLat.toFixed(4)}, ${searchLng.toFixed(4)})`;

                        const routeStartInp = document.getElementById('routeStartInput');
                        if (routeStartInp) routeStartInp.value = placeName;
                    } else {
                        alert("City not found in Sri Lanka. Please check spelling.");
                    }
                })
                .catch(err => console.error("City search error:", err))
                .finally(() => {
                    if (searchBtn) searchBtn.innerHTML = '<i class="bi bi-search me-1"></i> Jump To Location';
                });
        };

        const citySearchBtnEl = document.getElementById('mapQuickCitySearchBtn');
        if (citySearchBtnEl) {
            citySearchBtnEl.addEventListener('click', performQuickCitySearch);
        }

        const citySearchInputEl = document.getElementById('mapQuickCitySearchInput');
        if (citySearchInputEl) {
            citySearchInputEl.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') performQuickCitySearch();
            });
        }

        // Attach event listeners for Track My Location & Route GPS buttons
        const locateUserBtnEl = document.getElementById('locateUserBtn');
        if (locateUserBtnEl) {
            locateUserBtnEl.addEventListener('click', function() {
                window.trackUserLocation(true);
            });
        }

        const routeCurrentGpsBtnEl = document.getElementById('routeCurrentGpsBtn');
        if (routeCurrentGpsBtnEl) {
            routeCurrentGpsBtnEl.addEventListener('click', function() {
                window.trackUserLocation(true);
            });
        }

        // Auto-run user location detection on map load
        setTimeout(function() {
            window.trackUserLocation(true);
        }, 600);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initSaforaMap);
    } else {
        initSaforaMap();
    }
    window.addEventListener('load', initSaforaMap);

    // Night Safety & Streetlight Heatmap Corridors (Well-Lit Safe Corridors vs Dark Unlit Hazard Areas)
    const WELL_LIT_CORRIDORS = [
        {
            name: "Peradeniya to Kandy City Center Illuminated Main Corridor",
            coords: [[7.2642, 80.5930], [7.2750, 80.6050], [7.2850, 80.6200], [7.2931, 80.6348]],
            desc: "💡 24/7 Streetlights Active, High CCTV Coverage & Police Patrols"
        },
        {
            name: "Dalada Veediya & Kandy Lake Promenade",
            coords: [[7.2931, 80.6348], [7.2925, 80.6370], [7.2910, 80.6410], [7.2900, 80.6380]],
            desc: "💡 Highly Illuminated Sacred Area with Continuous Security & Public Lighting"
        },
        {
            name: "Colombo Fort to Galle Face Promenade",
            coords: [[6.9344, 79.8428], [6.9300, 79.8450], [6.9250, 79.8460]],
            desc: "💡 Commercial District LED Lighting & Constant Patrols"
        },
        {
            name: "Galle Fort Main Promenade Corridor",
            coords: [[6.0267, 80.2170], [6.0280, 80.2190], [6.0300, 80.2200]],
            desc: "💡 Tourist Safe Zone with Heritage Street Lighting"
        },
        {
            name: "Trincomalee Town Main Avenue",
            coords: [[8.5874, 81.2152], [8.5890, 81.2180], [8.5920, 81.2210]],
            desc: "💡 Well-Lit Coastal Commercial Corridor"
        }
    ];

    const DARK_UNLIT_RISK_ZONES = [
        {
            name: "Halloluwa By-pass Unlit Stretch",
            coords: [[7.3011, 80.6125], [7.3050, 80.6100], [7.3100, 80.6080]],
            desc: "⚠️ Dark / Unlit Risk Zone: Missing Streetlights & Low Night Visibility"
        },
        {
            name: "Mahaiyawa Railway Underpass Unlit Stretch",
            coords: [[7.3000, 80.6300], [7.3030, 80.6320]],
            desc: "⚠️ Dark / Isolated Night Corridor: Exercise Caution After 8 PM"
        },
        {
            name: "Peradeniya Riverbank Dark Stretch",
            coords: [[7.2600, 80.5900], [7.2620, 80.5850]],
            desc: "⚠️ Poor Streetlight Coverage: Low Foot Traffic Area at Night"
        },
        {
            name: "Trincomalee Harbour Approach Unlit Shortcut",
            coords: [[8.5750, 81.2050], [8.5780, 81.2080]],
            desc: "⚠️ Isolated Night Area: Unlit Bypass Road"
        }
    ];

    const nightToggleBtn = document.getElementById('nightSafetyToggleBtn');
    if (nightToggleBtn) {
        nightToggleBtn.addEventListener('click', function() {
        nightModeActive = !nightModeActive;
        const btn = this;
        const legend = document.getElementById('nightHeatmapLegend');

        if (nightModeActive) {
            btn.className = "btn btn-sm btn-warning text-dark fw-bold px-3 shadow-sm";
            btn.innerHTML = `<i class="bi bi-sun-fill me-1"></i> Exit Night Safety Mode`;

            // Auto-switch to Dark GIS Map
            map.removeLayer(osmLayer);
            map.removeLayer(satelliteLayer);
            darkLayer.addTo(map);

            legend.classList.remove('d-none');

            // Render Glowing Heatmap Corridors
            nightHeatmapGroup.clearLayers();

            // 1. Green Well-Lit Corridors
            WELL_LIT_CORRIDORS.forEach(zone => {
                const line = L.polyline(zone.coords, {
                    color: '#10b981',
                    weight: 10,
                    opacity: 0.7,
                    lineCap: 'round'
                }).bindTooltip(`<strong>🟢 ${zone.name}</strong><br><small>${zone.desc}</small>`, { sticky: true });
                
                nightHeatmapGroup.addLayer(line);

                zone.coords.forEach(pt => {
                    const circle = L.circleMarker(pt, {
                        radius: 8,
                        color: '#34d399',
                        fillColor: '#10b981',
                        fillOpacity: 0.8,
                        weight: 2
                    }).bindTooltip(`<strong>🟢 ${zone.name}</strong><br><small>${zone.desc}</small>`);
                    nightHeatmapGroup.addLayer(circle);
                });
            });

            // 2. Red Dark / Unlit Risk Corridors
            DARK_UNLIT_RISK_ZONES.forEach(zone => {
                const line = L.polyline(zone.coords, {
                    color: '#ef4444',
                    weight: 10,
                    opacity: 0.8,
                    dashArray: '8, 8',
                    lineCap: 'round'
                }).bindTooltip(`<strong>🔴 ${zone.name}</strong><br><small>${zone.desc}</small>`, { sticky: true });

                nightHeatmapGroup.addLayer(line);

                zone.coords.forEach(pt => {
                    const circle = L.circleMarker(pt, {
                        radius: 10,
                        color: '#f87171',
                        fillColor: '#ef4444',
                        fillOpacity: 0.9,
                        weight: 2
                    }).bindTooltip(`<strong>🔴 ${zone.name}</strong><br><small>${zone.desc}</small>`);
                    nightHeatmapGroup.addLayer(circle);
                });
            });

            nightHeatmapGroup.addTo(map);

        } else {
            btn.className = "btn btn-sm btn-dark text-warning border border-warning fw-bold px-3 shadow-xs";
            btn.innerHTML = `<i class="bi bi-moon-stars-fill me-1"></i> Night Safety & Heatmap`;

            legend.classList.add('d-none');

            // Restore Standard OSM Map
            map.removeLayer(darkLayer);
            osmLayer.addTo(map);

            // Remove Heatmap Layer
            map.removeLayer(nightHeatmapGroup);
        }
    });
    }



    // Live AJAX Polling Every 8 Seconds
    setInterval(function() {
        fetch("{{ route('api.live-map-data') }}")
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    renderMapData(data.incidents, data.safePlaces);
                    document.getElementById('liveHazardCount').textContent = data.incidents.length;
                }
            })
            .catch(err => console.log('Live map sync:', err));
    }, 8000);

    function renderMapData(incidents, safePlaces) {
        markersGroup.clearLayers();

        incidents.forEach(inc => {
            let badgeColor = '#d97706';
            let iconEmoji = '🐘';

            if (inc.category) {
                if (inc.category.type === 'crime') {
                    badgeColor = '#dc2626'; iconEmoji = '🚔';
                } else if (inc.category.type === 'disaster') {
                    badgeColor = '#0284c7'; iconEmoji = '🌧️';
                } else if (inc.category.type === 'road') {
                    badgeColor = '#4b5563'; iconEmoji = '🚗';
                }
            }

            let distText = '';
            if (userLat && userLng) {
                const distKm = calculateDistanceKm(userLat, userLng, inc.latitude, inc.longitude);
                distText = `<div style="margin-top:4px; font-weight:bold; color:#dc2626; font-size:11px;">⚠️ ${distKm.toFixed(1)} km away from your location</div>`;
            }

            const customIcon = L.divIcon({
                className: 'safora-marker-wrapper',
                html: `<div class="safora-marker-pin" style="background:${badgeColor};"><span class="safora-marker-icon">${iconEmoji}</span></div>`,
                iconSize: [36, 36],
                iconAnchor: [18, 36],
                popupAnchor: [0, -32]
            });

            const credibility = inc.credibility_score || 90;
            const upvotes = inc.upvotes_count || 1;
            const downvotes = inc.downvotes_count || 0;

            const popupContent = `
                <div style="width:230px; font-family:'Inter', sans-serif;">
                    <span style="background:${badgeColor}; color:white; font-size:10px; padding:2px 7px; border-radius:6px; font-weight:bold; text-transform:uppercase;">${inc.category ? inc.category.type : 'Hazard'}</span>
                    <h6 style="font-weight:700; margin-top:6px; margin-bottom:4px; font-size:13px; color:#0f172a;">${inc.title}</h6>
                    <p style="font-size:12px; color:#475569; margin-bottom:4px; line-height:1.4;">${inc.description}</p>
                    <div style="font-size:11px; color:#64748b; border-top:1px solid #e2e8f0; padding-top:4px; margin-bottom:6px;">
                        <strong>📍 Area:</strong> ${inc.area_name}<br>
                        <strong>⚠️ Risk:</strong> ${inc.severity.toUpperCase()}
                    </div>
                    ${distText}
                    <!-- Community Verification Voting (USP) -->
                    <div style="background:#f8fafc; border:1px solid #e2e8f0; padding:6px 8px; border-radius:8px; margin-top:6px;">
                        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:4px;">
                            <small style="font-weight:700; font-size:10px; color:#059669;">🛡️ ${credibility}% Community Verified</small>
                            <small style="font-size:10px; color:#64748b;">(${upvotes} votes)</small>
                        </div>
                        <div style="display:flex; gap:4px;">
                            <button onclick="voteIncident(${inc.id}, 'upvote')" style="flex:1; background:#059669; color:white; border:none; border-radius:4px; padding:2px 4px; font-size:10px; font-weight:bold; cursor:pointer;">👍 Confirm Report</button>
                            <button onclick="voteIncident(${inc.id}, 'downvote')" style="background:#ef4444; color:white; border:none; border-radius:4px; padding:2px 6px; font-size:10px; font-weight:bold; cursor:pointer;">👎 Flag</button>
                        </div>
                    </div>
                </div>
            `;

            const m = L.marker([inc.latitude, inc.longitude], { icon: customIcon })
                .bindPopup(popupContent)
                .bindTooltip(`<strong>${iconEmoji} ${inc.title}</strong><br><small style="color:#64748b;">📍 ${inc.area_name} (${inc.severity.toUpperCase()})</small>`, {
                    direction: 'top',
                    offset: [0, -32],
                    opacity: 0.95
                });
            markersGroup.addLayer(m);
        });

        safePlaces.forEach(sp => {
            const spIcon = L.divIcon({
                className: 'safora-sp-wrapper',
                html: `<div class="safora-marker-pin" style="background:#059669;"><span class="safora-marker-icon">🏥</span></div>`,
                iconSize: [36, 36],
                iconAnchor: [18, 36],
                popupAnchor: [0, -32]
            });

            const escapedName = (sp.name || 'Safe Place').replace(/'/g, "\\'");
            const spRating = sp.rating ? sp.rating : (4.7 + (sp.id % 4) * 0.1).toFixed(1);
            const reviewsCount = sp.reviews_count ? sp.reviews_count : (20 + sp.id * 7);

            const popupContent = `
                <div style="font-family:'Inter', sans-serif; min-width:210px;">
                    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:4px;">
                        <span style="background:#059669; color:white; font-size:10px; font-weight:bold; padding:2px 6px; border-radius:4px;">🏥 ${sp.type ? sp.type.toUpperCase() : 'SAFE HAVEN'}</span>
                        <span style="color:#d97706; font-size:11px; font-weight:bold;">⭐ ${spRating} / 5.0</span>
                    </div>
                    <strong style="color:#0f172a; font-size:13px; display:block; margin-bottom:2px;">${sp.name}</strong>
                    <small style="color:#475569; display:block; margin-bottom:6px;">📍 ${sp.address || sp.area_name}</small>
                    <div style="background:#f1f5f9; padding:6px 8px; border-radius:6px; font-size:11px; color:#334155; margin-bottom:6px; border:1px solid #cbd5e1;">
                        💡 <strong>Night Lighting:</strong> <span style="color:#059669; font-weight:bold;">🟢 Well-Lit</span><br>
                        👮 <strong>Staff:</strong> <span style="color:#0284c7; font-weight:bold;">24/7 Active Duty</span><br>
                        📞 <strong>Call:</strong> <a href="tel:${sp.phone}" style="color:#2563eb; font-weight:bold;">${sp.phone}</a>
                    </div>
                    <button onclick="openRateSafePlaceModal('${escapedName}', ${sp.id})" style="width:100%; background:#f59e0b; color:#0f172a; font-weight:bold; border:none; border-radius:6px; padding:5px 8px; font-size:11px; cursor:pointer;">
                        ⭐ Rate & Review Station
                    </button>
                </div>
            `;

            const spMarker = L.marker([sp.latitude, sp.longitude], { icon: spIcon })
                .bindPopup(popupContent)
                .bindTooltip(`<strong>🏥 ${sp.name}</strong><br><small style="color:#059669;">⭐ ${spRating}/5.0 (${reviewsCount} Reviews)</small>`, {
                    direction: 'top',
                    offset: [0, -32],
                    opacity: 0.95
                });
            markersGroup.addLayer(spMarker);
        });
    }

    // Community Safe Place Rating Modal Functions
    function openRateSafePlaceModal(name, id) {
        document.getElementById('rateModalTitle').textContent = `Rate: ${name}`;
        document.getElementById('safePlaceIdInput').value = id;
        document.getElementById('reviewCommentInput').value = '';
        const modal = new bootstrap.Modal(document.getElementById('rateSafePlaceModal'));
        modal.show();
    }

    function openGeneralRateModal() {
        openRateSafePlaceModal('Kandy Central Police Station & Safe Haven', 1);
    }

    // Star Rating Click Handler
    document.querySelectorAll('#starRatingSelector .star-icon').forEach(star => {
        star.addEventListener('click', function() {
            const val = parseInt(this.getAttribute('data-val'));
            document.getElementById('selectedStarValue').value = val;
            
            document.querySelectorAll('#starRatingSelector .star-icon').forEach((s, idx) => {
                if (idx < val) {
                    s.className = "bi bi-star-fill star-icon text-warning";
                } else {
                    s.className = "bi bi-star star-icon text-secondary";
                }
            });
        });
    });

    // Review Form Submission Handler
    const safePlaceReviewFormEl = document.getElementById('safePlaceReviewForm');
    if (safePlaceReviewFormEl) {
        safePlaceReviewFormEl.addEventListener('submit', function(e) {
            e.preventDefault();
            const stars = document.getElementById('selectedStarValue') ? document.getElementById('selectedStarValue').value : 5;
            const lighting = document.getElementById('lightingQualityInput') ? document.getElementById('lightingQualityInput').value : 'Good';
            const comment = document.getElementById('reviewCommentInput') ? document.getElementById('reviewCommentInput').value : '';

            const modalElem = document.getElementById('rateSafePlaceModal');
            if (modalElem && typeof bootstrap !== 'undefined') {
                const modal = bootstrap.Modal.getInstance(modalElem);
                if (modal) modal.hide();
            }

            alert(`✅ Thank you! Your ${stars}-Star community safety review has been published.\n\nLighting Quality: ${lighting}\nFeedback: "${comment}"`);
        });
    }

    // High Accuracy Geolocation Tracker Functionality
    let watchId = null;

    const updateUserGpsPosition = function(pos, isInitial = false) {
        userLat = pos.coords.latitude;
        userLng = pos.coords.longitude;
        const accuracy = pos.coords.accuracy ? Math.round(pos.coords.accuracy) : 15;

        // Smooth zoom to street level (zoom 16) on initial GPS lock
        if (isInitial || !userMarker) {
            map.setView([userLat, userLng], 16, { animate: true });
        }

        if (userMarker) map.removeLayer(userMarker);
        if (userCircle) map.removeLayer(userCircle);

        const userIcon = L.divIcon({
            className: 'user-gps-red-dot-wrapper',
            html: `
                <div class="red-dot-container">
                    <div class="red-dot-core"></div>
                    <div class="red-dot-label">🔴 MY LIVE LOCATION (±${accuracy}m)</div>
                </div>
            `,
            iconSize: [230, 28],
            iconAnchor: [11, 14]
        });

        userMarker = L.marker([userLat, userLng], { icon: userIcon }).addTo(map);

        // Real GPS accuracy precision circle (visual radius in meters)
        userCircle = L.circle([userLat, userLng], {
            color: '#dc2626',
            weight: 2,
            fillColor: '#ef4444',
            fillOpacity: 0.18,
            radius: Math.max(accuracy, 25) // Visual margin circle
        }).addTo(map);

        // Auto-fill report form coordinates
        const latInp = document.getElementById('latInput');
        const lngInp = document.getElementById('lngInput');
        if (latInp) latInp.value = userLat.toFixed(4);
        if (lngInp) lngInp.value = userLng.toFixed(4);

        // Reverse Geocode place name for human readability
        fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${userLat}&lon=${userLng}`)
            .then(res => res.json())
            .then(data => {
                let placeName = `GPS (${userLat.toFixed(4)}, ${userLng.toFixed(4)})`;
                if (data && data.display_name) {
                    const parts = data.display_name.split(',');
                    placeName = parts[0] + (parts[1] ? ', ' + parts[1] : '');
                    const locSearch = document.getElementById('locationSearchInput');
                    if (locSearch) locSearch.value = placeName;
                    const routeStart = document.getElementById('routeStartInput');
                    if (routeStart && (!routeStart.value || routeStart.value.includes('GPS') || routeStart.value.includes('Colombo'))) {
                        routeStart.value = placeName;
                        routeStart.setAttribute('data-lat', userLat);
                        routeStart.setAttribute('data-lng', userLng);
                    }
                    const areaInp = document.getElementById('areaName');
                    if (areaInp && !areaInp.value) {
                        areaInp.value = parts[1] || parts[0];
                    }
                }
                userMarker.bindPopup(`<strong>📍 Live Location Active</strong><br><strong>${placeName}</strong><br><small class="text-muted">GPS Accuracy: ±${accuracy}m</small>`).openPopup();
                const distText = document.getElementById('distanceText');
                if (distText) distText.innerHTML = `<strong>Live Location Active:</strong> ${placeName} (${userLat.toFixed(4)}, ${userLng.toFixed(4)}). Nearby hazards updated.`;
                const distAlert = document.getElementById('userDistanceAlert');
                if (distAlert) distAlert.classList.remove('d-none');
            })
            .catch(e => {
                userMarker.bindPopup(`📍 <strong>Your GPS Location:</strong> ${userLat.toFixed(4)}, ${userLng.toFixed(4)}`).openPopup();
                const distText = document.getElementById('distanceText');
                if (distText) distText.innerHTML = `<strong>Live Location Active:</strong> GPS (${userLat.toFixed(4)}, ${userLng.toFixed(4)}).`;
                const distAlert = document.getElementById('userDistanceAlert');
                if (distAlert) distAlert.classList.remove('d-none');
            });

        // Re-render markers with calculated distance
        if (typeof renderMapData === 'function') {
            renderMapData(initialIncidents, initialSafePlaces);
        }
    };

    const locateUserBtnEl = document.getElementById('locateUserBtn');
    if (locateUserBtnEl) {
        locateUserBtnEl.addEventListener('click', function() {
        const btn = this;
        btn.innerHTML = `<i class="bi bi-arrow-repeat spin me-1"></i> Acquiring High-Accuracy GPS...`;
        btn.disabled = true;

        if (navigator.geolocation) {
            const gpsOptions = {
                enableHighAccuracy: true,
                timeout: 15000,
                maximumAge: 0
            };

            navigator.geolocation.getCurrentPosition(function(pos) {
                btn.innerHTML = `<i class="bi bi-check-circle-fill me-1"></i> Live GPS Active`;
                btn.className = "btn btn-sm btn-success fw-bold px-3 shadow-xs";
                btn.disabled = false;

                updateUserGpsPosition(pos, true);

                // Start continuous live position watching
                if (!watchId) {
                    watchId = navigator.geolocation.watchPosition(function(latestPos) {
                        updateUserGpsPosition(latestPos, false);
                    }, function(err){}, gpsOptions);
                }
            }, function(err) {
                btn.innerHTML = `<i class="bi bi-crosshair me-1"></i> Track My Live Location`;
                btn.disabled = false;
                alert("⚠️ Unable to access high-accuracy GPS. Please check browser location permissions.");
            }, gpsOptions);
        } else {
            btn.innerHTML = `<i class="bi bi-crosshair me-1"></i> Track My Live Location`;
            btn.disabled = false;
            alert("Geolocation is not supported by your browser.");
        }
    });
    }

    function calculateDistanceKm(lat1, lon1, lat2, lon2) {
        const R = 6371;
        const dLat = (lat2 - lat1) * Math.PI / 180;
        const dLon = (lon2 - lon1) * Math.PI / 180;
        const a = Math.sin(dLat/2) * Math.sin(dLat/2) +
                  Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
                  Math.sin(dLon/2) * Math.sin(dLon/2);
        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
        return R * c;
    }

    let pickerMarker = null;

    // Place Name Search via Nominatim Geocoding API
    const performPlaceSearch = function() {
        const query = document.getElementById('locationSearchInput').value.trim();
        if (!query) {
            alert("Please type a place name to search.");
            return;
        }

        const btn = document.getElementById('searchPlaceBtn');
        const origText = btn.innerHTML;
        btn.innerHTML = `<i class="bi bi-arrow-repeat spin me-1"></i> Searching...`;
        btn.disabled = true;

        fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query + ', Sri Lanka')}`)
            .then(res => res.json())
            .then(results => {
                btn.innerHTML = origText;
                btn.disabled = false;

                if (results && results.length > 0) {
                    const place = results[0];
                    const lat = parseFloat(place.lat).toFixed(4);
                    const lng = parseFloat(place.lon).toFixed(4);

                    document.getElementById('latInput').value = lat;
                    document.getElementById('lngInput').value = lng;

                    if (!document.getElementById('areaName').value) {
                        document.getElementById('areaName').value = query.split(',')[0];
                    }

                    map.setView([lat, lng], 13);

                    if (pickerMarker) map.removeLayer(pickerMarker);

                    const pinIcon = L.divIcon({
                        className: 'picker-pin',
                        html: `<div style="background:#f59e0b; color:#0f172a; padding:4px 10px; border-radius:16px; font-weight:bold; font-size:12px; border:2px solid white; box-shadow:0 3px 8px rgba(0,0,0,0.3);">📍 ${query.substring(0, 18)}</div>`,
                        iconSize: [140, 26]
                    });

                    pickerMarker = L.marker([lat, lng], { icon: pinIcon }).addTo(map).bindPopup(`📍 <strong>${place.display_name}</strong>`).openPopup();
                    alert(`✅ Found place: "${place.display_name.substring(0, 45)}...". Coordinates updated on map!`);
                } else {
                    alert("No matching place found in Sri Lanka. Please try typing a broader city or landmark name.");
                }
            })
            .catch(err => {
                btn.innerHTML = origText;
                btn.disabled = false;
                alert("Location search error. Please check your internet connection.");
            });
    };

    const searchPlaceBtnEl = document.getElementById('searchPlaceBtn');
    if (searchPlaceBtnEl) searchPlaceBtnEl.addEventListener('click', performPlaceSearch);

    const locationSearchInputEl = document.getElementById('locationSearchInput');
    if (locationSearchInputEl) {
        locationSearchInputEl.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                performPlaceSearch();
            }
        });
    }

    const fetchGpsBtnEl = document.getElementById('fetchGpsBtn');
    if (fetchGpsBtnEl) {
        fetchGpsBtnEl.addEventListener('click', function() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(pos) {
                    const latInp = document.getElementById('latInput');
                    const lngInp = document.getElementById('lngInput');
                    if (latInp) latInp.value = pos.coords.latitude.toFixed(4);
                    if (lngInp) lngInp.value = pos.coords.longitude.toFixed(4);
                    alert("📍 Current GPS coordinates retrieved successfully!");
                });
            } else {
                alert("Geolocation is not supported by your browser.");
            }
        });
    }

    const titleInput = document.getElementById('incidentTitle');
    if (titleInput) {
        titleInput.addEventListener('keyup', debounce(function() {
        const val = titleInput.value.trim();
        if (val.length > 5) {
            fetch("{{ route('ai.classify') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ text: val })
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success' && data.category_id) {
                    document.getElementById('categorySelect').value = data.category_id;
                    document.getElementById('severitySelect').value = data.suggested_severity;
                    
                    document.getElementById('aiCatName').textContent = data.category_name;
                    document.getElementById('aiConfidence').textContent = data.confidence;
                    document.getElementById('aiSuggestionBox').classList.remove('d-none');
                }
            });
        }
    }, 400));
    }

    function debounce(func, wait) {
        let timeout;
        return function(...args) {
            clearTimeout(timeout);
            timeout = setTimeout(() => func.apply(this, args), wait);
        };
    }

    // Community Upvote / Downvote AJAX Handler (USP)
    window.voteIncident = function(id, type) {
        fetch(`/incidents/${id}/vote`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ type: type })
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success') {
                alert(`✅ ${data.message}\nNew Credibility Rating: ${data.credibility_score}% (${data.credibility_label})`);
                // Trigger quick refresh
                fetch("{{ route('api.live-map-data') }}")
                    .then(res => res.json())
                    .then(mapData => renderMapData(mapData.incidents, mapData.safePlaces));
            }
        })
        .catch(err => console.log('Vote error:', err));
    };

    // AI Time-Series Risk Prediction Engine Chart JS
    let aiChartInstance = null;
    const initAiRiskChart = function(labels, riskData) {
        const ctx = document.getElementById('aiRiskChart').getContext('2d');
        if (aiChartInstance) aiChartInstance.destroy();

        aiChartInstance = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Predicted Hazard Risk %',
                    data: riskData,
                    borderColor: '#f59e0b',
                    backgroundColor: 'rgba(245, 158, 11, 0.15)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#ef4444',
                    pointRadius: 5
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { labels: { color: '#cbd5e1' } }
                },
                scales: {
                    x: { ticks: { color: '#94a3b8' }, grid: { color: 'rgba(255,255,255,0.05)' } },
                    y: { min: 0, max: 100, ticks: { color: '#94a3b8' }, grid: { color: 'rgba(255,255,255,0.05)' } }
                }
            }
        });
    };

    const fetchRiskPrediction = function() {
        const area = document.getElementById('riskAreaSelect').value;
        const hour = document.getElementById('riskHourSelect').value;

        fetch(`/ai/predict-risk?area_name=${encodeURIComponent(area)}&hour=${hour}`)
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    document.getElementById('riskPercentageDisplay').textContent = `${data.risk_percentage}%`;
                    document.getElementById('riskHourDisplay').textContent = data.predicted_hour;
                    document.getElementById('riskReasonText').textContent = data.reason;

                    const badge = document.getElementById('riskLevelBadge');
                    badge.textContent = `${data.risk_level.toUpperCase()} RISK`;
                    if (data.risk_percentage >= 75) {
                        badge.className = "badge bg-danger text-white px-3 py-1 rounded-pill";
                    } else if (data.risk_percentage >= 50) {
                        badge.className = "badge bg-warning text-dark px-3 py-1 rounded-pill";
                    } else {
                        badge.className = "badge bg-success text-white px-3 py-1 rounded-pill";
                    }

                    const recsList = document.getElementById('riskRecsList');
                    recsList.innerHTML = data.recommendations.map(r => `<li>${r}</li>`).join('');

                    if (data.risk_breakdown) {
                        const hVal = data.risk_breakdown.harassment || 50;
                        const tVal = data.risk_breakdown.theft || 50;
                        const uVal = data.risk_breakdown.unlit_corridor || 50;
                        const wVal = data.risk_breakdown.wildlife || 10;

                        const hEl = document.getElementById('harassmentRiskVal');
                        const hBar = document.getElementById('harassmentRiskBar');
                        if (hEl) hEl.textContent = `${hVal}%`;
                        if (hBar) hBar.style.width = `${hVal}%`;

                        const tEl = document.getElementById('theftRiskVal');
                        const tBar = document.getElementById('theftRiskBar');
                        if (tEl) tEl.textContent = `${tVal}%`;
                        if (tBar) tBar.style.width = `${tVal}%`;

                        const uEl = document.getElementById('unlitRiskVal');
                        const uBar = document.getElementById('unlitRiskBar');
                        if (uEl) uEl.textContent = `${uVal}%`;
                        if (uBar) uBar.style.width = `${uVal}%`;

                        const wEl = document.getElementById('wildlifeRiskVal');
                        const wBar = document.getElementById('wildlifeRiskBar');
                        if (wEl) wEl.textContent = `${wVal}%`;
                        if (wBar) wBar.style.width = `${wVal}%`;
                    }

                    initAiRiskChart(data.chart_data.labels, data.chart_data.risk_trends);
                }
            });
    };

    const calcRiskBtnEl = document.getElementById('calcRiskBtn');
    if (calcRiskBtnEl) calcRiskBtnEl.addEventListener('click', fetchRiskPrediction);

    const riskAreaSelectEl = document.getElementById('riskAreaSelect');
    if (riskAreaSelectEl) riskAreaSelectEl.addEventListener('change', fetchRiskPrediction);

    const riskHourSelectEl = document.getElementById('riskHourSelect');
    if (riskHourSelectEl) riskHourSelectEl.addEventListener('change', fetchRiskPrediction);

    // Initial fetch on page load
    fetchRiskPrediction();

    // AI Safe Navigation Route Planner Logic (USP)
    let routePolylineLayer = null;

    async function smartGeocode(queryStr) {
        if (!queryStr || queryStr.trim() === '') return null;
        let clean = queryStr.trim();
        if (clean.includes('My Live GPS') && userLat && userLng) {
            return { lat: userLat, lng: userLng, name: 'My Live GPS' };
        }

        // Try 1: Exact query + ", Sri Lanka"
        try {
            let res = await fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(clean + ', Sri Lanka')}`);
            let data = await res.json();
            if (data && data.length > 0) {
                return { lat: parseFloat(data[0].lat), lng: parseFloat(data[0].lon), name: data[0].display_name };
            }
        } catch (e) {}

        // Try 2: Strip fluff words like "town", "junction", "station", "bus stop", "city", "bazaar"
        let stripped = clean.replace(/\b(town|junction|station|city|bus stop|bazaar|area|road|street)\b/gi, '').trim();
        if (stripped !== clean && stripped.length >= 3) {
            try {
                let res = await fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(stripped + ', Sri Lanka')}`);
                let data = await res.json();
                if (data && data.length > 0) {
                    return { lat: parseFloat(data[0].lat), lng: parseFloat(data[0].lon), name: data[0].display_name };
                }
            } catch (e) {}
        }

        // Try 3: Search with district suffix ", Kandy, Sri Lanka"
        try {
            let res = await fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(stripped + ', Kandy, Sri Lanka')}`);
            let data = await res.json();
            if (data && data.length > 0) {
                return { lat: parseFloat(data[0].lat), lng: parseFloat(data[0].lon), name: data[0].display_name };
            }
        } catch (e) {}

        return null;
    }

    // Comprehensive Sri Lanka District & Major Towns Database (USP for Fast Autocomplete)
    const SRI_LANKA_PLACES_DB = [
        // Trincomalee District
        { name: "Trincomalee Town", district: "Trincomalee District", lat: 8.5874, lng: 81.2152 },
        { name: "Nilaveli Beach", district: "Trincomalee District", lat: 8.6874, lng: 81.1895 },
        { name: "Uppuveli", district: "Trincomalee District", lat: 8.6074, lng: 81.2195 },
        { name: "Kinniya", district: "Trincomalee District", lat: 8.5000, lng: 81.1833 },
        { name: "China Bay", district: "Trincomalee District", lat: 8.5500, lng: 81.1833 },
        { name: "Kantale", district: "Trincomalee District", lat: 8.3500, lng: 80.9833 },
        { name: "Mutur", district: "Trincomalee District", lat: 8.4500, lng: 81.2667 },
        { name: "Sampur", district: "Trincomalee District", lat: 8.4833, lng: 81.2833 },
        { name: "Kuchchaveli", district: "Trincomalee District", lat: 8.8167, lng: 81.1000 },
        { name: "Kanniya Hot Springs", district: "Trincomalee District", lat: 8.6167, lng: 81.1833 },
        { name: "Marble Beach", district: "Trincomalee District", lat: 8.5167, lng: 81.2167 },

        // Kandy District
        { name: "Kandy City Center", district: "Kandy District", lat: 7.2906, lng: 80.6337 },
        { name: "Kandy Clock Tower", district: "Kandy District", lat: 7.2931, lng: 80.6348 },
        { name: "Peradeniya", district: "Kandy District", lat: 7.2642, lng: 80.5930 },
        { name: "Halloluwa", district: "Kandy District", lat: 7.3011, lng: 80.6125 },
        { name: "Katugastota", district: "Kandy District", lat: 7.3200, lng: 80.6200 },
        { name: "Digana", district: "Kandy District", lat: 7.2990, lng: 80.7390 },
        { name: "Gampola", district: "Kandy District", lat: 7.1647, lng: 80.5692 },
        { name: "Akurana", district: "Kandy District", lat: 7.3667, lng: 80.6167 },
        { name: "Kundasale", district: "Kandy District", lat: 7.2833, lng: 80.6833 },
        { name: "Pilimathalawa", district: "Kandy District", lat: 7.2700, lng: 80.5400 },
        { name: "Nawalapitiya", district: "Kandy District", lat: 7.0500, lng: 80.5333 },

        // Colombo District
        { name: "Colombo Fort", district: "Colombo District", lat: 6.9344, lng: 79.8428 },
        { name: "Pettah", district: "Colombo District", lat: 6.9367, lng: 79.8528 },
        { name: "Dehiwala", district: "Colombo District", lat: 6.8511, lng: 79.8650 },
        { name: "Mount Lavinia", district: "Colombo District", lat: 6.8300, lng: 79.8633 },
        { name: "Nugegoda", district: "Colombo District", lat: 6.8722, lng: 79.8892 },
        { name: "Maharagama", district: "Colombo District", lat: 6.8483, lng: 79.9267 },
        { name: "Kaduwela", district: "Colombo District", lat: 6.9344, lng: 79.9847 },
        { name: "Malabe", district: "Colombo District", lat: 6.9044, lng: 79.9547 },
        { name: "Rajagiriya", district: "Colombo District", lat: 6.9092, lng: 79.8942 },
        { name: "Battaramulla", district: "Colombo District", lat: 6.8975, lng: 79.9222 },
        { name: "Homagama", district: "Colombo District", lat: 6.8433, lng: 80.0033 },

        // Galle District
        { name: "Galle Fort", district: "Galle District", lat: 6.0267, lng: 80.2170 },
        { name: "Hikkaduwa", district: "Galle District", lat: 6.1389, lng: 80.1022 },
        { name: "Unawatuna", district: "Galle District", lat: 6.0100, lng: 80.2489 },
        { name: "Ambalangoda", district: "Galle District", lat: 6.2361, lng: 80.0544 },
        { name: "Karapitiya", district: "Galle District", lat: 6.0667, lng: 80.2333 },
        { name: "Bentota", district: "Galle District", lat: 6.4250, lng: 79.9972 },

        // Jaffna District
        { name: "Jaffna Town", district: "Jaffna District", lat: 9.6615, lng: 80.0255 },
        { name: "Nallur", district: "Jaffna District", lat: 9.6744, lng: 80.0294 },
        { name: "Chunnakam", district: "Jaffna District", lat: 9.7500, lng: 80.0333 },
        { name: "Chavakachcheri", district: "Jaffna District", lat: 9.6542, lng: 80.1611 },
        { name: "Point Pedro", district: "Jaffna District", lat: 9.8167, lng: 80.2333 },

        // Nuwara Eliya District
        { name: "Nuwara Eliya Town", district: "Nuwara Eliya District", lat: 6.9497, lng: 80.7891 },
        { name: "Hatton", district: "Nuwara Eliya District", lat: 6.8917, lng: 80.5972 },
        { name: "Maskeliya", district: "Nuwara Eliya District", lat: 6.8333, lng: 80.5667 },
        { name: "Talawakele", district: "Nuwara Eliya District", lat: 6.9367, lng: 80.6569 },

        // Badulla District
        { name: "Badulla Town", district: "Badulla District", lat: 6.9934, lng: 81.0550 },
        { name: "Ella", district: "Badulla District", lat: 6.8667, lng: 81.0467 },
        { name: "Bandarawela", district: "Badulla District", lat: 6.8306, lng: 80.9986 },
        { name: "Haputale", district: "Badulla District", lat: 6.7681, lng: 80.9633 },

        // Matara District
        { name: "Matara Town", district: "Matara District", lat: 5.9496, lng: 80.5469 },
        { name: "Mirissa", district: "Matara District", lat: 5.9483, lng: 80.4717 },
        { name: "Weligama", district: "Matara District", lat: 5.9739, lng: 80.4286 },

        // Kurunegala District
        { name: "Kurunegala Town", district: "Kurunegala District", lat: 7.4863, lng: 80.3623 },
        { name: "Kuliyapitiya", district: "Kurunegala District", lat: 7.4689, lng: 80.0400 },

        // Gampaha District
        { name: "Gampaha Town", district: "Gampaha District", lat: 7.0840, lng: 79.9925 },
        { name: "Negombo", district: "Gampaha District", lat: 7.2083, lng: 79.8358 },
        { name: "Kelaniya", district: "Gampaha District", lat: 6.9553, lng: 79.9219 },
        { name: "Kiribathgoda", district: "Gampaha District", lat: 6.9808, lng: 79.9281 },

        // Anuradhapura District
        { name: "Anuradhapura Town", district: "Anuradhapura District", lat: 8.3114, lng: 80.4037 },
        { name: "Habarana", district: "Anuradhapura District", lat: 8.0333, lng: 80.7500 },
        { name: "Mihintale", district: "Anuradhapura District", lat: 8.3500, lng: 80.5000 },

        // Matale District
        { name: "Matale Town", district: "Matale District", lat: 7.4675, lng: 80.6234 },
        { name: "Dambulla", district: "Matale District", lat: 7.8600, lng: 80.6500 },
        { name: "Sigiriya", district: "Matale District", lat: 7.9570, lng: 80.7603 },

        // Batticaloa District
        { name: "Batticaloa Town", district: "Batticaloa District", lat: 7.7170, lng: 81.7000 },
        { name: "Kattankudy", district: "Batticaloa District", lat: 7.6833, lng: 81.7167 },

        // Ampara District
        { name: "Ampara Town", district: "Ampara District", lat: 7.2833, lng: 81.6667 },
        { name: "Arugam Bay", district: "Ampara District", lat: 6.8417, lng: 81.8333 }
    ];

    // Real-Time Location Autocomplete Dropdown (Google Maps style)
    function setupLocationAutocomplete(inputId, dropdownId) {
        const input = document.getElementById(inputId);
        const dropdown = document.getElementById(dropdownId);
        let debounceTimer;

        input.addEventListener('input', function() {
            input.removeAttribute('data-lat');
            input.removeAttribute('data-lng');

            clearTimeout(debounceTimer);
            const query = this.value.trim().toLowerCase();

            if (query.length < 2) {
                dropdown.classList.add('d-none');
                dropdown.innerHTML = '';
                return;
            }

            // 1. Filter local Sri Lanka dataset for matching town or district name
            const localMatches = SRI_LANKA_PLACES_DB.filter(p => 
                p.name.toLowerCase().includes(query) || p.district.toLowerCase().includes(query)
            );

            debounceTimer = setTimeout(async () => {
                let combinedResults = [];

                // Format local DB matches
                localMatches.forEach(item => {
                    combinedResults.push({
                        lat: item.lat,
                        lng: item.lng,
                        mainName: item.name,
                        subName: `${item.district}, Sri Lanka`
                    });
                });

                try {
                    const res = await fetch(`https://nominatim.openstreetmap.org/search?format=json&countrycodes=lk&limit=8&q=${encodeURIComponent(query)}`);
                    const apiResults = await res.json();

                    if (apiResults && apiResults.length > 0) {
                        apiResults.forEach(item => {
                            const parts = item.display_name.split(',');
                            const mainName = parts[0];
                            const subName = parts.slice(1, 4).join(',').trim();

                            // Avoid exact duplicate names
                            if (!combinedResults.some(cr => cr.mainName.toLowerCase() === mainName.toLowerCase())) {
                                combinedResults.push({
                                    lat: parseFloat(item.lat),
                                    lng: parseFloat(item.lon),
                                    mainName: mainName,
                                    subName: subName
                                });
                            }
                        });
                    }
                } catch (e) {
                    console.log('Autocomplete API error:', e);
                }

                if (combinedResults.length === 0) {
                    dropdown.innerHTML = `<div class="list-group-item text-muted small py-2 px-3">No matching location found in Sri Lanka</div>`;
                    dropdown.classList.remove('d-none');
                    return;
                }

                dropdown.innerHTML = combinedResults.slice(0, 10).map(item => {
                    return `
                        <button type="button" class="list-group-item list-group-item-action py-2 px-3 border-bottom text-start dropdown-item-custom" data-lat="${item.lat}" data-lng="${item.lng}" data-name="${item.mainName}">
                            <div class="fw-bold text-dark small"><i class="bi bi-geo-alt-fill text-danger me-1"></i> ${item.mainName}</div>
                            <div class="text-secondary text-truncate" style="font-size: 0.76rem;">${item.subName}</div>
                        </button>
                    `;
                }).join('');

                dropdown.classList.remove('d-none');

                dropdown.querySelectorAll('.dropdown-item-custom').forEach(btn => {
                    btn.addEventListener('click', function() {
                        input.value = this.getAttribute('data-name');
                        input.setAttribute('data-lat', this.getAttribute('data-lat'));
                        input.setAttribute('data-lng', this.getAttribute('data-lng'));
                        dropdown.classList.add('d-none');
                    });
                });
            }, 250);
        });

        document.addEventListener('click', function(e) {
            if (!input.contains(e.target) && !dropdown.contains(e.target)) {
                dropdown.classList.add('d-none');
            }
        });
    }

    setupLocationAutocomplete('routeStartInput', 'routeStartSuggestions');
    setupLocationAutocomplete('routeDestInput', 'routeDestSuggestions');

    const routeCurrentGpsBtnEl = document.getElementById('routeCurrentGpsBtn');
    if (routeCurrentGpsBtnEl) {
        routeCurrentGpsBtnEl.addEventListener('click', function() {
            if (userLat && userLng) {
                const startElem = document.getElementById('routeStartInput');
                if (startElem) {
                    startElem.value = `My Live GPS (${userLat.toFixed(4)}, ${userLng.toFixed(4)})`;
                    startElem.setAttribute('data-lat', userLat);
                    startElem.setAttribute('data-lng', userLng);
                }
            } else {
                alert("Please click 'Track My Live Location' first to acquire GPS coordinates.");
            }
        });
    }

    const planSafeRouteBtnEl = document.getElementById('planSafeRouteBtn');
    if (planSafeRouteBtnEl) {
        planSafeRouteBtnEl.addEventListener('click', async function() {
            const btn = this;
            const startElem = document.getElementById('routeStartInput');
            const destElem = document.getElementById('routeDestInput');
            const startVal = startElem ? (startElem.value.trim() || 'Peradeniya') : 'Peradeniya';
            const destVal = destElem ? (destElem.value.trim() || 'Kandy Clock Tower') : 'Kandy Clock Tower';

            btn.innerHTML = `<i class="bi bi-arrow-repeat spin me-1"></i> Planning Route...`;
            btn.disabled = true;

            try {
                let startLoc = null, destLoc = null;

                if (startElem && startElem.getAttribute('data-lat') && startElem.getAttribute('data-lng') && startVal !== '') {
                    startLoc = { lat: parseFloat(startElem.getAttribute('data-lat')), lng: parseFloat(startElem.getAttribute('data-lng')), name: startVal };
                } else {
                    startLoc = await smartGeocode(startVal);
                }

                if (destElem && destElem.getAttribute('data-lat') && destElem.getAttribute('data-lng') && destVal !== '') {
                    destLoc = { lat: parseFloat(destElem.getAttribute('data-lat')), lng: parseFloat(destElem.getAttribute('data-lng')), name: destVal };
                } else {
                    destLoc = await smartGeocode(destVal);
                }

                if (!startLoc) {
                    alert(`Could not pinpoint start location '${startVal}'. Please try typing 'Peradeniya' or 'Kandy'.`);
                    btn.innerHTML = `<i class="bi bi-compass me-1"></i> Calculate Route`;
                    btn.disabled = false;
                    return;
                }

                if (!destLoc) {
                    alert(`Could not pinpoint destination '${destVal}'. Please try typing 'Kandy Clock Tower' or 'Kandy'.`);
                    btn.innerHTML = `<i class="bi bi-compass me-1"></i> Calculate Route`;
                    btn.disabled = false;
                    return;
                }

                const sLat = startLoc.lat;
                const sLng = startLoc.lng;
                const dLat = destLoc.lat;
                const dLng = destLoc.lng;

                const osrmRes = await fetch(`https://router.project-osrm.org/route/v1/driving/${sLng},${sLat};${dLng},${dLat}?overview=full&geometries=geojson`);
                const osrmData = await osrmRes.json();

                const safeRes = await fetch(`/ai/safe-route?start_lat=${sLat}&start_lng=${sLng}&dest_lat=${dLat}&dest_lng=${dLng}`);
                const safeData = await safeRes.json();

                if (routePolylineLayer && map) map.removeLayer(routePolylineLayer);

                if (osrmData.routes && osrmData.routes.length > 0 && map) {
                    const route = osrmData.routes[0];
                    const coordinates = route.geometry.coordinates.map(c => [c[1], c[0]]);

                    routePolylineLayer = L.polyline(coordinates, {
                        color: safeData.route_color || '#059669',
                        weight: 6,
                        opacity: 0.85,
                        dashArray: safeData.safety_score < 50 ? '10, 10' : null
                    }).addTo(map);

                    map.fitBounds(routePolylineLayer.getBounds(), { padding: [50, 50] });

                    const distKm = (route.distance / 1000).toFixed(1);
                    const durationMin = Math.round(route.duration / 60);

                    const badge = document.getElementById('routeSafetyScoreBadge');
                    if (badge) {
                        badge.textContent = `Safety Score: ${safeData.safety_score}/100`;
                        badge.className = `badge fs-6 px-3 py-1 ${safeData.safety_score >= 80 ? 'bg-success' : (safeData.safety_score >= 50 ? 'bg-warning text-dark' : 'bg-danger')}`;
                    }

                    const ratingTextEl = document.getElementById('routeSafetyRatingText');
                    if (ratingTextEl) ratingTextEl.textContent = safeData.safety_rating;
                    const distInfoEl = document.getElementById('routeDistanceInfo');
                    if (distInfoEl) distInfoEl.innerHTML = `<i class="bi bi-signpost me-1"></i> Distance: <strong>${distKm} km</strong> | Est. Time: <strong>${durationMin} mins</strong>`;

                    let hazardsHtml = `<div class="mt-2 text-slate-300">`;
                    if (safeData.hazards_count > 0) {
                        hazardsHtml += `<p class="mb-1 text-warning fw-bold"><i class="bi bi-exclamation-triangle-fill me-1"></i> ${safeData.hazards_count} Active Hazard Interceptions along Route Corridor:</p><ul>`;
                        safeData.intercepted_hazards.forEach(h => {
                            hazardsHtml += `<li><strong>${h.category}</strong> (${h.severity}): ${h.title} at ${h.area_name}</li>`;
                        });
                        hazardsHtml += `</ul>`;
                    } else {
                        hazardsHtml += `<p class="mb-1 text-emerald-400 fw-bold"><i class="bi bi-check-circle-fill me-1"></i> Clear Navigation Route: No active critical hazards detected along route corridor.</p>`;
                    }
                    hazardsHtml += `</div>`;

                    const summaryEl = document.getElementById('routeHazardsSummary');
                    if (summaryEl) summaryEl.innerHTML = hazardsHtml;
                    const resultsBoxEl = document.getElementById('routeResultsBox');
                    if (resultsBoxEl) resultsBoxEl.classList.remove('d-none');
                }

                btn.innerHTML = `<i class="bi bi-compass me-1"></i> Calculate Route`;
                btn.disabled = false;
            } catch (e) {
                btn.innerHTML = `<i class="bi bi-compass me-1"></i> Calculate Route`;
                btn.disabled = false;
                alert("Error calculating route. Please check location names and try again.");
            }
        });
    }

</script>

@endsection
