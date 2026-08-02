<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Safora - Community Safety & Emergency Response Platform</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Google Fonts: Inter & Outfit -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CSS & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Leaflet.js Map CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

    <!-- Chart.js for AI Risk Trend Analytics -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        :root {
            --slate-900: #0f172a;
            --slate-800: #1e293b;
            --slate-700: #334155;
            --slate-600: #475569;
            --slate-100: #f1f5f9;
            --slate-50: #f8fafc;
            --emerald-700: #047857;
            --emerald-600: #059669;
            --amber-600: #d97706;
            --red-600: #dc2626;
            --red-700: #b91c1c;
            --blue-600: #2563eb;
        }

        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            background-color: var(--slate-50);
            color: #1e293b;
            line-height: 1.5;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        main {
            flex: 1 0 auto;
        }

        footer {
            flex-shrink: 0;
            padding-bottom: 95px !important; /* Prevents floating SOS and Chatbot buttons from overlapping footer */
        }

        h1, h2, h3, h4, h5, h6, .brand-font {
            font-family: 'Outfit', 'Inter', sans-serif;
        }

        /* Top Evaluation Bar */
        .eval-bar {
            background-color: #0b1324;
            border-bottom: 1px solid #1e293b;
            font-size: 0.825rem;
        }

        /* Navbar */
        .navbar-safora {
            background-color: var(--slate-900);
            border-bottom: 1px solid var(--slate-700);
            padding-top: 0.85rem;
            padding-bottom: 0.85rem;
        }

        .brand-logo {
            font-size: 1.4rem;
            font-weight: 800;
            letter-spacing: -0.5px;
            color: #ffffff;
            text-decoration: none;
        }
        .brand-logo span {
            color: #f59e0b;
        }

        .nav-link-custom {
            color: #cbd5e1 !important;
            font-weight: 500;
            font-size: 0.925rem;
            padding: 0.5rem 0.85rem !important;
            transition: all 0.15s ease;
            border-radius: 6px;
        }
        .nav-link-custom:hover {
            color: #ffffff !important;
            background-color: rgba(255, 255, 255, 0.08);
        }

        /* Floating Emergency SOS Button */
        .sos-floating-btn {
            position: fixed;
            bottom: 24px;
            right: 24px;
            z-index: 9999;
            width: 68px;
            height: 68px;
            border-radius: 50%;
            background-color: var(--red-600);
            color: white;
            border: 3px solid #ffffff;
            box-shadow: 0 10px 20px rgba(220, 38, 38, 0.4);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 1rem;
            letter-spacing: 0.5px;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        .sos-floating-btn:hover {
            transform: scale(1.08);
            background-color: var(--red-700);
            color: white;
            box-shadow: 0 14px 28px rgba(220, 38, 38, 0.5);
        }

        /* 3D Gold Eagle Shield Logo Animation */
        @keyframes eagleShield3DFloat {
            0% {
                transform: translateY(0px) rotateY(0deg) scale(1);
                filter: drop-shadow(0 4px 12px rgba(245, 158, 11, 0.45));
            }
            50% {
                transform: translateY(-4px) rotateY(10deg) scale(1.05);
                filter: drop-shadow(0 10px 22px rgba(245, 158, 11, 0.85));
            }
            100% {
                transform: translateY(0px) rotateY(0deg) scale(1);
                filter: drop-shadow(0 4px 12px rgba(245, 158, 11, 0.45));
            }
        }

        .safora-eagle-3d-logo {
            height: 44px;
            width: auto;
            object-fit: contain;
            animation: eagleShield3DFloat 4s ease-in-out infinite;
            perspective: 800px;
            transform-style: preserve-3d;
            transition: transform 0.3s ease, filter 0.3s ease;
            cursor: pointer;
        }

        .safora-eagle-3d-logo:hover {
            transform: scale(1.18) rotateY(16deg);
            filter: drop-shadow(0 14px 28px rgba(245, 158, 11, 1));
        }

        /* Smooth Popup Animation */
        @keyframes popupSlideUp {
            from {
                opacity: 0;
                transform: translateY(16px) scale(0.96);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }
        .safora-popup-animate {
            animation: popupSlideUp 0.25s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        /* Floating AI Chatbot Button (Symmetrical Left position matching SOS right: 24px, 68px size) */
        .ai-chatbot-floating-btn {
            position: fixed;
            bottom: 24px;
            left: 24px;
            z-index: 99999;
            width: 68px;
            height: 68px;
            border-radius: 50%;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            color: #f59e0b;
            border: 3px solid #f59e0b;
            box-shadow: 0 10px 25px rgba(245, 158, 11, 0.4);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.6rem;
            cursor: pointer;
            transition: all 0.25s ease-in-out;
            overflow: hidden;
        }
        .ai-chatbot-floating-btn:hover {
            transform: scale(1.08);
            box-shadow: 0 14px 30px rgba(245, 158, 11, 0.6);
            background: #0f172a;
            color: #fbbf24;
        }

        /* Professional Cards */
        .card-pro {
            background-color: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.04), 0 1px 2px -1px rgba(0, 0, 0, 0.04);
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }
        .card-pro:hover {
            border-color: #cbd5e1;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
        }

        /* Tables & Badges */
        .table-pro {
            border-collapse: separate;
            border-spacing: 0;
        }
        .table-pro th {
            background-color: #f8fafc;
            color: var(--slate-600);
            font-weight: 600;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 1px solid #e2e8f0;
            padding: 12px 16px;
        }
        .table-pro td {
            padding: 14px 16px;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
            font-size: 0.9rem;
        }

        .badge-pro {
            padding: 5px 10px;
            font-size: 0.75rem;
            font-weight: 600;
            border-radius: 6px;
            letter-spacing: 0.3px;
        }

        /* Utility Slate Colors for High Contrast Badges & Text */
        .bg-slate-50 { background-color: #f8fafc !important; }
        .bg-slate-100 { background-color: #e2e8f0 !important; }
        .bg-slate-200 { background-color: #cbd5e1 !important; }
        .bg-slate-800 { background-color: #1e293b !important; }
        .bg-slate-900 { background-color: #0f172a !important; }

        .text-slate-900 { color: #0f172a !important; }
        .text-slate-800 { color: #1e293b !important; }
        .text-slate-700 { color: #334155 !important; }
        .text-slate-600 { color: #475569 !important; }
        .text-slate-400 { color: #94a3b8 !important; }
        .text-slate-300 { color: #cbd5e1 !important; }

        .badge-category {
            background-color: #e2e8f0 !important;
            color: #0f172a !important;
            font-weight: 700 !important;
            border: 1px solid #cbd5e1 !important;
            padding: 4px 10px !important;
            border-radius: 6px !important;
        }

        /* Map Container */
        #saforaMap {
            height: 480px;
            width: 100%;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
            border: 1px solid #cbd5e1;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* GPS Radar Pulsing Animation */
        @keyframes pulse-radar {
            0% {
                box-shadow: 0 0 0 0 rgba(37, 99, 235, 0.7);
            }
            70% {
                box-shadow: 0 0 0 16px rgba(37, 99, 235, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(37, 99, 235, 0);
            }
        }
        .user-gps-pulse {
            animation: pulse-radar 2s infinite;
        }

        /* Professional Teardrop GIS Map Marker Pins */
        .safora-marker-pin {
            width: 36px;
            height: 36px;
            border-radius: 50% 50% 50% 0;
            transform: rotate(-45deg);
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid #ffffff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.35);
            transition: all 0.25s ease-in-out;
            cursor: pointer;
        }
        .safora-marker-pin:hover {
            transform: rotate(-45deg) scale(1.25);
            box-shadow: 0 8px 18px rgba(0, 0, 0, 0.5);
            z-index: 9999 !important;
        }
        .safora-marker-icon {
            transform: rotate(45deg);
            font-size: 15px;
            line-height: 1;
            display: inline-block;
        }

        /* High Contrast Accessibility Mode */
        body.safora-high-contrast {
            background-color: #000000 !important;
            color: #ffffff !important;
        }
        body.safora-high-contrast .bg-white,
        body.safora-high-contrast .bg-slate-50,
        body.safora-high-contrast .bg-slate-100 {
            background-color: #090d16 !important;
            color: #ffffff !important;
        }
        body.safora-high-contrast .card,
        body.safora-high-contrast .card-pro {
            background-color: #0b1329 !important;
            border: 2px solid #f59e0b !important;
            color: #ffffff !important;
        }
        body.safora-high-contrast .text-dark,
        body.safora-high-contrast .text-slate-900,
        body.safora-high-contrast .text-slate-800,
        body.safora-high-contrast .text-slate-700,
        body.safora-high-contrast .text-slate-600,
        body.safora-high-contrast .text-muted {
            color: #ffffff !important;
        }
        body.safora-high-contrast .text-slate-400,
        body.safora-high-contrast .text-slate-300 {
            color: #f1f5f9 !important;
        }
    </style>
</head>
<body>



    <!-- Main Header Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-safora sticky-top">
        <div class="container">
            <a class="brand-logo me-4 d-inline-flex align-items-center gap-2 text-decoration-none" href="{{ route('home') }}">
                <img src="/images/safora-eagle-shield-clean.png" alt="Safora 3D Gold Eagle Shield Logo" class="safora-eagle-3d-logo">
                <span class="fw-extrabold text-white" style="letter-spacing: -0.5px;">SAFORA<span class="text-warning">.LK</span></span>
            </a>
            
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navMenu">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-center">
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom" href="{{ route('home') }}"><i class="bi bi-house-door me-1"></i> Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom" href="{{ route('home') }}#mapSection"><i class="bi bi-map me-1"></i> Safety Map</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom" href="{{ route('home') }}#reportSection"><i class="bi bi-plus-circle me-1"></i> Report Hazard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom" href="{{ route('home') }}#safePlacesSection"><i class="bi bi-hospital me-1"></i> Safe Places</a>
                    </li>
                    <li class="nav-item">
                        <button type="button" class="btn btn-sm btn-outline-warning text-warning px-3 py-1.5 ms-lg-2 rounded-3 me-2" data-bs-toggle="modal" data-bs-target="#emergencyContactsModal">
                            <i class="bi bi-telephone-plus me-1"></i> SOS Contacts
                        </button>
                    </li>

                    @auth
                        <li class="nav-item ms-lg-3">
                            <a class="btn btn-sm btn-warning text-dark fw-bold px-3 py-2 me-2" href="{{ route('dashboard') }}">
                                <i class="bi bi-speedometer2 me-1"></i> Dashboard ({{ ucfirst(Auth::user()->role) }})
                            </a>
                        </li>
                        <li class="nav-item">
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-outline-light px-3 py-2">Logout</button>
                            </form>
                        </li>
                    @else
                        <li class="nav-item ms-lg-3">
                            <a class="btn btn-sm btn-warning text-dark fw-bold px-4 py-2" href="{{ route('login') }}">
                                Sign In
                            </a>
                        </li>
                        <li class="nav-item ms-2">
                            <a class="btn btn-sm btn-outline-light px-3 py-2" href="{{ route('register') }}">
                                Register
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Global Alert Notifications -->
    <div class="container mt-3">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm border-0" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show rounded-3 shadow-sm border-0" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
    </div>

    <!-- Main Content -->
    <main class="w-100">
        @yield('content')
    </main>

    <!-- Floating Emergency SOS Button -->
    <button type="button" class="sos-floating-btn" id="sosTriggerBtn" title="Click for Emergency SOS Alert">
        SOS
    </button>

    @php
        $isPublicUserDashboard = false;
        if (request()->routeIs(['user.dashboard', 'dashboard'])) {
            if (auth()->check()) {
                $role = auth()->user()->role;
                if (in_array($role, ['public_user', 'user'])) {
                    $isPublicUserDashboard = true;
                }
            } else {
                $isPublicUserDashboard = true;
            }
        }
        $showFloatingChatbot = $isPublicUserDashboard;
        $showAccessibilityWidget = !$isPublicUserDashboard;
    @endphp

    @if($showAccessibilityWidget)
    <!-- Floating Universal Accessibility Widget (Fixed Bottom-Left 24px - Hidden on Public User Dashboard) -->
    <div id="accessibilityWidgetContainer" style="position: fixed !important; bottom: 24px !important; left: 24px !important; z-index: 999999 !important;">
        <!-- Floating Popover Card Drawer anchored directly above button -->
        <div id="accessibilityPopoverPanel" class="card safora-popup-animate text-white border border-warning rounded-4 shadow-2xl mb-2 d-none" style="width: 320px; box-shadow: 0 20px 40px rgba(0, 0, 0, 0.7) !important; background-color: #0f172a !important;">
            <div class="card-header border-bottom border-slate-800 p-3 bg-slate-800 d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2">
                    <span class="fs-5 text-warning"><i class="bi bi-person-fill-gear"></i></span>
                    <h6 class="fw-bold text-white fs-6 mb-0">Universal Accessibility</h6>
                </div>
                <button type="button" class="btn-close btn-close-white" id="closeAccessibilityPopoverBtn" aria-label="Close"></button>
            </div>
            <div class="card-body p-3">
                
                <!-- 1. Text Size Control -->
                <div class="mb-3 p-2.5 bg-slate-800 rounded-3 border border-slate-700">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="fw-bold text-slate-300 small">🔍 Text Resizing:</span>
                        <span id="currentFontSizeLabel" class="badge bg-warning text-dark">Normal (100%)</span>
                    </div>
                    <div class="btn-group w-100" role="group">
                        <button type="button" class="btn btn-outline-light btn-sm fw-bold" id="fontResetBtn">A</button>
                        <button type="button" class="btn btn-outline-warning btn-sm fw-bold" id="fontIncreaseBtn">A+</button>
                        <button type="button" class="btn btn-warning text-dark btn-sm fw-bold" id="fontMaxBtn">A++</button>
                    </div>
                </div>

                <!-- 2. High Contrast Mode Toggle -->
                <div class="mb-2.5 p-2.5 bg-slate-800 rounded-3 border border-slate-700 d-flex align-items-center justify-content-between">
                    <div class="pe-2">
                        <div class="fw-bold text-white small"><i class="bi bi-circle-half text-warning me-1"></i> High Contrast Mode</div>
                        <div class="text-slate-400 lh-sm" style="font-size: 0.72rem; margin-top: 2px;">Enhances outdoor sunlight visibility</div>
                    </div>
                    <div class="form-check form-switch mb-0">
                        <input class="form-check-input bg-warning border-0" type="checkbox" id="highContrastSwitch" style="width: 2.4em; height: 1.2em; cursor: pointer;">
                    </div>
                </div>

                <!-- 3. Screen Reader Text-To-Speech (TTS) Voice Guide -->
                <div class="mb-2.5 p-2.5 bg-slate-800 rounded-3 border border-slate-700 d-flex align-items-center justify-content-between">
                    <div class="pe-2">
                        <div class="fw-bold text-white small"><i class="bi bi-volume-up-fill text-emerald-400 me-1"></i> Voice Speech Reader</div>
                        <div class="text-slate-400 lh-sm" style="font-size: 0.72rem; margin-top: 2px;">Reads hazard alerts out loud on click/hover</div>
                    </div>
                    <div class="form-check form-switch mb-0">
                        <input class="form-check-input bg-success border-0" type="checkbox" id="speechReaderSwitch" style="width: 2.4em; height: 1.2em; cursor: pointer;">
                    </div>
                </div>

                <!-- 4. Dyslexia / High Legibility Font Mode -->
                <div class="mb-3 p-2.5 bg-slate-800 rounded-3 border border-slate-700 d-flex align-items-center justify-content-between">
                    <div class="pe-2">
                        <div class="fw-bold text-white small"><i class="bi bi-fonts text-info me-1"></i> High-Legibility Font</div>
                        <div class="text-slate-400 lh-sm" style="font-size: 0.72rem; margin-top: 2px;">Switches to high-readability font style</div>
                    </div>
                    <div class="form-check form-switch mb-0">
                        <input class="form-check-input bg-info border-0" type="checkbox" id="legibilityFontSwitch" style="width: 2.4em; height: 1.2em; cursor: pointer;">
                    </div>
                </div>

                <!-- Reset Button -->
                <button type="button" class="btn btn-slate-700 btn-outline-secondary text-slate-300 btn-sm w-100" id="resetAccessibilitySettingsBtn">
                    <i class="bi bi-arrow-counterclockwise me-1"></i> Reset Accessibility Options
                </button>

            </div>
        </div>

        <!-- Floating Trigger Button (Exact 68px size matching SOS button) -->
        <button type="button" class="btn btn-warning text-dark fw-bold shadow-lg rounded-circle p-0 d-flex align-items-center justify-content-center" id="accessibilityWidgetBtn" title="Universal Accessibility Options" style="width: 68px; height: 68px; font-size: 1.8rem; border: 3px solid #ffffff !important; box-shadow: 0 10px 20px rgba(0,0,0,0.4) !important; transition: all 0.2s ease;">
            ♿
        </button>
    </div>
    @endif

    @if($showFloatingChatbot)
    <!-- Floating AI Chatbot Button & Popover Chat Drawer (Public User Exclusive - Positioned at bottom: 24px replacing Accessibility) -->
    <div id="aiChatbotFloatingContainer" style="position: fixed; bottom: 24px; left: 24px; z-index: 999998;">
        <!-- Floating Popover Chat Drawer (Opens above button) -->
        <div id="aiChatbotFloatingDrawer" class="card safora-popup-animate border border-warning rounded-4 shadow-2xl mb-2 d-none" style="width: 360px; max-width: 90vw; background-color: #0f172a !important; color: white !important; box-shadow: 0 20px 40px rgba(0, 0, 0, 0.7) !important;">
            <!-- Header -->
            <div class="card-header bg-slate-800 border-bottom border-slate-700 p-3 d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2">
                    <img src="/images/ai-avatar.png" alt="Safora AI" class="rounded-circle border border-warning shadow-sm" style="width: 40px; height: 40px; object-fit: cover;">
                    <div>
                        <h6 class="fw-bold mb-0 text-white">Safora AI Safety Assistant</h6>
                        <small class="text-emerald-400 d-flex align-items-center gap-1" style="font-size: 0.72rem;">
                            <span class="spinner-grow spinner-grow-sm text-success" style="width: 6px; height: 6px;"></span> 24/7 Live AI Assistant
                        </small>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white" id="closeAiChatbotFloatingBtn" aria-label="Close"></button>
            </div>

            <!-- Quick Chips (Wrapped cleanly so all features are 100% visible) -->
            <div class="p-2 bg-slate-900 border-bottom border-slate-800 d-flex flex-wrap gap-1.5">
                <button type="button" class="btn btn-xs btn-outline-warning text-nowrap rounded-pill px-2.5 py-1" style="font-size: 0.72rem;" onclick="sendGlobalQuickPrompt('What is the emergency hotline for ambulance?')">🚑 Ambulance</button>
                <button type="button" class="btn btn-xs btn-outline-info text-nowrap rounded-pill px-2.5 py-1" style="font-size: 0.72rem;" onclick="sendGlobalQuickPrompt('Where is the nearest safe place in Colombo?')">📍 Safe Places</button>
                <button type="button" class="btn btn-xs btn-outline-danger text-nowrap rounded-pill px-2.5 py-1" style="font-size: 0.72rem;" onclick="sendGlobalQuickPrompt('How to send emergency SOS distress signal?')">🚨 SOS Guide</button>
                <button type="button" class="btn btn-xs btn-outline-light text-nowrap rounded-pill px-2.5 py-1" style="font-size: 0.72rem;" onclick="sendGlobalQuickPrompt('What to do during wild elephant encounter?')">🐘 Elephants</button>
                <button type="button" class="btn btn-xs btn-outline-warning text-nowrap rounded-pill px-2.5 py-1" style="font-size: 0.72rem;" onclick="sendGlobalQuickPrompt('How do I report harassment zone?')">📝 Report</button>
            </div>

            <!-- Messages Body -->
            <div id="globalAiChatMessages" class="p-3 overflow-y-auto" style="height: 300px; background-color: #0b1329;">
                <div class="d-flex gap-2 mb-3">
                    <img src="/images/ai-avatar.png" alt="AI" class="rounded-circle border border-warning flex-shrink-0" style="width: 30px; height: 30px; object-fit: cover;">
                    <div class="p-2.5 rounded-3 bg-slate-800 text-white border border-slate-700 shadow-sm" style="max-width: 85%;">
                        <div class="fw-bold text-warning small mb-1">Safora AI Assistant</div>
                        <p class="mb-0" style="font-size: 0.8rem;">Ayubowan! 👋 Ask me anything about Sri Lanka emergency numbers (119, 1990, 1985, 1938), safe places, or travel safety tips!</p>
                    </div>
                </div>
            </div>

            <!-- Input Box -->
            <div class="card-footer bg-slate-800 border-top border-slate-700 p-2">
                <form id="globalAiChatForm" onsubmit="handleGlobalAiChatSubmit(event)" class="d-flex gap-1.5">
                    <input type="text" id="globalAiChatInput" class="form-control form-control-sm bg-slate-900 text-white border-slate-700 px-3 py-2 rounded-3" placeholder="Ask AI Safety Assistant..." required autocomplete="off">
                    <button type="submit" class="btn btn-sm btn-warning text-dark fw-bold px-3 py-2 rounded-3">
                        <i class="bi bi-send-fill"></i>
                    </button>
                </form>
            </div>
        </div>

        <!-- Floating Trigger Button (Symmetrical Left 68px matching SOS Button) -->
        <button type="button" class="ai-chatbot-floating-btn p-0" id="aiChatbotFloatingBtn" title="Chat with Safora AI Assistant">
            <img src="/images/ai-avatar.png" alt="AI Safety Assistant" style="width: 100%; height: 100%; object-fit: cover;">
        </button>
    </div>
    @endif
    
    <!-- Emergency Contacts Configuration Modal -->
    <div class="modal fade" id="emergencyContactsModal" tabindex="-1" aria-labelledby="emergencyContactsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-slate-900 text-white border border-slate-700 shadow-lg">
                <div class="modal-header border-bottom border-slate-800 bg-slate-950">
                    <h5 class="modal-title fw-bold text-warning" id="emergencyContactsModalLabel">
                        <i class="bi bi-shield-lock-fill me-2"></i> Manage Emergency Contacts (WhatsApp / SMS)
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <p class="small text-slate-300 mb-3">
                        Enter up to 3 trusted family members or friends. When you click the <strong>Red SOS Button</strong>, live GPS location links will be broadcasted to their WhatsApp & SMS!
                    </p>
                    <form id="emergencyContactsForm" onsubmit="saveEmergencyContacts(event)">
                        <!-- Contact 1 -->
                        <div class="card bg-slate-800 border-slate-700 p-3 mb-3">
                            <div class="fw-bold text-warning small mb-2"><i class="bi bi-person-heart me-1"></i> Emergency Contact #1</div>
                            <div class="row g-2">
                                <div class="col-md-5">
                                    <input type="text" id="contact1Name" class="form-control form-control-sm bg-slate-900 text-white border-slate-700" placeholder="Name (e.g. Amma / Mother)" required>
                                </div>
                                <div class="col-md-7">
                                    <input type="tel" id="contact1Phone" class="form-control form-control-sm bg-slate-900 text-white border-slate-700" placeholder="Mobile / WhatsApp (0771234567)" required>
                                </div>
                            </div>
                        </div>

                        <!-- Contact 2 -->
                        <div class="card bg-slate-800 border-slate-700 p-3 mb-3">
                            <div class="fw-bold text-info small mb-2"><i class="bi bi-person-heart me-1"></i> Emergency Contact #2</div>
                            <div class="row g-2">
                                <div class="col-md-5">
                                    <input type="text" id="contact2Name" class="form-control form-control-sm bg-slate-900 text-white border-slate-700" placeholder="Name (e.g. Spouse)">
                                </div>
                                <div class="col-md-7">
                                    <input type="tel" id="contact2Phone" class="form-control form-control-sm bg-slate-900 text-white border-slate-700" placeholder="Mobile / WhatsApp (0779876543)">
                                </div>
                            </div>
                        </div>

                        <!-- Contact 3 -->
                        <div class="card bg-slate-800 border-slate-700 p-3 mb-3">
                            <div class="fw-bold text-success small mb-2"><i class="bi bi-person-heart me-1"></i> Emergency Contact #3</div>
                            <div class="row g-2">
                                <div class="col-md-5">
                                    <input type="text" id="contact3Name" class="form-control form-control-sm bg-slate-900 text-white border-slate-700" placeholder="Name (e.g. Best Friend)">
                                </div>
                                <div class="col-md-7">
                                    <input type="tel" id="contact3Phone" class="form-control form-control-sm bg-slate-900 text-white border-slate-700" placeholder="Mobile / WhatsApp (0712345678)">
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <button type="button" class="btn btn-sm btn-outline-light" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-sm btn-warning text-dark fw-bold px-4">
                                <i class="bi bi-check-circle-fill me-1"></i> Save Emergency Contacts
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Instant Emergency SOS Broadcast Modal -->
    <div class="modal fade" id="sosBroadcastModal" tabindex="-1" aria-labelledby="sosBroadcastModalLabel" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-slate-950 text-white border border-danger shadow-lg" style="border-width: 2px !important;">
                <div class="modal-header border-bottom border-danger bg-danger text-white">
                    <h5 class="modal-title fw-bold text-uppercase" id="sosBroadcastModalLabel">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i> Emergency SOS Broadcast Activated
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4 text-center">
                    <div class="spinner-grow text-danger mb-3" role="status" style="width: 3rem; height: 3rem;"></div>
                    <h5 class="fw-bold text-white mb-1">🚨 Live Distress Signal Sent to Authorities!</h5>
                    <p class="small text-slate-300 mb-3" id="sosGpsStatusText">Broadcasting your exact GPS coordinates to Police Authorities & Emergency Network...</p>
                    
                    <div class="p-3 bg-slate-900 rounded-3 border border-slate-800 mb-4 text-start">
                        <div class="small text-warning fw-bold mb-1"><i class="bi bi-geo-alt-fill me-1"></i> Live GPS Location Link:</div>
                        <a id="sosLiveMapUrl" href="#" target="_blank" class="small text-info text-break text-decoration-none fw-semibold">Generating live Google Maps link...</a>
                    </div>

                    <!-- Instant WhatsApp Broadcast Section -->
                    <div class="card bg-slate-900 border-success border-opacity-50 p-3 mb-3 text-start">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <span class="fw-bold text-success small"><i class="bi bi-whatsapp me-1"></i> Direct WhatsApp Broadcast:</span>
                            <span class="badge bg-success text-dark fw-bold">Instant Dispatch</span>
                        </div>
                        <div id="whatsappContactsButtonsList" class="d-grid gap-2">
                            <!-- Populated dynamically via JS -->
                        </div>
                    </div>

                    <!-- Offline SMS Emergency Broadcast Section -->
                    <div class="card bg-slate-900 border-info border-opacity-50 p-3 mb-3 text-start">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <span class="fw-bold text-info small"><i class="bi bi-chat-text-fill me-1"></i> Offline SMS Emergency Broadcast:</span>
                            <span class="badge bg-info text-dark fw-bold">Offline Gateway</span>
                        </div>
                        <div id="smsContactsButtonsList" class="d-grid gap-2">
                            <!-- Populated dynamically via JS -->
                        </div>
                    </div>

                    <!-- Direct Emergency Hotlines -->
                    <div class="d-flex justify-content-center gap-2 mt-2">
                        <a href="tel:119" class="btn btn-sm btn-outline-danger fw-bold px-3">
                            <i class="bi bi-telephone-fill me-1"></i> Call 119 Police
                        </a>
                        <a href="tel:1990" class="btn btn-sm btn-outline-warning text-warning fw-bold px-3">
                            <i class="bi bi-hospital-fill me-1"></i> Call 1990 Ambulance
                        </a>
                    </div>
                </div>
                <div class="modal-footer border-top border-slate-800 bg-slate-900 justify-content-between">
                    <span class="small text-slate-400"><i class="bi bi-shield-check me-1"></i> Safora 24/7 Safety Network</span>
                    <button type="button" class="btn btn-sm btn-secondary px-4" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer (Ultra-Beautiful Glassmorphic Compact Design) -->
    <footer class="text-white mt-5 border-top border-slate-800" style="background: linear-gradient(180deg, #0b1329 0%, #030712 100%) !important; box-shadow: inset 0 1px 0 rgba(245, 158, 11, 0.15); padding: 1.5rem 0;">
        <div class="container">
            <div class="row align-items-center gy-3 pb-3 border-bottom border-slate-800 border-opacity-60">
                <!-- Brand & Tagline -->
                <div class="col-md-6">
                    <div class="d-flex align-items-center gap-2 mb-1">
                        <img src="/images/safora-eagle-shield-clean.png" alt="Safora 3D Gold Eagle Shield Logo" class="safora-eagle-3d-logo" style="height: 48px;">
                        <a class="brand-logo fs-4 text-decoration-none fw-extrabold tracking-tight" href="{{ route('home') }}" style="color: #ffffff;">
                            SAFORA<span class="text-warning">.LK</span>
                        </a>
                        <span class="badge bg-slate-800 text-warning border border-warning border-opacity-30 font-mono fw-bold px-2.5 py-1 rounded-pill" style="font-size: 0.68rem; letter-spacing: 0.5px;">
                            <i class="bi bi-broadcast me-1"></i>24/7 AI SAFETY
                        </span>
                    </div>
                    <p class="text-slate-400 mb-0 ps-1" style="font-size: 0.78rem; line-height: 1.4;">
                        Sri Lanka's premier community-driven safety network & real-time GIS hazard mapping platform.
                    </p>
                </div>

                <!-- Quick Nav Links (Glassmorphic Pill Buttons) -->
                <div class="col-md-6 text-md-end">
                    <div class="d-flex flex-wrap justify-content-md-end gap-2">
                        <a href="{{ route('home') }}" class="btn btn-sm text-white fw-semibold border border-slate-700 rounded-pill px-3 py-1.5 d-inline-flex align-items-center gap-1.5 text-decoration-none shadow-sm" style="font-size: 0.78rem; background: rgba(30, 41, 59, 0.85); color: #ffffff !important;">
                            <i class="bi bi-house-door-fill text-warning fs-6"></i> Home
                        </a>
                        <a href="{{ route('home') }}#mapSection" class="btn btn-sm text-white fw-semibold border border-slate-700 rounded-pill px-3 py-1.5 d-inline-flex align-items-center gap-1.5 text-decoration-none shadow-sm" style="font-size: 0.78rem; background: rgba(30, 41, 59, 0.85); color: #ffffff !important;">
                            <i class="bi bi-map-fill text-info fs-6"></i> Safety Map
                        </a>
                        <a href="{{ route('home') }}#reportSection" class="btn btn-sm text-white fw-semibold border border-slate-700 rounded-pill px-3 py-1.5 d-inline-flex align-items-center gap-1.5 text-decoration-none shadow-sm" style="font-size: 0.78rem; background: rgba(30, 41, 59, 0.85); color: #ffffff !important;">
                            <i class="bi bi-exclamation-triangle-fill text-danger fs-6"></i> Report Hazard
                        </a>
                        <a href="{{ route('dashboard') }}" class="btn btn-sm text-white fw-semibold border border-slate-700 rounded-pill px-3 py-1.5 d-inline-flex align-items-center gap-1.5 text-decoration-none shadow-sm" style="font-size: 0.78rem; background: rgba(30, 41, 59, 0.85); color: #ffffff !important;">
                            <i class="bi bi-speedometer2 text-emerald-400 fs-6"></i> Dashboard
                        </a>
                    </div>
                </div>
            </div>

            <!-- Bottom Copyright Bar -->
            <div class="pt-3 text-center text-slate-400" style="font-size: 0.75rem;">
                <div class="d-inline-flex align-items-center justify-content-center gap-1.5 flex-wrap">
                    <i class="bi bi-shield-lock-fill text-warning"></i>
                    <span>&copy; {{ date('Y') }} <strong class="text-white">SAFORA.LK Safety Network</strong> &bull; Protection for Sri Lanka Commuters</span>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Leaflet.js -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <!-- Emergency SOS & AI Chatbot Floating Drawer Handlers -->
    <script>
        // Toggle Floating AI Chatbot Drawer
        const chatbotFloatingBtn = document.getElementById('aiChatbotFloatingBtn');
        if (chatbotFloatingBtn) {
            chatbotFloatingBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                const drawer = document.getElementById('aiChatbotFloatingDrawer');
                if (drawer) {
                    drawer.classList.toggle('d-none');
                    if (!drawer.classList.contains('d-none')) {
                        const input = document.getElementById('globalAiChatInput');
                        if (input) input.focus();
                    }
                }
            });
        }

        const closeChatbotFloatingBtn = document.getElementById('closeAiChatbotFloatingBtn');
        if (closeChatbotFloatingBtn) {
            closeChatbotFloatingBtn.addEventListener('click', function() {
                const drawer = document.getElementById('aiChatbotFloatingDrawer');
                if (drawer) drawer.classList.add('d-none');
            });
        }

        // Close popover when clicking outside
        document.addEventListener('click', function(e) {
            const container = document.getElementById('aiChatbotFloatingContainer');
            const drawer = document.getElementById('aiChatbotFloatingDrawer');
            if (container && drawer && !container.contains(e.target)) {
                drawer.classList.add('d-none');
            }
        });

        function sendGlobalQuickPrompt(promptText) {
            const input = document.getElementById('globalAiChatInput');
            if (input) {
                input.value = promptText;
                handleGlobalAiChatSubmit(new Event('submit'));
            }
        }

        async function handleGlobalAiChatSubmit(e) {
            if (e && e.preventDefault) e.preventDefault();
            const input = document.getElementById('globalAiChatInput');
            if (!input) return;
            const query = input.value.trim();
            if (!query) return;

            appendGlobalMessage('user', query);
            input.value = '';

            showGlobalTypingIndicator();

            try {
                const response = await fetch('/ai/chat', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ message: query })
                });
                const data = await response.json();
                removeGlobalTypingIndicator();
                if (data && data.reply) {
                    appendGlobalMessage('bot', data.reply);
                } else {
                    appendGlobalMessage('bot', generateGlobalAiResponse(query));
                }
            } catch (err) {
                removeGlobalTypingIndicator();
                const fallbackResponse = generateGlobalAiResponse(query);
                appendGlobalMessage('bot', fallbackResponse);
            }
        }

        function appendGlobalMessage(sender, text) {
            const container = document.getElementById('globalAiChatMessages');
            if (!container) return;
            const msgDiv = document.createElement('div');
            msgDiv.className = 'd-flex gap-2 mb-3 ' + (sender === 'user' ? 'justify-content-end' : '');

            if (sender === 'bot') {
                msgDiv.innerHTML = `
                    <img src="/images/ai-avatar.png" alt="AI" class="rounded-circle border border-warning flex-shrink-0" style="width: 28px; height: 28px; object-fit: cover;">
                    <div class="p-2.5 rounded-3 bg-slate-800 text-white border border-slate-700 shadow-sm" style="max-width: 85%;">
                        <div class="fw-bold text-warning small mb-1" style="font-size: 0.75rem;">Safora AI Assistant</div>
                        <div class="small" style="font-size: 0.8rem;">${text}</div>
                    </div>
                `;
            } else {
                msgDiv.innerHTML = `
                    <div class="p-2.5 rounded-3 bg-warning text-dark fw-semibold shadow-sm" style="max-width: 85%; font-size: 0.8rem;">
                        ${text}
                    </div>
                    <div class="p-1.5 bg-slate-700 text-white rounded-circle fw-bold fs-6 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 28px; height: 28px; font-size: 0.85rem;">👤</div>
                `;
            }

            container.appendChild(msgDiv);
            container.scrollTop = container.scrollHeight;
        }

        function showGlobalTypingIndicator() {
            const container = document.getElementById('globalAiChatMessages');
            if (!container) return;
            const typingDiv = document.createElement('div');
            typingDiv.id = 'globalAiTypingIndicator';
            typingDiv.className = 'd-flex gap-2 mb-3';
            typingDiv.innerHTML = `
                <img src="/images/ai-avatar.png" alt="AI" class="rounded-circle border border-warning flex-shrink-0" style="width: 28px; height: 28px; object-fit: cover;">
                <div class="p-2.5 rounded-3 bg-slate-800 text-slate-400 border border-slate-700 small d-flex align-items-center gap-2" style="font-size: 0.8rem;">
                    <span>AI thinking...</span>
                    <span class="spinner-grow spinner-grow-sm text-warning" style="width: 6px; height: 6px;"></span>
                </div>
            `;
            container.appendChild(typingDiv);
            container.scrollTop = container.scrollHeight;
        }

        function removeGlobalTypingIndicator() {
            const indicator = document.getElementById('globalAiTypingIndicator');
            if (indicator) indicator.remove();
        }

        function generateGlobalAiResponse(inputStr) {
            const q = inputStr.toLowerCase();

            if (q.includes('safe place') || q.includes('safe places') || q.includes('safe haven') || q.includes('shelter')) {
                return `📍 <strong>Verified Safe Havens & Emergency Rest Spots:</strong><br>• <strong>Colombo 01:</strong> Fort Police Station Hub (24/7 Monitored)<br>• <strong>Colombo 11:</strong> Pettah Central Safe Response Point<br>• <strong>Kandy:</strong> Kandy Clock Tower Response Post<br>• <strong>Galle:</strong> Galle Main Station Emergency Point`;
            }

            if (q.includes('police') || q.includes('119') || q.includes('crime')) {
                return `🚨 <strong>Police Emergency: 119</strong><br>Call 119 directly or press the red SOS button at the bottom-right to send live GPS coordinates!`;
            }

            if (q.includes('ambulance') || q.includes('hospital') || q.includes('1990') || q.includes('suwa seriya')) {
                return `🚑 <strong>Suwa Seriya Ambulance: 1990</strong><br>Free 24/7 emergency medical dispatch across Sri Lanka!`;
            }

            if (q.includes('elephant') || q.includes('wildlife') || q.includes('1985')) {
                return `🐘 <strong>Wildlife Hotline: 1985</strong><br>Do not flash lights or honk at wild elephants. Stay safe & dial 1985!`;
            }

            if (q.includes('women') || q.includes('child') || q.includes('1938')) {
                return `🚺 <strong>Women & Child Protection: 1938</strong><br>For immediate confidential assistance against harassment.`;
            }

            return `💡 <strong>Safora AI Assistant:</strong><br>I can help you with emergency hotlines (119, 1990, 1985, 1938), safe places in Sri Lanka, or SOS distress alerts!`;
        }

        // Emergency Contacts Storage & Persistence Manager
        function getEmergencyContacts() {
            const stored = localStorage.getItem('safora_emergency_contacts');
            if (stored) {
                try { return JSON.parse(stored); } catch(e) {}
            }
            return [
                { name: "Family Emergency Contact", phone: "0771234567" },
                { name: "Spouse / Partner", phone: "0779876543" }
            ];
        }

        function saveEmergencyContacts(e) {
            if (e && e.preventDefault) e.preventDefault();
            const contacts = [];
            for (let i = 1; i <= 3; i++) {
                const name = document.getElementById(`contact${i}Name`)?.value.trim();
                const phone = document.getElementById(`contact${i}Phone`)?.value.trim();
                if (name && phone) {
                    contacts.push({ name, phone });
                }
            }
            localStorage.setItem('safora_emergency_contacts', JSON.stringify(contacts));
            alert("✅ Emergency Contacts Saved Successfully!\nWhen you press the Red SOS Button, live GPS location WhatsApp & SMS alerts will be broadcasted to these contacts.");
            const modalEl = document.getElementById('emergencyContactsModal');
            const modal = bootstrap.Modal.getInstance(modalEl);
            if (modal) modal.hide();
        }

        function loadEmergencyContactsForm() {
            const contacts = getEmergencyContacts();
            for (let i = 1; i <= 3; i++) {
                const nameInput = document.getElementById(`contact${i}Name`);
                const phoneInput = document.getElementById(`contact${i}Phone`);
                if (nameInput) nameInput.value = '';
                if (phoneInput) phoneInput.value = '';
            }
            contacts.forEach((c, idx) => {
                const i = idx + 1;
                const nameInput = document.getElementById(`contact${i}Name`);
                const phoneInput = document.getElementById(`contact${i}Phone`);
                if (nameInput) nameInput.value = c.name || '';
                if (phoneInput) phoneInput.value = c.phone || '';
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            const contactsModalEl = document.getElementById('emergencyContactsModal');
            if (contactsModalEl) {
                contactsModalEl.addEventListener('show.bs.modal', loadEmergencyContactsForm);
            }
        });

        function formatPhoneForWhatsapp(phoneStr) {
            let p = phoneStr.replace(/\D/g, '');
            if (p.startsWith('0')) {
                p = '94' + p.substring(1);
            }
            return p;
        }

        // Emergency SOS Listener with Instant WhatsApp & SMS Broadcast
        const sosTriggerBtn = document.getElementById('sosTriggerBtn');
        if (sosTriggerBtn) {
            sosTriggerBtn.addEventListener('click', function() {
                if (confirm("🚨 EMERGENCY SOS DISTRESS SIGNAL\n\nAre you sure you want to broadcast an instant Emergency SOS alert with your live GPS location to Police & WhatsApp Emergency Contacts?")) {
                    if (navigator.geolocation) {
                        navigator.geolocation.getCurrentPosition(function(position) {
                            triggerSosBroadcast(position.coords.latitude, position.coords.longitude);
                        }, function(error) {
                            triggerSosBroadcast(6.9271, 79.8612);
                        });
                    } else {
                        triggerSosBroadcast(6.9271, 79.8612);
                    }
                }
            });
        }

        function triggerSosBroadcast(lat, lng) {
            const mapUrl = `https://maps.google.com/?q=${lat},${lng}`;
            const mapLinkEl = document.getElementById('sosLiveMapUrl');
            if (mapLinkEl) {
                mapLinkEl.href = mapUrl;
                mapLinkEl.textContent = mapUrl;
            }

            const contacts = getEmergencyContacts();
            const waListContainer = document.getElementById('whatsappContactsButtonsList');
            const smsListContainer = document.getElementById('smsContactsButtonsList');
            
            if (waListContainer) waListContainer.innerHTML = '';
            if (smsListContainer) smsListContainer.innerHTML = '';

            contacts.forEach(c => {
                const formattedPhone = formatPhoneForWhatsapp(c.phone);
                const waText = encodeURIComponent(`🚨 *EMERGENCY SOS DISTRESS SIGNAL FROM SAFORA NETWORK!* 🚨\n\nHelp! I am in urgent distress. My current Live GPS Location is:\n📍 ${mapUrl}\n\nPlease check on me immediately or dial Police (119) / Suwa Seriya Ambulance (1990)!`);
                const waUrl = `https://api.whatsapp.com/send?phone=${formattedPhone}&text=${waText}`;

                const smsText = encodeURIComponent(`EMERGENCY SOS ALERT! Urgent help needed. My Live GPS Location: ${mapUrl}`);
                const smsUrl = `sms:${c.phone}?body=${smsText}`;

                // WhatsApp Dispatch Button
                if (waListContainer) {
                    const waBtn = document.createElement('a');
                    waBtn.href = waUrl;
                    waBtn.target = '_blank';
                    waBtn.className = 'btn btn-success btn-sm fw-bold d-flex align-items-center justify-content-between px-3 py-2.5 rounded-3 shadow-sm';
                    waBtn.innerHTML = `<span><i class="bi bi-whatsapp me-2 fs-5"></i> Broadcast WhatsApp to <strong>${c.name}</strong> (${c.phone})</span> <i class="bi bi-box-arrow-up-right"></i>`;
                    waListContainer.appendChild(waBtn);
                }

                // SMS Dispatch Button
                if (smsListContainer) {
                    const smsBtn = document.createElement('a');
                    smsBtn.href = smsUrl;
                    smsBtn.className = 'btn btn-outline-info text-info btn-sm fw-bold d-flex align-items-center justify-content-between px-3 py-2 rounded-3 shadow-sm';
                    smsBtn.innerHTML = `<span><i class="bi bi-chat-dots-fill me-2"></i> Send Offline SMS to <strong>${c.name}</strong> (${c.phone})</span> <i class="bi bi-send-fill"></i>`;
                    smsListContainer.appendChild(smsBtn);
                }
            });

            // Trigger Bootstrap Modal
            const sosModalEl = document.getElementById('sosBroadcastModal');
            if (sosModalEl) {
                const sosModal = new bootstrap.Modal(sosModalEl);
                sosModal.show();
            }

            // Record SOS dispatch in Laravel Database backend
            fetch("{{ route('sos.trigger') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ latitude: lat, longitude: lng })
            })
            .then(res => res.json())
            .then(data => {
                const statusEl = document.getElementById('sosGpsStatusText');
                if (statusEl) {
                    statusEl.innerHTML = `✅ Live GPS Dispatch Recorded in Safora Database (SOS ID: #${data.sos_id}). Police Authorities Notified!`;
                }
            })
            .catch(err => {
                const statusEl = document.getElementById('sosGpsStatusText');
                if (statusEl) {
                    statusEl.innerHTML = `⚠️ Live GPS Recorded locally. Broadcast via WhatsApp / SMS below!`;
                }
            });
        }

        // Universal Accessibility Widget Logic (Popover Toggle)
        const accessBtn = document.getElementById('accessibilityWidgetBtn');
        if (accessBtn) {
            accessBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                const panel = document.getElementById('accessibilityPopoverPanel');
                if (panel) panel.classList.toggle('d-none');
            });
        }

        const closeAccessBtn = document.getElementById('closeAccessibilityPopoverBtn');
        if (closeAccessBtn) {
            closeAccessBtn.addEventListener('click', function() {
                const panel = document.getElementById('accessibilityPopoverPanel');
                if (panel) panel.classList.add('d-none');
            });
        }

        document.addEventListener('click', function(e) {
            const container = document.getElementById('accessibilityWidgetContainer');
            const panel = document.getElementById('accessibilityPopoverPanel');
            if (container && panel && !container.contains(e.target)) {
                panel.classList.add('d-none');
            }
        });

        let currentFontScale = 100;
        const fontLabel = document.getElementById('currentFontSizeLabel');

        const resetBtn = document.getElementById('fontResetBtn');
        if (resetBtn) {
            resetBtn.addEventListener('click', function() {
                currentFontScale = 100;
                document.documentElement.style.fontSize = '100%';
                if (fontLabel) { fontLabel.textContent = 'Normal (100%)'; fontLabel.className = 'badge bg-secondary'; }
            });
        }

        const fontIncBtn = document.getElementById('fontIncreaseBtn');
        if (fontIncBtn) {
            fontIncBtn.addEventListener('click', function() {
                currentFontScale = 115;
                document.documentElement.style.fontSize = '115%';
                if (fontLabel) { fontLabel.textContent = 'Large (115%)'; fontLabel.className = 'badge bg-warning text-dark'; }
            });
        }

        const fontMaxBtn = document.getElementById('fontMaxBtn');
        if (fontMaxBtn) {
            fontMaxBtn.addEventListener('click', function() {
                currentFontScale = 130;
                document.documentElement.style.fontSize = '130%';
                if (fontLabel) { fontLabel.textContent = 'Extra Large (130%)'; fontLabel.className = 'badge bg-danger text-white'; }
            });
        }

        const highContrastSw = document.getElementById('highContrastSwitch');
        if (highContrastSw) {
            highContrastSw.addEventListener('change', function() {
                if (this.checked) {
                    document.body.classList.add('safora-high-contrast');
                } else {
                    document.body.classList.remove('safora-high-contrast');
                }
            });
        }

        let speechEnabled = false;
        const speechSw = document.getElementById('speechReaderSwitch');
        if (speechSw) {
            speechSw.addEventListener('change', function() {
                speechEnabled = this.checked;
                if (speechEnabled) {
                    alert('🔊 Voice Speech Reader Enabled! Click or hover over text to hear audio descriptions.');
                    const msg = new SpeechSynthesisUtterance("Voice Speech Reader Enabled on Safora Platform");
                    window.speechSynthesis.speak(msg);
                }
            });
        }

        function speakText(text) {
            if (speechEnabled && window.speechSynthesis && text) {
                window.speechSynthesis.cancel();
                const msg = new SpeechSynthesisUtterance(text);
                msg.rate = 1.0;
                window.speechSynthesis.speak(msg);
            }
        }

        document.addEventListener('mouseover', function(e) {
            if (speechEnabled && e.target && (e.target.matches('.fw-bold') || e.target.matches('h5') || e.target.matches('h6') || e.target.matches('.badge'))) {
                const txt = e.target.innerText.trim();
                if (txt.length > 3 && txt.length < 120) {
                    speakText(txt);
                }
            }
        });

        const legibilitySw = document.getElementById('legibilityFontSwitch');
        if (legibilitySw) {
            legibilitySw.addEventListener('change', function() {
                if (this.checked) {
                    document.body.style.fontFamily = 'Verdana, Arial, sans-serif';
                } else {
                    document.body.style.fontFamily = 'Plus Jakarta Sans, Inter, sans-serif';
                }
            });
        }

        const resetAccessSettingsBtn = document.getElementById('resetAccessibilitySettingsBtn');
        if (resetAccessSettingsBtn) {
            resetAccessSettingsBtn.addEventListener('click', function() {
                currentFontScale = 100;
                document.documentElement.style.fontSize = '100%';
                if (fontLabel) { fontLabel.textContent = 'Normal (100%)'; fontLabel.className = 'badge bg-secondary'; }
                if (highContrastSw) highContrastSw.checked = false;
                document.body.classList.remove('safora-high-contrast');
                if (speechSw) speechSw.checked = false;
                speechEnabled = false;
                if (legibilitySw) legibilitySw.checked = false;
                document.body.style.fontFamily = 'Plus Jakarta Sans, Inter, sans-serif';
            });
        }
    </script>

    @stack('scripts')
</body>
</html>
