@extends('layouts.app')

@section('content')
<div class="container py-4">
    <!-- Header -->
    <div class="d-flex flex-wrap align-items-center justify-content-between mb-4">
        <div>
            <h2 class="fw-bold mb-1"><i class="bi bi-speedometer2 text-warning me-2"></i>Management Control Dashboard</h2>
            <p class="text-muted mb-0">Active Role: <span class="badge bg-warning text-dark px-3 py-2 text-uppercase fw-bold"><i class="bi bi-person-badge me-1"></i>{{ Auth::user()->role }}</span> ({{ Auth::user()->name }})</p>
        </div>
        <a href="{{ route('home') }}" class="btn btn-outline-dark fw-bold"><i class="bi bi-arrow-left me-1"></i> Public Safety Map</a>
    </div>

    <!-- Stats Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card card-custom p-3 bg-white border-start border-4 border-warning">
                <small class="text-muted text-uppercase fw-semibold">Pending Review Queue</small>
                <div class="display-6 fw-bold text-warning my-1">{{ count($pendingIncidents) }}</div>
                <small class="text-secondary">Requires Moderator action</small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card card-custom p-3 bg-white border-start border-4 border-danger">
                <small class="text-muted text-uppercase fw-semibold">Active Emergency SOS</small>
                <div class="display-6 fw-bold text-danger my-1">{{ count($activeSos) }}</div>
                <small class="text-secondary">Police / Authority dispatch</small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card card-custom p-3 bg-white border-start border-4 border-success">
                <small class="text-muted text-uppercase fw-semibold">Verified Live Hazards</small>
                <div class="display-6 fw-bold text-success my-1">{{ count($verifiedIncidents) }}</div>
                <small class="text-secondary">Published on public map</small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card card-custom p-3 bg-white border-start border-4 border-dark">
                <small class="text-muted text-uppercase fw-semibold">Total Registered Users</small>
                <div class="display-6 fw-bold text-dark my-1">{{ count($users) }}</div>
                <small class="text-secondary">Multi-role platform users</small>
            </div>
        </div>
    </div>

    <!-- Tabbed Navigation Bar -->
    <ul class="nav nav-pills mb-4 bg-white p-2 rounded-3 shadow-sm" id="dashboardTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link {{ (Auth::user()->role === 'public_user' || Auth::user()->role === 'user') ? 'active' : '' }} fw-bold me-2 bg-warning text-dark shadow-sm" id="chatbot-tab" data-bs-toggle="tab" data-bs-target="#chatbot" type="button" role="tab">
                🤖 Safora AI Safety Companion
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link {{ (Auth::user()->role !== 'public_user' && Auth::user()->role !== 'user') ? 'active' : '' }} fw-bold me-2" id="verification-tab" data-bs-toggle="tab" data-bs-target="#verification" type="button" role="tab">
                <i class="bi bi-shield-check me-1"></i> Report Verification Queue ({{ count($pendingIncidents) }})
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link fw-bold me-2 text-danger" id="sos-tab" data-bs-toggle="tab" data-bs-target="#sos" type="button" role="tab">
                <i class="bi bi-bell-fill me-1"></i> Emergency SOS Queue ({{ count($activeSos) }})
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link fw-bold me-2" id="alerts-tab" data-bs-toggle="tab" data-bs-target="#alerts" type="button" role="tab">
                <i class="bi bi-broadcast me-1"></i> Community Safety Alerts
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link fw-bold me-2" id="analytics-tab" data-bs-toggle="tab" data-bs-target="#analytics" type="button" role="tab">
                <i class="bi bi-pie-chart-fill me-1"></i> Analytics & Risk Insights
            </button>
        </li>
        @if(Auth::user()->isAdmin())
        <li class="nav-item" role="presentation">
            <button class="nav-link fw-bold" id="users-tab" data-bs-toggle="tab" data-bs-target="#users" type="button" role="tab">
                <i class="bi bi-people-fill me-1"></i> Manage Users
            </button>
        </li>
        @endif
    </ul>

    <!-- Tab Content Sections -->
    <div class="tab-content" id="dashboardTabsContent">

        <!-- Public User AI Safety Chatbot Tab -->
        <div class="tab-pane fade {{ (Auth::user()->role === 'public_user' || Auth::user()->role === 'user') ? 'show active' : '' }}" id="chatbot" role="tabpanel">
            <div id="aiChatbotContainer" class="card card-custom p-0 border-0 shadow-lg rounded-4 overflow-hidden mb-4" style="background-color: #0f172a !important;">
                <!-- Chat Header -->
                <div class="p-3 bg-slate-800 border-bottom border-slate-700 d-flex align-items-center justify-content-between text-white">
                    <div class="d-flex align-items-center gap-2">
                        <img src="/images/ai-avatar.png" alt="Safora AI Avatar" class="rounded-circle border border-warning shadow-sm" style="width: 44px; height: 44px; object-fit: cover;">
                        <div>
                            <h5 class="fw-bold mb-0 text-white">Safora AI Safety Assistant</h5>
                            <small class="text-emerald-400 d-flex align-items-center gap-1" style="font-size: 0.75rem;">
                                <span class="spinner-grow spinner-grow-sm text-success" style="width: 8px; height: 8px;"></span> 24/7 Interactive Safety Bot (Public User Exclusive)
                            </small>
                        </div>
                    </div>
                    <span class="badge bg-slate-700 text-warning border border-warning px-3 py-2 rounded-pill">Sri Lanka Safety AI</span>
                </div>

                <!-- Quick Prompt Chips -->
                <div class="p-3 bg-slate-900 border-bottom border-slate-800 d-flex gap-2 overflow-x-auto" style="scrollbar-width: thin;">
                    <button type="button" class="btn btn-sm btn-outline-warning text-nowrap rounded-pill px-3" onclick="sendQuickPrompt('What is the emergency hotline for ambulance?')">🚑 Ambulance Hotline</button>
                    <button type="button" class="btn btn-sm btn-outline-info text-nowrap rounded-pill px-3" onclick="sendQuickPrompt('Where is the nearest safe place in Colombo?')">📍 Nearest Safe Place</button>
                    <button type="button" class="btn btn-sm btn-outline-danger text-nowrap rounded-pill px-3" onclick="sendQuickPrompt('How to send emergency SOS distress signal?')">🚨 How to send SOS</button>
                    <button type="button" class="btn btn-sm btn-outline-light text-nowrap rounded-pill px-3" onclick="sendQuickPrompt('What to do during wild elephant encounter?')">🐘 Elephant Safety</button>
                    <button type="button" class="btn btn-sm btn-outline-warning text-nowrap rounded-pill px-3" onclick="sendQuickPrompt('How do I report harassment zone?')">📝 Report Harassment</button>
                </div>

                <!-- Chat Messages Body -->
                <div id="aiChatMessages" class="p-4 overflow-y-auto" style="height: 380px; background-color: #0b1329;">
                    <!-- Welcome Bot Message -->
                    <div class="d-flex gap-2 mb-3">
                        <img src="/images/ai-avatar.png" alt="Safora AI Avatar" class="rounded-circle border border-warning flex-shrink-0" style="width: 36px; height: 36px; object-fit: cover;">
                        <div class="p-3 rounded-4 bg-slate-800 text-white border border-slate-700 shadow-sm" style="max-width: 80%;">
                            <div class="fw-bold text-warning small mb-1">Safora AI Safety Bot</div>
                            <p class="mb-0 small">Ayubowan {{ Auth::user()->name }}! 👋 Welcome to your public user safety dashboard. I am your 24/7 AI Companion. Ask me anything about Sri Lanka emergency hotlines (119, 1990, 1985, 1938), safe places, reporting hazards, or travel precautions!</p>
                        </div>
                    </div>
                </div>

                <!-- Chat Input Form -->
                <div class="p-3 bg-slate-800 border-top border-slate-700">
                    <form id="aiChatForm" onsubmit="handleAiChatSubmit(event)" class="d-flex gap-2">
                        <input type="text" id="aiChatInput" class="form-control bg-slate-900 text-white border-slate-700 py-2.5 px-3 rounded-3" placeholder="Type your safety question here (e.g. 'police hotline', 'safe places in Galle')..." required autocomplete="off">
                        <button type="submit" class="btn btn-warning text-dark fw-bold px-4 py-2.5 rounded-3 d-flex align-items-center gap-2">
                            <span>Send</span> <i class="bi bi-send-fill"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- 1. Moderator Incident Verification Queue -->
        <div class="tab-pane fade {{ (Auth::user()->role !== 'public_user' && Auth::user()->role !== 'user') ? 'show active' : '' }}" id="verification" role="tabpanel">
            <div class="card card-custom p-4 border bg-white">
                <h4 class="fw-bold mb-3"><i class="bi bi-check2-square text-warning me-2"></i>Pending Incident Verification Queue</h4>
                <p class="text-muted small">Moderators verify authenticity before publishing incidents on the public safety map to eliminate fake reports.</p>

                @if(count($pendingIncidents) === 0)
                    <div class="alert alert-success border-0 text-center py-4">
                        <i class="bi bi-check-circle fs-1 text-success d-block mb-2"></i>
                        <h5 class="fw-bold mb-1">Queue is clear!</h5>
                        <p class="mb-0 text-muted">No pending incident reports require verification at the moment.</p>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Title & Category</th>
                                    <th>Area / Location</th>
                                    <th>Severity</th>
                                    <th>Reported By</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pendingIncidents as $inc)
                                <tr>
                                    <td><strong>#{{ $inc->id }}</strong></td>
                                    <td>
                                        <div class="fw-bold text-dark">{{ $inc->title }}</div>
                                        <span class="badge bg-secondary">{{ $inc->category->name }}</span>
                                    </td>
                                    <td><i class="bi bi-geo-alt me-1"></i>{{ $inc->area_name }}</td>
                                    <td>
                                        <span class="badge {{ $inc->severity == 'critical' ? 'bg-danger' : ($inc->severity == 'high' ? 'bg-warning text-dark' : 'bg-info text-dark') }}">
                                            {{ strtoupper($inc->severity) }}
                                        </span>
                                    </td>
                                    <td>{{ $inc->user ? $inc->user->name : 'Public User' }}</td>
                                    <td><small class="text-muted">{{ $inc->created_at->diffForHumans() }}</small></td>
                                    <td>
                                        <div class="d-flex gap-1">
                                            <form action="{{ route('incidents.update-status', $inc->id) }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="status" value="verified">
                                                <button type="submit" class="btn btn-sm btn-success fw-semibold">
                                                    <i class="bi bi-check-lg"></i> Approve & Publish
                                                </button>
                                            </form>
                                            <form action="{{ route('incidents.update-status', $inc->id) }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="status" value="rejected">
                                                <button type="submit" class="btn btn-sm btn-outline-danger fw-semibold">
                                                    <i class="bi bi-x-lg"></i> Reject Fake
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>

        <!-- 2. Emergency SOS Queue -->
        <div class="tab-pane fade" id="sos" role="tabpanel">
            <div class="card card-custom p-4 border bg-white border-start border-4 border-danger">
                <h4 class="fw-bold text-danger mb-3"><i class="bi bi-exclamation-triangle-fill me-2"></i>Live Emergency SOS Alerts Queue</h4>
                <p class="text-muted small">Authorities and Police units can track instant live GPS locations transmitted by citizens in distress.</p>

                @if(count($activeSos) === 0)
                    <div class="alert alert-light text-center py-4 border">
                        <i class="bi bi-shield-check fs-1 text-success d-block mb-2"></i>
                        <h5 class="fw-bold mb-1">No Active Emergencies</h5>
                        <p class="mb-0 text-muted">All previous SOS distress requests have been dispatched and resolved.</p>
                    </div>
                @else
                    <div class="row g-3">
                        @foreach($activeSos as $sos)
                        <div class="col-md-6">
                            <div class="card border-danger p-3 bg-danger bg-opacity-10 rounded-3">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <h5 class="fw-bold text-danger mb-0">🚨 SOS Triggered by {{ $sos->user_name }}</h5>
                                        <small class="text-muted"><i class="bi bi-telephone-fill text-success me-1"></i>Contact: {{ $sos->user_phone }}</small>
                                    </div>
                                    <span class="badge bg-danger animate-pulse">ACTIVE EMERGENCY</span>
                                </div>
                                <p class="small mb-2"><strong>📍 GPS Coordinates:</strong> {{ $sos->latitude }}, {{ $sos->longitude }} ({{ $sos->address }})</p>
                                <div class="d-flex justify-content-between align-items-center pt-2 border-top border-danger border-opacity-25">
                                    <a href="https://maps.google.com/?q={{ $sos->latitude }},{{ $sos->longitude }}" target="_blank" class="btn btn-sm btn-outline-danger fw-bold">
                                        <i class="bi bi-map me-1"></i> Track Live Location
                                    </a>
                                    <form action="{{ route('sos.resolve', $sos->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success fw-bold">
                                            <i class="bi bi-check-circle me-1"></i> Mark Resolved
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <!-- 3. Community Safety Alerts Form -->
        <div class="tab-pane fade" id="alerts" role="tabpanel">
            <div class="card card-custom p-4 border bg-white">
                <div class="row gy-4">
                    <div class="col-lg-5">
                        <h5 class="fw-bold mb-3"><i class="bi bi-broadcast text-warning me-2"></i>Publish Community Alert</h5>
                        <form action="{{ route('alerts.create') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Alert Title</label>
                                <input type="text" name="title" class="form-control" placeholder="e.g. 🐘 Wild Elephant Crossing Alert" required>
                            </div>
                            <div class="row g-2 mb-3">
                                <div class="col-6">
                                    <label class="form-label fw-semibold">Category</label>
                                    <select name="category" class="form-select" required>
                                        <option value="wildlife">🐘 Wildlife Hazard</option>
                                        <option value="crime">🚔 Crime Alert</option>
                                        <option value="weather">🌧️ Weather / Disaster</option>
                                        <option value="road_closure">🚗 Road Closure</option>
                                    </select>
                                </div>
                                <div class="col-6">
                                    <label class="form-label fw-semibold">Severity</label>
                                    <select name="severity" class="form-select" required>
                                        <option value="warning" selected>Warning</option>
                                        <option value="danger">Danger</option>
                                        <option value="critical">Critical</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Target Area / Region</label>
                                <input type="text" name="area_name" class="form-control" placeholder="e.g. Habarana Highway / Bentota" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Alert Message</label>
                                <textarea name="message" class="form-control" rows="3" placeholder="Clear advisory instructions for citizens..." required></textarea>
                            </div>
                            <button type="submit" class="btn btn-warning w-100 fw-bold py-2"><i class="bi bi-megaphone-fill me-1"></i> Broadcast Alert</button>
                        </form>
                    </div>

                    <div class="col-lg-7">
                        <h5 class="fw-bold mb-3">Active Broadcasted Alerts</h5>
                        <div class="list-group">
                            @foreach($alerts as $alert)
                            <div class="list-group-item list-group-item-action d-flex justify-content-between align-items-start border rounded-3 mb-2 p-3">
                                <div>
                                    <div class="d-flex align-items-center mb-1">
                                        <h6 class="fw-bold mb-0 me-2">{{ $alert->title }}</h6>
                                        <span class="badge bg-{{ $alert->severity == 'danger' ? 'danger' : 'warning text-dark' }}">{{ strtoupper($alert->category) }}</span>
                                    </div>
                                    <p class="small text-muted mb-1">{{ $alert->message }}</p>
                                    <small class="text-secondary"><i class="bi bi-geo-alt me-1"></i>{{ $alert->area_name }} | {{ $alert->created_at->diffForHumans() }}</small>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 4. Analytics & Risk Insights -->
        <div class="tab-pane fade" id="analytics" role="tabpanel">
            <div class="card card-custom p-4 border bg-white">
                <h4 class="fw-bold mb-3"><i class="bi bi-graph-up text-primary me-2"></i>Analytics & Hazard Distribution</h4>
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="card p-3 border">
                            <h6 class="fw-bold mb-3">Incident Categories Breakdown</h6>
                            <canvas id="categoryChart" style="max-height: 280px;"></canvas>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card p-3 border">
                            <h6 class="fw-bold mb-3">Report Status Breakdown (Pending vs Verified)</h6>
                            <canvas id="statusChart" style="max-height: 280px;"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 5. User Management (Admin Only) -->
        @if(Auth::user()->isAdmin())
        <div class="tab-pane fade" id="users" role="tabpanel">
            <div class="card card-custom p-4 border bg-white">
                <h4 class="fw-bold mb-3"><i class="bi bi-people-fill text-dark me-2"></i>System Users & Role Management</h4>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Role</th>
                                <th>Joined</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $u)
                            <tr>
                                <td><strong class="text-dark">{{ $u->name }}</strong></td>
                                <td>{{ $u->email }}</td>
                                <td>{{ $u->phone ?? 'N/A' }}</td>
                                <td>
                                    <span class="badge {{ $u->role == 'admin' ? 'bg-danger' : ($u->role == 'moderator' ? 'bg-warning text-dark' : ($u->role == 'authority' ? 'bg-info text-dark' : 'bg-secondary')) }}">
                                        {{ strtoupper($u->role) }}
                                    </span>
                                </td>
                                <td><small class="text-muted">{{ $u->created_at->format('Y-m-d') }}</small></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif

    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Category Chart
    const catLabels = @json($categoryBreakdown->pluck('name'));
    const catCounts = @json($categoryBreakdown->pluck('incidents_count'));

    new Chart(document.getElementById('categoryChart'), {
        type: 'doughnut',
        data: {
            labels: catLabels,
            datasets: [{
                data: catCounts,
                backgroundColor: ['#d97706', '#dc2626', '#0284c7', '#16a34a', '#4b5563', '#8b5cf6']
            }]
        }
    });

    // Status Chart
    const statusData = @json($statusCounts);
    new Chart(document.getElementById('statusChart'), {
        type: 'bar',
        data: {
            labels: Object.keys(statusData),
            datasets: [{
                label: 'Incidents Count',
                data: Object.values(statusData),
                backgroundColor: ['#f59e0b', '#16a34a', '#2563eb', '#ef4444']
            }]
        }
    });

    // Public User AI Safety Chatbot Logic
    function sendQuickPrompt(promptText) {
        const input = document.getElementById('aiChatInput');
        if (input) {
            input.value = promptText;
            handleAiChatSubmit(new Event('submit'));
        }
    }

    async function handleAiChatSubmit(e) {
        if (e && e.preventDefault) e.preventDefault();
        const input = document.getElementById('aiChatInput');
        if (!input) return;
        const query = input.value.trim();
        if (!query) return;

        // Append User Message
        appendMessage('user', query);
        input.value = '';

        // Show Typing Indicator
        showTypingIndicator();

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
            removeTypingIndicator();
            if (data && data.reply) {
                appendMessage('bot', data.reply);
            } else {
                appendMessage('bot', generateAiResponse(query));
            }
        } catch (err) {
            removeTypingIndicator();
            appendMessage('bot', generateAiResponse(query));
        }
    }

    function appendMessage(sender, text) {
        const container = document.getElementById('aiChatMessages');
        if (!container) return;
        const msgDiv = document.createElement('div');
        msgDiv.className = 'd-flex gap-2 mb-3 ' + (sender === 'user' ? 'justify-content-end' : '');

        if (sender === 'bot') {
            msgDiv.innerHTML = `
                <img src="/images/ai-avatar.png" alt="Safora AI Avatar" class="rounded-circle border border-warning flex-shrink-0" style="width: 34px; height: 34px; object-fit: cover;">
                <div class="p-3 rounded-4 bg-slate-800 text-white border border-slate-700 shadow-sm" style="max-width: 80%;">
                    <div class="fw-bold text-warning small mb-1">Safora AI Safety Bot</div>
                    <div class="small">${text}</div>
                </div>
            `;
        } else {
            msgDiv.innerHTML = `
                <div class="p-3 rounded-4 bg-warning text-dark fw-medium shadow-sm" style="max-width: 80%;">
                    <div class="small">${text}</div>
                </div>
                <div class="p-2 bg-slate-700 text-white rounded-circle fw-bold fs-6 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 34px; height: 34px;">👤</div>
            `;
        }

        container.appendChild(msgDiv);
        container.scrollTop = container.scrollHeight;
    }

    function showTypingIndicator() {
        const container = document.getElementById('aiChatMessages');
        if (!container) return;
        const typingDiv = document.createElement('div');
        typingDiv.id = 'aiTypingIndicator';
        typingDiv.className = 'd-flex gap-2 mb-3';
        typingDiv.innerHTML = `
            <img src="/images/ai-avatar.png" alt="Safora AI Avatar" class="rounded-circle border border-warning flex-shrink-0" style="width: 34px; height: 34px; object-fit: cover;">
            <div class="p-3 rounded-4 bg-slate-800 text-slate-400 border border-slate-700 small d-flex align-items-center gap-2">
                <span>Safora AI is processing...</span>
                <span class="spinner-grow spinner-grow-sm text-warning" style="width: 6px; height: 6px;"></span>
            </div>
        `;
        container.appendChild(typingDiv);
        container.scrollTop = container.scrollHeight;
    }

    function removeTypingIndicator() {
        const indicator = document.getElementById('aiTypingIndicator');
        if (indicator) indicator.remove();
    }

    function generateAiResponse(inputStr) {
        const q = inputStr.toLowerCase();

        if (q.includes('police') || q.includes('119') || q.includes('crime') || q.includes('thief')) {
            return `🚨 <strong>Police Emergency Hotline: 119</strong><br>For immediate police dispatch or reporting criminal activity, dial <strong>119</strong> directly. You can also tap the red <strong>SOS Button</strong> at the bottom-right of your screen to transmit live GPS coordinates to authorities!`;
        }

        if (q.includes('ambulance') || q.includes('hospital') || q.includes('1990') || q.includes('suwa seriya') || q.includes('doctor') || q.includes('medical')) {
            return `🚑 <strong>Suwa Seriya Ambulance Hotline: 1990</strong><br>For free 24/7 emergency medical assistance and ambulance dispatch anywhere in Sri Lanka, call <strong>1990</strong> immediately.`;
        }

        if (q.includes('elephant') || q.includes('wildlife') || q.includes('1985') || q.includes('animal') || q.includes('habarana')) {
            return `🐘 <strong>Wildlife & Elephant Hotline: 1985</strong><br>If you encounter wild elephants on highways (e.g. Habarana, Dambulla, Udawalawe):<br>1. Do NOT flash high beams or honk.<br>2. Keep vehicle windows closed & wait at a safe distance.<br>3. Call Wildlife Hotline <strong>1985</strong> immediately.`;
        }

        if (q.includes('women') || q.includes('child') || q.includes('harassment') || q.includes('1938') || q.includes('girl') || q.includes('female')) {
            return `🚺 <strong>Women & Child Protection Hotline: 1938</strong><br>If you experience street harassment, stalking, or domestic distress, dial <strong>1938</strong>. You can also submit an incident report on Safora Map with precise location pin.`;
        }

        if (q.includes('safe place') || q.includes('colombo') || q.includes('kandy') || q.includes('galle') || q.includes('shelter') || q.includes('nearest')) {
            return `📍 <strong>Verified Safe Havens & Rest Spots:</strong><br>Safora features 24/7 verified emergency safe places including:<br>• <strong>Colombo:</strong> Fort Police Station Hub, Pettah Central Safe Point<br>• <strong>Kandy:</strong> Kandy Clock Tower Response Post<br>• <strong>Galle:</strong> Galle Main Station Emergency Point<br>Check the <strong>Safe Places Section</strong> on the home map for live star ratings!`;
        }

        if (q.includes('report') || q.includes('hazard') || q.includes('how to')) {
            return `📝 <strong>How to Report a Hazard on Safora:</strong><br>1. Go to the <a href="/#reportSection" class="text-warning fw-bold">Report Hazard Form</a>.<br>2. Select the hazard category (Streetlight Outage, Crime, Wildlife, Road Hazard).<br>3. Click <strong>"Use My GPS Location"</strong> or drop a pin on the map.<br>4. Submit the report! Moderators will verify and publish it.`;
        }

        if (q.includes('sos') || q.includes('distress') || q.includes('emergency')) {
            return `🚨 <strong>Emergency SOS Signal:</strong><br>Tap the floating red <strong>"SOS"</strong> button at the bottom-right corner of the screen. It will capture your exact GPS location and trigger an instant emergency alert to police hotline & emergency contacts via automated SMS!`;
        }

        if (q.includes('hi') || q.includes('hello') || q.includes('ayubowan') || q.includes('hey')) {
            return `Ayubowan! 👋 I am your Safora AI Assistant. Ask me about emergency numbers (119, 1990, 1985, 1938), safe travel tips, or finding nearest safe places in Sri Lanka!`;
        }

        return `💡 <strong>Safora AI Assistant Note:</strong><br>I can help you navigate safety resources across Sri Lanka! You can ask me about:<br>• Emergency Hotlines (<strong>119</strong> Police, <strong>1990</strong> Ambulance, <strong>1985</strong> Wildlife, <strong>1938</strong> Women Help)<br>• Nearest Verified Safe Places<br>• How to trigger SOS or report a street hazard.`;
    }
</script>
@endpush
