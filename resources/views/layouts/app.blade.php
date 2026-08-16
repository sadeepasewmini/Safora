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

    <!-- Leaflet.js Map CSS & JS (Local Asset & Cloudflare CDN Fallback) -->
    <link rel="stylesheet" href="{{ asset('vendor/leaflet/leaflet.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.css" />
    <script src="{{ asset('vendor/leaflet/leaflet.js') }}"></script>
    <script>
        if (typeof L === 'undefined') {
            document.write('<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.js"><\/script>');
        }
    </script>

    <!-- Chart.js for AI Risk Trend Analytics -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- SweetAlert2 Beautiful Pop-up Engine -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- AOS (Animate On Scroll) CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" />

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

        /* Floating AI Chatbot Button (Stacking neatly below drawer form with zero overlap) */
        .ai-chatbot-floating-btn {
            position: relative;
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
            box-shadow: 0 14px 35px rgba(245, 158, 11, 0.7);
            background: #0f172a;
            color: #fbbf24;
        }

        /* High-End Glassmorphism AI Chat Drawer Styles */
        .safora-glass-drawer {
            background: rgba(15, 23, 42, 0.96) !important;
            backdrop-filter: blur(20px) !important;
            border: 1px solid rgba(245, 158, 11, 0.35) !important;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.85), 0 0 20px rgba(245, 158, 11, 0.15) !important;
            border-radius: 20px !important;
            overflow: hidden !important;
        }

        .ai-chip-pill {
            background: rgba(30, 41, 59, 0.75);
            border: 1px solid rgba(245, 158, 11, 0.25);
            color: #f1f5f9;
            font-size: 0.73rem;
            font-weight: 500;
            padding: 4px 10px;
            border-radius: 20px;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            backdrop-filter: blur(4px);
        }

        .ai-chip-pill:hover {
            background: rgba(245, 158, 11, 0.2);
            border-color: #f59e0b;
            color: #fbbf24;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(245, 158, 11, 0.2);
        }

        .chat-bubble-bot {
            background: rgba(30, 41, 59, 0.85) !important;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.08) !important;
            color: #f8fafc !important;
            border-radius: 18px 18px 18px 4px !important;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3) !important;
            padding: 10px 14px !important;
        }

        .chat-bubble-user {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%) !important;
            color: #0f172a !important;
            font-weight: 600 !important;
            border-radius: 18px 18px 4px 18px !important;
            box-shadow: 0 4px 12px rgba(245, 158, 11, 0.25) !important;
            padding: 10px 14px !important;
        }

        .ai-chat-input-field {
            background-color: #090d16 !important;
            border: 1px solid rgba(255, 255, 255, 0.12) !important;
            color: #ffffff !important;
            font-size: 0.83rem !important;
            transition: all 0.2s ease;
        }

        .ai-chat-input-field:focus {
            border-color: #f59e0b !important;
            box-shadow: 0 0 15px rgba(245, 158, 11, 0.25) !important;
            background-color: #0b1329 !important;
        }

        .ai-send-btn {
            background: linear-gradient(135deg, #f59e0b 0%, #eab308 100%) !important;
            color: #0f172a !important;
            border: none !important;
            font-weight: 700 !important;
            transition: all 0.2s ease !important;
        }

        .ai-send-btn:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 15px rgba(245, 158, 11, 0.4) !important;
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
        .text-slate-100 { color: #f8fafc !important; }
        .text-slate-200 { color: #f1f5f9 !important; }
        .text-slate-300 { color: #cbd5e1 !important; }
        .text-slate-400 { color: #94a3b8 !important; }

        .text-emerald-400 { color: #34d399 !important; }
        .text-emerald-500 { color: #10b981 !important; }
        .bg-emerald-500 { background-color: #10b981 !important; }
        .text-amber-500 { color: #f59e0b !important; }
        .bg-amber-500 { background-color: #f59e0b !important; }

        .badge-category {
            background-color: #e2e8f0 !important;
            color: #0f172a !important;
            font-weight: 700 !important;
            border: 1px solid #cbd5e1 !important;
            padding: 4px 10px !important;
            border-radius: 6px !important;
        }

        /* Pulsing GPS Location Beacon */
        @keyframes pulse-ring {
            0% { transform: scale(0.5); opacity: 0.9; }
            100% { transform: scale(2.4); opacity: 0; }
        }
        .user-gps-beacon {
            background: transparent !important;
            border: none !important;
        }

        /* Dynamic Keyframe Micro-Animations */
        @keyframes heroFloat {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-12px) rotate(1.2deg); }
        }
        @keyframes floatBob {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-7px); }
        }
        @keyframes sosPulse {
            0% { box-shadow: 0 0 0 0 rgba(220, 38, 38, 0.75); }
            70% { box-shadow: 0 0 0 16px rgba(220, 38, 38, 0); }
            100% { box-shadow: 0 0 0 0 rgba(220, 38, 38, 0); }
        }
        @keyframes goldPulse {
            0% { box-shadow: 0 0 0 0 rgba(245, 158, 11, 0.65); }
            70% { box-shadow: 0 0 0 14px rgba(245, 158, 11, 0); }
            100% { box-shadow: 0 0 0 0 rgba(245, 158, 11, 0); }
        }
        @keyframes badgeGlow {
            0%, 100% { opacity: 1; filter: brightness(1); }
            50% { opacity: 0.85; filter: brightness(1.25); }
        }
        @keyframes spinSlow {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .animate-hero-float { animation: heroFloat 5s ease-in-out infinite; }
        .animate-bob { animation: floatBob 3s ease-in-out infinite; }
        .animate-sos-pulse { animation: sosPulse 1.8s infinite !important; }
        .animate-gold-pulse { animation: goldPulse 2s infinite !important; }
        .animate-badge-glow { animation: badgeGlow 2.5s infinite ease-in-out !important; }
        .animate-spin-slow { animation: spinSlow 12s linear infinite !important; }

        /* Card Hover Lift & Glow Animations */
        .card-animate {
            transition: transform 0.35s cubic-bezier(0.165, 0.84, 0.44, 1), box-shadow 0.35s cubic-bezier(0.165, 0.84, 0.44, 1), border-color 0.3s ease !important;
        }
        .card-animate:hover {
            transform: translateY(-8px) scale(1.01) !important;
            box-shadow: 0 20px 40px -10px rgba(15, 23, 42, 0.25) !important;
        }

        /* Shimmer Button Effect */
        .btn-shimmer {
            position: relative;
            overflow: hidden;
        }
        .btn-shimmer::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -60%;
            width: 50%;
            height: 200%;
            background: linear-gradient(
                to right,
                rgba(255, 255, 255, 0) 0%,
                rgba(255, 255, 255, 0.35) 50%,
                rgba(255, 255, 255, 0) 100%
            );
            transform: rotate(30deg);
            transition: all 0.7s ease;
        }
        .btn-shimmer:hover::after {
            left: 130%;
        }

        /* Map Container */
        #saforaMap {
            height: 520px !important;
            min-height: 520px !important;
            width: 100% !important;
            border-radius: 16px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
            border: 1px solid #cbd5e1;
            position: relative;
            z-index: 1;
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

        /* Red Dot Live GPS Location Marker & Radar Pulse Animation */
        @keyframes pulse-red-dot {
            0% {
                transform: scale(0.95);
                box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.85);
            }
            70% {
                transform: scale(1.08);
                box-shadow: 0 0 0 18px rgba(239, 68, 68, 0);
            }
            100% {
                transform: scale(0.95);
                box-shadow: 0 0 0 0 rgba(239, 68, 68, 0);
            }
        }
        .red-dot-container {
            display: flex;
            align-items: center;
            gap: 6px;
            cursor: pointer;
        }
        .red-dot-core {
            width: 22px;
            height: 22px;
            background-color: #ef4444;
            border: 3px solid #ffffff;
            border-radius: 50%;
            box-shadow: 0 0 14px rgba(239, 68, 68, 0.9), 0 3px 8px rgba(0,0,0,0.3);
            animation: pulse-red-dot 1.5s infinite ease-in-out;
            flex-shrink: 0;
        }
        .red-dot-label {
            background: linear-gradient(135deg, #dc2626 0%, #991b1b 100%);
            color: #ffffff;
            font-size: 11px;
            font-weight: 800;
            padding: 4px 10px;
            border-radius: 14px;
            border: 2px solid #ffffff;
            box-shadow: 0 4px 12px rgba(220, 38, 38, 0.4);
            white-space: nowrap;
            letter-spacing: 0.3px;
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

        /* Comprehensive Mobile Responsiveness Improvements */
        @media (max-width: 768px) {
            .sos-floating-btn {
                width: 56px !important;
                height: 56px !important;
                font-size: 0.85rem !important;
                bottom: 16px !important;
                right: 16px !important;
            }
            .ai-chatbot-floating-btn,
            #accessibilityWidgetBtn {
                width: 56px !important;
                height: 56px !important;
                font-size: 1.4rem !important;
                bottom: 16px !important;
                left: 16px !important;
            }
            #aiChatbotFloatingContainer,
            #accessibilityWidgetContainer {
                bottom: 16px !important;
                left: 16px !important;
            }
            #aiChatbotFloatingDrawer,
            #accessibilityPopoverPanel {
                width: calc(100vw - 32px) !important;
                max-width: 360px !important;
            }
            #saforaMap {
                height: 400px !important;
                min-height: 400px !important;
            }
            .navbar-safora .brand-logo {
                font-size: 1.2rem !important;
            }
            .eval-bar {
                font-size: 0.75rem !important;
            }
            footer {
                padding-bottom: 85px !important;
            }
            .card-pro {
                padding: 1rem !important;
            }
            .display-2 {
                font-size: 2.75rem !important;
            }
            .display-4 {
                font-size: 2.2rem !important;
            }
            .display-5 {
                font-size: 1.8rem !important;
            }
        }

        /* Mobile Navigation Responsive Drawer (Under 992px) */
        @media (max-width: 991.98px) {
            .navbar-collapse {
                background-color: #0f172a !important;
                border: 1px solid #1e293b !important;
                border-radius: 16px !important;
                padding: 1.25rem !important;
                margin-top: 0.75rem !important;
                box-shadow: 0 20px 40px rgba(0, 0, 0, 0.75) !important;
            }
            .navbar-nav {
                align-items: stretch !important;
                gap: 0.5rem !important;
            }
            .navbar-nav .nav-item {
                width: 100% !important;
                text-align: left !important;
                margin-left: 0 !important;
                margin-right: 0 !important;
            }
            .navbar-nav .nav-link-custom {
                display: flex !important;
                align-items: center !important;
                padding: 0.75rem 1rem !important;
                border-radius: 12px !important;
                color: #f1f5f9 !important;
                font-weight: 600 !important;
                font-size: 0.95rem !important;
                background-color: #1e293b !important;
                border: 1px solid #334155 !important;
                transition: all 0.2s ease !important;
            }
            .navbar-nav .nav-link-custom:hover, 
            .navbar-nav .nav-link-custom:focus {
                background-color: rgba(245, 158, 11, 0.15) !important;
                color: #f59e0b !important;
                border-color: #f59e0b !important;
                padding-left: 1.25rem !important;
            }
            .w-100-mobile {
                width: 100% !important;
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
                padding: 0.75rem 1rem !important;
                font-size: 0.95rem !important;
                border-radius: 12px !important;
                margin: 0.3rem 0 !important;
            }
        }
    </style>
</head>
<body>

    <!-- Main Header Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark navbar-safora sticky-top">
        <div class="container">
            <a class="brand-logo me-4 d-inline-flex align-items-center gap-2 text-decoration-none" href="{{ route('home') }}">
                <span class="fw-extrabold text-white" style="letter-spacing: -0.5px;">SAFORA<span class="text-warning">.LK</span></span>
            </a>
            
            <!-- Mobile Offcanvas Trigger Button (Slides in from side) -->
            <button class="navbar-toggler border-0 p-2 rounded-3 bg-slate-800 border-slate-700 shadow-sm d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileNavOffcanvas" aria-controls="mobileNavOffcanvas" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Desktop Header Menu (lg screens) -->
            <div class="collapse navbar-collapse d-none d-lg-flex" id="navMenu">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-lg-center">
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom" href="{{ route('home') }}"><i class="bi bi-house-door me-2 text-warning"></i> Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom" href="{{ route('home') }}#mapSection"><i class="bi bi-map me-2 text-info"></i> Safety Map</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom" href="{{ route('home') }}#reportSection"><i class="bi bi-plus-circle me-2 text-danger"></i> Report Hazard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom" href="{{ route('home') }}#safePlacesSection"><i class="bi bi-hospital me-2 text-emerald-400"></i> Safe Places</a>
                    </li>
                    <li class="nav-item">
                        <button type="button" class="btn btn-sm btn-outline-warning text-warning px-3 py-2 ms-lg-2 rounded-3" data-bs-toggle="modal" data-bs-target="#emergencyContactsModal">
                            <i class="bi bi-telephone-plus me-1"></i> SOS Contacts
                        </button>
                    </li>

                    @auth
                        <li class="nav-item ms-lg-3">
                            <a class="btn btn-sm btn-warning text-dark fw-bold px-3 py-2 me-lg-2" href="{{ route('dashboard') }}">
                                <i class="bi bi-speedometer2 me-1"></i> Dashboard ({{ ucfirst(Auth::user()->role) }})
                            </a>
                        </li>
                        <li class="nav-item">
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-outline-light px-3 py-2">
                                    <i class="bi bi-box-arrow-right me-1"></i> Logout
                                </button>
                            </form>
                        </li>
                    @else
                        <li class="nav-item ms-lg-3">
                            <a class="btn btn-sm btn-warning text-dark fw-bold px-4 py-2 me-lg-2" href="{{ route('login') }}">
                                <i class="bi bi-box-arrow-in-right me-1"></i> Sign In
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-sm btn-outline-light px-3 py-2" href="{{ route('register') }}">
                                <i class="bi bi-person-plus me-1"></i> Register
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Sleek Mobile Offcanvas Side Navigation Drawer (Slides in smoothly from Right) -->
    <div class="offcanvas offcanvas-end text-bg-dark border-start border-slate-800 d-lg-none" tabindex="-1" id="mobileNavOffcanvas" aria-labelledby="mobileNavOffcanvasLabel" style="background-color: #0f172a !important; width: 310px; max-width: 88vw;">
        <div class="offcanvas-header border-bottom border-slate-800 py-3 px-4" style="background-color: #0b1120 !important;">
            <h5 class="offcanvas-title fw-bold text-white d-flex align-items-center gap-2" id="mobileNavOffcanvasLabel">
                <span class="fw-extrabold text-white" style="letter-spacing: -0.5px;">SAFORA<span class="text-warning">.LK</span></span>
            </h5>
            <button type="button" class="btn-close btn-close-white shadow-none" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body p-4 d-flex flex-column justify-content-between">
            <div class="d-flex flex-column gap-2.5">
                <a class="nav-link p-3 rounded-3 text-white fw-semibold d-flex align-items-center gap-3 border border-slate-700 shadow-xs" style="background-color: #1e293b;" href="{{ route('home') }}" data-bs-dismiss="offcanvas">
                    <i class="bi bi-house-door-fill text-warning fs-5"></i> Home
                </a>
                <a class="nav-link p-3 rounded-3 text-white fw-semibold d-flex align-items-center gap-3 border border-slate-700 shadow-xs" style="background-color: #1e293b;" href="{{ route('home') }}#mapSection" data-bs-dismiss="offcanvas">
                    <i class="bi bi-map-fill text-info fs-5"></i> Safety Map
                </a>
                <a class="nav-link p-3 rounded-3 text-white fw-semibold d-flex align-items-center gap-3 border border-slate-700 shadow-xs" style="background-color: #1e293b;" href="{{ route('home') }}#reportSection" data-bs-dismiss="offcanvas">
                    <i class="bi bi-plus-circle-fill text-danger fs-5"></i> Report Hazard
                </a>
                <a class="nav-link p-3 rounded-3 text-white fw-semibold d-flex align-items-center gap-3 border border-slate-700 shadow-xs" style="background-color: #1e293b;" href="{{ route('home') }}#safePlacesSection" data-bs-dismiss="offcanvas">
                    <i class="bi bi-hospital-fill text-emerald-400 fs-5"></i> Safe Places
                </a>
            </div>

            <div class="d-flex flex-column gap-2 pt-4 border-top border-slate-800 mt-auto">
                <button type="button" class="btn btn-outline-warning text-warning fw-bold py-2.5 rounded-3 w-100 shadow-xs" data-bs-toggle="modal" data-bs-target="#emergencyContactsModal" data-bs-dismiss="offcanvas">
                    <i class="bi bi-telephone-plus me-2"></i> SOS Contacts
                </button>

                @auth
                    <a class="btn btn-warning text-dark fw-bold py-2.5 rounded-3 w-100 shadow-xs" href="{{ route('dashboard') }}">
                        <i class="bi bi-speedometer2 me-2"></i> Dashboard ({{ ucfirst(Auth::user()->role) }})
                    </a>
                    <form action="{{ route('logout') }}" method="POST" class="w-100">
                        @csrf
                        <button type="submit" class="btn btn-outline-light fw-semibold py-2.5 rounded-3 w-100 shadow-xs">
                            <i class="bi bi-box-arrow-right me-2"></i> Logout
                        </button>
                    </form>
                @else
                    <a class="btn btn-warning text-dark fw-bold py-2.5 rounded-3 w-100 shadow-xs" href="{{ route('login') }}">
                        <i class="bi bi-box-arrow-in-right me-2"></i> Sign In
                    </a>
                    <a class="btn btn-outline-light fw-semibold py-2.5 rounded-3 w-100 shadow-xs" href="{{ route('register') }}">
                        <i class="bi bi-person-plus me-2"></i> Register
                    </a>
                @endauth
            </div>
        </div>
    </div>

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
        $isLoggedIn = auth()->check();
        $isDashboardRoute = request()->routeIs(['user.dashboard', 'dashboard', 'admin.dashboard', 'authority.dashboard', 'moderator.dashboard']);
        
        // Hide accessibility button when logged into dashboard, showing AI chatbot button in its place
        if ($isLoggedIn || $isDashboardRoute) {
            $showAccessibilityWidget = false;
            $showFloatingChatbot = true;
        } else {
            $showAccessibilityWidget = true;
            $showFloatingChatbot = true;
        }
    @endphp

    @if($showAccessibilityWidget)
    <!-- Floating Universal Accessibility Widget (Fixed Bottom-Left 24px) -->
    <div id="accessibilityWidgetContainer" style="position: fixed !important; bottom: 24px !important; left: 24px !important; z-index: 999999 !important;">
        <!-- Floating Popover Card Drawer anchored directly above button -->
        <div id="accessibilityPopoverPanel" class="card safora-popup-animate text-white border border-warning rounded-4 shadow-2xl mb-3 d-none" style="width: 340px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.85) !important; background-color: #0f172a !important; border: 1px solid #334155 !important;">
            <div class="card-header border-bottom border-slate-700 p-3 bg-slate-900 d-flex align-items-center justify-content-between rounded-top-4">
                <div class="d-flex align-items-center gap-2">
                    <span class="fs-5 text-warning"><i class="bi bi-person-fill-gear"></i></span>
                    <h6 class="fw-bold text-white fs-6 mb-0">Universal Accessibility</h6>
                </div>
                <button type="button" class="btn-close btn-close-white" id="closeAccessibilityPopoverBtn" aria-label="Close"></button>
            </div>
            <div class="card-body p-3 style-caption">
                
                <!-- 1. Text Size Control -->
                <div class="mb-3 p-3 bg-slate-800 rounded-3 border border-slate-700 shadow-sm">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="fw-bold text-white small" style="color: #ffffff !important;"><i class="bi bi-search me-1 text-warning"></i> Text Resizing</span>
                        <span id="currentFontSizeLabel" class="badge bg-warning text-dark fw-bold">Normal (100%)</span>
                    </div>
                    <div class="btn-group w-100" role="group">
                        <button type="button" class="btn btn-outline-light btn-sm fw-bold px-3" id="fontResetBtn">A</button>
                        <button type="button" class="btn btn-outline-warning btn-sm fw-bold px-3" id="fontIncreaseBtn">A+</button>
                        <button type="button" class="btn btn-warning text-dark btn-sm fw-bold px-3" id="fontMaxBtn">A++</button>
                    </div>
                </div>

                <!-- 2. High Contrast Mode Toggle -->
                <div class="mb-3 p-3 bg-slate-800 rounded-3 border border-slate-700 d-flex align-items-center justify-content-between shadow-sm">
                    <div class="pe-2">
                        <div class="fw-bold text-white small" style="color: #ffffff !important;"><i class="bi bi-circle-half text-warning me-1.5"></i> High Contrast Mode</div>
                        <div class="lh-sm mt-1" style="font-size: 0.74rem; color: #cbd5e1 !important;">Enhances outdoor sunlight visibility</div>
                    </div>
                    <div class="form-check form-switch mb-0 pe-1">
                        <input class="form-check-input bg-warning border-0" type="checkbox" id="highContrastSwitch" style="width: 2.5em; height: 1.3em; cursor: pointer;">
                    </div>
                </div>

                <!-- 3. Screen Reader Text-To-Speech (TTS) Voice Guide -->
                <div class="mb-3 p-3 bg-slate-800 rounded-3 border border-slate-700 d-flex align-items-center justify-content-between shadow-sm">
                    <div class="pe-2">
                        <div class="fw-bold text-white small" style="color: #ffffff !important;"><i class="bi bi-volume-up-fill text-emerald-400 me-1.5"></i> Voice Speech Reader</div>
                        <div class="lh-sm mt-1" style="font-size: 0.74rem; color: #cbd5e1 !important;">Reads hazard alerts out loud on click/hover</div>
                    </div>
                    <div class="form-check form-switch mb-0 pe-1">
                        <input class="form-check-input bg-success border-0" type="checkbox" id="speechReaderSwitch" style="width: 2.5em; height: 1.3em; cursor: pointer;">
                    </div>
                </div>

                <!-- 4. Dyslexia / High Legibility Font Mode -->
                <div class="mb-3 p-3 bg-slate-800 rounded-3 border border-slate-700 d-flex align-items-center justify-content-between shadow-sm">
                    <div class="pe-2">
                        <div class="fw-bold text-white small" style="color: #ffffff !important;"><i class="bi bi-fonts text-info me-1.5"></i> High-Legibility Font</div>
                        <div class="lh-sm mt-1" style="font-size: 0.74rem; color: #cbd5e1 !important;">Switches to high-readability font style</div>
                    </div>
                    <div class="form-check form-switch mb-0 pe-1">
                        <input class="form-check-input bg-info border-0" type="checkbox" id="legibilityFontSwitch" style="width: 2.5em; height: 1.3em; cursor: pointer;">
                    </div>
                </div>

                <!-- Reset Button -->
                <button type="button" class="btn btn-outline-warning text-warning fw-bold btn-sm w-100 rounded-3 py-2 border-warning" id="resetAccessibilitySettingsBtn" style="transition: all 0.2s ease;">
                    <i class="bi bi-arrow-counterclockwise me-1"></i> Reset Accessibility Options
                </button>

            </div>
        </div>

        <!-- Floating Trigger Button -->
        <button type="button" class="btn btn-warning text-dark fw-bold shadow-lg rounded-circle p-0 d-flex align-items-center justify-content-center" id="accessibilityWidgetBtn" title="Universal Accessibility Options" style="width: 68px; height: 68px; font-size: 1.8rem; border: 3px solid #ffffff !important; box-shadow: 0 10px 20px rgba(0,0,0,0.4) !important; transition: all 0.2s ease;">
            ♿
        </button>
    </div>
    @endif

    @if($showFloatingChatbot)
    <!-- Floating AI Chatbot Button & Popover Chat Drawer (Positioned dynamically on bottom-left) -->
    <div id="aiChatbotFloatingContainer" style="position: fixed !important; bottom: 24px !important; left: {{ $showAccessibilityWidget ? '104px' : '24px' }} !important; z-index: 999998 !important;">
        <!-- Floating Popover Chat Drawer (High-End Modern Glassmorphic Design) -->
        <div id="aiChatbotFloatingDrawer" class="card safora-popup-animate safora-glass-drawer mb-3 d-none" style="width: 365px; max-width: 92vw;">
            <!-- Header -->
            <div class="card-header bg-slate-900 border-bottom border-slate-800 p-3 d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2.5">
                    <div class="position-relative">
                        <img src="/images/ai-avatar.png" alt="Safora AI" class="rounded-circle border border-warning shadow" style="width: 42px; height: 42px; object-fit: cover;">
                        <span class="position-absolute bottom-0 end-0 bg-success border border-dark rounded-circle p-1" style="width: 10px; height: 10px;"></span>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-0 text-white font-outfit" style="font-size: 0.95rem;">Safora AI Safety Companion</h6>
                        <small class="text-emerald-400 d-flex align-items-center gap-1.5" style="font-size: 0.72rem; font-weight: 500;">
                            <span class="spinner-grow spinner-grow-sm text-success" style="width: 6px; height: 6px;"></span> 24/7 Live AI Assistant
                        </small>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white opacity-75 opacity-100-hover" id="closeAiChatbotFloatingBtn" aria-label="Close"></button>
            </div>

            <!-- Quick Chips (Modern Pills) -->
            <div class="p-2.5 bg-slate-950 border-bottom border-slate-800 d-flex flex-wrap gap-1.5">
                <button type="button" class="ai-chip-pill" onclick="sendGlobalQuickPrompt('What is the emergency hotline for ambulance?')">🚑 Ambulance</button>
                <button type="button" class="ai-chip-pill" onclick="sendGlobalQuickPrompt('Where is the nearest safe place in Colombo?')">📍 Safe Places</button>
                <button type="button" class="ai-chip-pill" onclick="sendGlobalQuickPrompt('How to send emergency SOS distress signal?')">🚨 SOS Guide</button>
                <button type="button" class="ai-chip-pill" onclick="sendGlobalQuickPrompt('What to do during wild elephant encounter?')">🐘 Elephants</button>
                <button type="button" class="ai-chip-pill" onclick="sendGlobalQuickPrompt('First aid for snake bite')">🩺 First Aid</button>
                <button type="button" class="ai-chip-pill" onclick="sendGlobalQuickPrompt('How do I report harassment zone?')">📝 Report</button>
            </div>

            <!-- Messages Body -->
            <div id="globalAiChatMessages" class="p-3 overflow-y-auto" style="height: 310px; background-color: #090d16;">
                <div class="d-flex gap-2 mb-3">
                    <img src="/images/ai-avatar.png" alt="AI" class="rounded-circle border border-warning flex-shrink-0" style="width: 32px; height: 32px; object-fit: cover;">
                    <div class="chat-bubble-bot" style="max-width: 85%;">
                        <div class="fw-bold text-warning small mb-1" style="font-size: 0.75rem;">Safora AI Assistant</div>
                        <p class="mb-0" style="font-size: 0.82rem; line-height: 1.45;">Ayubowan! 👋 Ask me anything about Sri Lanka emergency numbers (119, 1990, 1985, 1938), safe places, or travel safety tips!</p>
                    </div>
                </div>
            </div>

            <!-- Input Box -->
            <div class="card-footer bg-slate-900 border-top border-slate-800 p-2.5">
                <form id="globalAiChatForm" onsubmit="handleGlobalAiChatSubmit(event)" class="d-flex gap-2">
                    <input type="text" id="globalAiChatInput" class="form-control form-control-sm ai-chat-input-field px-3 py-2 rounded-3" placeholder="Ask AI Safety Companion..." required autocomplete="off">
                    <button type="submit" class="btn btn-sm ai-send-btn px-3.5 py-2 rounded-3 d-flex align-items-center justify-content-center">
                        <i class="bi bi-send-fill fs-6"></i>
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

    <!-- Instant Emergency SOS Broadcast Modal (Ultra-Professional Dark Glassmorphism Design) -->
    <div class="modal fade" id="sosBroadcastModal" tabindex="-1" aria-labelledby="sosBroadcastModalLabel" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content safora-glass-drawer border border-danger shadow-2xl overflow-hidden" style="background-color: #0b1329 !important; color: #ffffff !important; border-color: rgba(220, 38, 38, 0.6) !important;">
                <!-- Header -->
                <div class="modal-header border-bottom border-danger p-3" style="background: linear-gradient(135deg, #dc2626 0%, #991b1b 100%) !important;">
                    <h5 class="modal-title fw-bold text-uppercase text-white font-outfit d-flex align-items-center gap-2" id="sosBroadcastModalLabel" style="font-size: 1.05rem;">
                        <i class="bi bi-exclamation-triangle-fill fs-5 animate-sos-pulse text-warning"></i> Emergency SOS Broadcast Activated
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Body -->
                <div class="modal-body p-4 text-center" style="background-color: #0b1329 !important; color: #ffffff !important;">
                    <div class="spinner-grow text-danger mb-3" role="status" style="width: 3.2rem; height: 3.2rem;"></div>
                    <h5 class="fw-bold text-white mb-1 font-outfit">🚨 Live Distress Signal Sent to Authorities!</h5>
                    <p class="small text-slate-300 mb-3" id="sosGpsStatusText" style="color: #cbd5e1 !important;">Broadcasting your exact GPS coordinates to Police Authorities & Emergency Network...</p>
                    
                    <!-- Live GPS Link Box -->
                    <div class="p-3 rounded-3 mb-4 text-start" style="background-color: #0f172a !important; border: 1px solid rgba(245, 158, 11, 0.3) !important;">
                        <div class="small text-warning fw-bold mb-1 d-flex align-items-center gap-1.5"><i class="bi bi-geo-alt-fill text-danger fs-6"></i> Live GPS Location Link:</div>
                        <a id="sosLiveMapUrl" href="#" target="_blank" class="small text-info text-break text-decoration-none fw-semibold">Generating live Google Maps link...</a>
                    </div>

                    <!-- Direct WhatsApp Broadcast Section -->
                    <div class="card p-3 mb-3 text-start shadow-sm" style="background-color: #0f172a !important; border: 1px solid rgba(16, 185, 129, 0.35) !important;">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <span class="fw-bold text-emerald-400 small"><i class="bi bi-whatsapp me-1 text-success fs-6"></i> Direct WhatsApp Broadcast:</span>
                            <span class="badge bg-success text-dark fw-bold px-2.5 py-1">Instant Dispatch</span>
                        </div>
                        <div id="whatsappContactsButtonsList" class="d-grid gap-2">
                            <!-- Populated dynamically via JS -->
                        </div>
                    </div>

                    <!-- Offline SMS Emergency Broadcast Section -->
                    <div class="card p-3 mb-3 text-start shadow-sm" style="background-color: #0f172a !important; border: 1px solid rgba(59, 130, 246, 0.35) !important;">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <span class="fw-bold text-info small"><i class="bi bi-chat-text-fill me-1 text-info fs-6"></i> Offline SMS Emergency Broadcast:</span>
                            <span class="badge bg-info text-dark fw-bold px-2.5 py-1">Offline Gateway</span>
                        </div>
                        <div id="smsContactsButtonsList" class="d-grid gap-2">
                            <!-- Populated dynamically via JS -->
                        </div>
                    </div>

                    <!-- Direct Emergency Hotlines -->
                    <div class="d-flex justify-content-center gap-2 mt-3">
                        <a href="tel:119" class="btn btn-sm btn-danger text-white fw-bold px-3.5 py-2 rounded-3 shadow-sm d-flex align-items-center gap-1.5">
                            <i class="bi bi-telephone-fill"></i> Call 119 Police
                        </a>
                        <a href="tel:1990" class="btn btn-sm btn-warning text-dark fw-bold px-3.5 py-2 rounded-3 shadow-sm d-flex align-items-center gap-1.5">
                            <i class="bi bi-hospital-fill"></i> Call 1990 Ambulance
                        </a>
                    </div>
                </div>

                <!-- Footer -->
                <div class="modal-footer p-3 border-top border-slate-800 justify-content-between" style="background-color: #090d16 !important;">
                    <span class="small text-slate-400" style="color: #94a3b8 !important;"><i class="bi bi-shield-check text-emerald-400 me-1"></i> Safora 24/7 Safety Network</span>
                    <button type="button" class="btn btn-sm btn-outline-light px-3 rounded-3" data-bs-dismiss="modal">Close</button>
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
                const response = await fetch("{{ route('ai.chat') }}", {
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
                    <img src="/images/ai-avatar.png" alt="AI" class="rounded-circle border border-warning flex-shrink-0" style="width: 30px; height: 30px; object-fit: cover;">
                    <div class="chat-bubble-bot" style="max-width: 85%;">
                        <div class="fw-bold text-warning small mb-1" style="font-size: 0.75rem;">Safora AI Assistant</div>
                        <div class="small" style="font-size: 0.82rem; line-height: 1.45;">${text}</div>
                    </div>
                `;
            } else {
                msgDiv.innerHTML = `
                    <div class="chat-bubble-user" style="max-width: 85%; font-size: 0.82rem;">
                        ${text}
                    </div>
                    <div class="p-1.5 bg-slate-800 text-warning border border-slate-700 rounded-circle fw-bold d-flex align-items-center justify-content-center flex-shrink-0 shadow-sm" style="width: 30px; height: 30px; font-size: 0.8rem;">👤</div>
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
                <img src="/images/ai-avatar.png" alt="AI" class="rounded-circle border border-warning flex-shrink-0" style="width: 30px; height: 30px; object-fit: cover;">
                <div class="chat-bubble-bot text-slate-400 small d-flex align-items-center gap-2" style="font-size: 0.8rem;">
                    <span>Safora AI is thinking...</span>
                    <span class="spinner-grow spinner-grow-sm text-warning" style="width: 8px; height: 8px;"></span>
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
            if (typeof SaforaAlert !== 'undefined' && SaforaAlert) {
                SaforaAlert.fire({
                    icon: 'success',
                    title: 'Emergency Contacts Saved!',
                    text: 'When you press the Red SOS Button, live GPS location WhatsApp & SMS alerts will be broadcasted to these saved contacts.',
                    confirmButtonText: 'Great!',
                    confirmButtonColor: '#10b981'
                });
            } else {
                alert("✅ Emergency Contacts Saved Successfully!");
            }
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

        // Emergency SOS Listener with Instant WhatsApp & SMS Broadcast (SweetAlert2 Pop-up Confirmation)
        const sosTriggerBtn = document.getElementById('sosTriggerBtn');
        if (sosTriggerBtn) {
            sosTriggerBtn.addEventListener('click', function(e) {
                if (e) e.preventDefault();
                
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        title: '🚨 EMERGENCY SOS DISTRESS SIGNAL',
                        html: `
                            <div class="p-2 text-start">
                                <p class="fs-6 fw-semibold text-danger mb-2">
                                    <i class="bi bi-exclamation-triangle-fill me-1"></i> Are you sure you want to broadcast an Emergency SOS alert?
                                </p>
                                <p class="small text-slate-300 mb-0">
                                    This will instantly dispatch your live GPS location to Police Authorities & broadcast WhatsApp/SMS alerts to your emergency contacts.
                                </p>
                            </div>
                        `,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#dc2626',
                        cancelButtonColor: '#475569',
                        confirmButtonText: '🚨 YES, BROADCAST SOS NOW',
                        cancelButtonText: 'Cancel',
                        background: '#0f172a',
                        color: '#ffffff',
                        customClass: {
                            popup: 'border border-danger rounded-4 shadow-2xl',
                            confirmButton: 'btn btn-danger fw-bold px-4 py-2 rounded-3 fs-6 shadow-sm',
                            cancelButton: 'btn btn-secondary fw-bold px-4 py-2 rounded-3 fs-6 me-2'
                        },
                        buttonsStyling: false
                    }).then((result) => {
                        if (result.isConfirmed) {
                            executeSosTrigger();
                        }
                    });
                } else {
                    if (confirm("🚨 EMERGENCY SOS DISTRESS SIGNAL\n\nAre you sure you want to broadcast an instant Emergency SOS alert with your live GPS location to Police & WhatsApp Emergency Contacts?")) {
                        executeSosTrigger();
                    }
                }
            });
        }

        function executeSosTrigger() {
            // Default fallback location (Colombo Central default)
            let defaultLat = 6.9271;
            let defaultLng = 79.8612;

            // Trigger instant broadcast modal immediately so user never hangs waiting for GPS
            triggerSosBroadcast(defaultLat, defaultLng);

            // Concurrently refine with live GPS coordinates if available (3s timeout for HTTP IP connections)
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        triggerSosBroadcast(position.coords.latitude, position.coords.longitude);
                    },
                    function(error) {
                        console.warn("GPS lookup timeout/blocked on HTTP IP, fallback coordinates used:", error.message);
                    },
                    { timeout: 3000, maximumAge: 60000, enableHighAccuracy: false }
                );
            }
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
                    waBtn.className = 'btn btn-sm text-white fw-bold d-flex align-items-center justify-content-between px-3.5 py-2.5 rounded-3 shadow-sm border-0';
                    waBtn.style.cssText = 'background: linear-gradient(135deg, #10b981 0%, #059669 100%) !important; transition: transform 0.2s ease;';
                    waBtn.innerHTML = `<span><i class="bi bi-whatsapp me-2 fs-5"></i> Broadcast WhatsApp to <strong>${c.name}</strong> (${c.phone})</span> <i class="bi bi-box-arrow-up-right"></i>`;
                    waListContainer.appendChild(waBtn);
                }

                // SMS Dispatch Button
                if (smsListContainer) {
                    const smsBtn = document.createElement('a');
                    smsBtn.href = smsUrl;
                    smsBtn.className = 'btn btn-sm text-white fw-bold d-flex align-items-center justify-content-between px-3.5 py-2.5 rounded-3 shadow-sm border-0';
                    smsBtn.style.cssText = 'background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%) !important; transition: transform 0.2s ease;';
                    smsBtn.innerHTML = `<span><i class="bi bi-chat-dots-fill me-2 fs-6"></i> Send Offline SMS to <strong>${c.name}</strong> (${c.phone})</span> <i class="bi bi-send-fill"></i>`;
                    smsListContainer.appendChild(smsBtn);
                }
            });

            // Trigger Bootstrap Modal securely
            const sosModalEl = document.getElementById('sosBroadcastModal');
            if (sosModalEl) {
                const sosModal = bootstrap.Modal.getOrCreateInstance(sosModalEl);
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
                    statusEl.innerHTML = `<span class="text-emerald-400 fw-bold" style="color: #34d399 !important;"><i class="bi bi-check-circle-fill me-1"></i> Live GPS Dispatch Recorded in Safora Database (SOS ID: #${data.sos_id}). Police Authorities Notified!</span>`;
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
                    if (typeof SaforaToast !== 'undefined' && SaforaToast) {
                        SaforaToast.fire({
                            icon: 'info',
                            title: '🔊 Voice Speech Reader Enabled! Hover or click text to hear audio.'
                        });
                    }
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

    <!-- SweetAlert2 Beautiful Pop-Up Notification Engine Setup -->
    <script>
        // Global Safora SweetAlert Dark Slate Mixins
        const SaforaToast = (typeof Swal !== 'undefined') ? Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 4000,
            timerProgressBar: true,
            background: '#0f172a',
            color: '#f8fafc',
            customClass: {
                popup: 'border border-slate-700 shadow-2xl rounded-4'
            },
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer);
                toast.addEventListener('mouseleave', Swal.resumeTimer);
            }
        }) : null;

        const SaforaAlert = (typeof Swal !== 'undefined') ? Swal.mixin({
            background: '#0f172a',
            color: '#f8fafc',
            confirmButtonColor: '#f59e0b',
            cancelButtonColor: '#475569',
            customClass: {
                popup: 'border border-slate-700 shadow-2xl rounded-4 text-white p-4',
                title: 'fw-bold text-white fs-4',
                confirmButton: 'btn btn-warning text-dark fw-bold px-4 py-2 rounded-3 shadow-sm me-2',
                cancelButton: 'btn btn-outline-light px-4 py-2 rounded-3'
            }
        }) : null;

        // Override standard JS window.alert with SweetAlert Pop-up
        if (typeof Swal !== 'undefined') {
            window.nativeAlert = window.alert;
            window.alert = function(message) {
                SaforaAlert.fire({
                    title: 'Safora Notification',
                    text: message,
                    icon: 'info',
                    confirmButtonText: 'OK'
                });
            };

            window.showSaforaPopup = function(title, text, icon = 'success') {
                SaforaAlert.fire({
                    title: title,
                    text: text,
                    icon: icon,
                    confirmButtonText: 'OK'
                });
            };

            window.showSaforaToast = function(title, icon = 'success') {
                if (SaforaToast) {
                    SaforaToast.fire({
                        icon: icon,
                        title: title
                    });
                }
            };
        }

        // Trigger SweetAlert for Laravel Session Flash Messages
        document.addEventListener('DOMContentLoaded', function() {
            @if(session('success'))
                if (SaforaAlert) {
                    SaforaAlert.fire({
                        icon: 'success',
                        title: 'Action Completed',
                        text: @json(session('success')),
                        confirmButtonText: 'Great!',
                        confirmButtonColor: '#10b981'
                    });
                }
            @endif

            @if(session('error'))
                if (SaforaAlert) {
                    SaforaAlert.fire({
                        icon: 'error',
                        title: 'Attention Required',
                        text: @json(session('error')),
                        confirmButtonText: 'Dismiss',
                        confirmButtonColor: '#dc2626'
                    });
                }
            @endif

            @if(session('warning'))
                if (SaforaAlert) {
                    SaforaAlert.fire({
                        icon: 'warning',
                        title: 'Alert Warning',
                        text: @json(session('warning')),
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#f59e0b'
                    });
                }
            @endif
        });
    </script>

    <!-- AOS (Animate On Scroll) JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof AOS !== 'undefined') {
                AOS.init({
                    duration: 750,
                    once: true,
                    offset: 50,
                    easing: 'ease-out-cubic'
                });
            }
        });
    </script>

    @stack('scripts')
</body>
</html>
