@extends('layouts.app')

@section('content')
<div class="container py-4">
    <!-- Modern Header -->
    <div class="d-flex flex-wrap align-items-center justify-content-between mb-4 pb-3 border-bottom">
        <div>
            <span class="badge bg-dark text-warning px-3 py-2 fw-bold mb-2 shadow-xs" style="font-size: 0.78rem; letter-spacing: 0.5px;">
                <i class="bi bi-shield-check me-1 text-warning"></i> MODERATOR VERIFICATION & SAFETY CONSOLE
            </span>
            <h3 class="fw-extrabold mb-0 text-slate-900 font-outfit">Hazard Review & Verification Console</h3>
            <p class="text-muted small mb-0">Logged in as Safety Moderator: <strong>{{ Auth::user()->name }}</strong> ({{ Auth::user()->email }})</p>
        </div>
        <div class="d-flex gap-2">
            <a href="#broadcastAlertSection" class="btn btn-warning text-dark fw-bold px-3 shadow-xs">
                <i class="bi bi-broadcast me-1"></i> Broadcast Safety Alert
            </a>
            <a href="{{ route('home') }}" class="btn btn-outline-dark fw-medium px-3">
                <i class="bi bi-house-door me-1"></i> Public Safety Map
            </a>
        </div>
    </div>

    <!-- 4 Status Metrics Row -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="card card-pro p-3 border-start border-4 border-warning shadow-xs h-100">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <small class="text-muted text-uppercase fw-bold" style="font-size: 0.7rem; letter-spacing: 0.5px;">Pending Queue</small>
                    <span class="badge bg-warning-subtle text-warning border border-warning px-2 py-0.5 rounded-pill fw-bold" style="font-size: 0.68rem;">Action Required</span>
                </div>
                <div class="h2 fw-extrabold text-slate-900 my-1 font-outfit">{{ $stats['pending'] }}</div>
                <small class="text-secondary" style="font-size: 0.75rem;">Citizen reports waiting verification</small>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="card card-pro p-3 border-start border-4 border-success shadow-xs h-100">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <small class="text-muted text-uppercase fw-bold" style="font-size: 0.7rem; letter-spacing: 0.5px;">Verified & Published</small>
                    <span class="badge bg-success-subtle text-success border border-success px-2 py-0.5 rounded-pill fw-bold" style="font-size: 0.68rem;">Live on Map</span>
                </div>
                <div class="h2 fw-extrabold text-success my-1 font-outfit">{{ $stats['verified'] }}</div>
                <small class="text-secondary" style="font-size: 0.75rem;">Active public safety hazards</small>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="card card-pro p-3 border-start border-4 border-primary shadow-xs h-100">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <small class="text-muted text-uppercase fw-bold" style="font-size: 0.7rem; letter-spacing: 0.5px;">Resolved Hazards</small>
                    <span class="badge bg-primary-subtle text-primary border border-primary px-2 py-0.5 rounded-pill fw-bold" style="font-size: 0.68rem;">Cleared</span>
                </div>
                <div class="h2 fw-extrabold text-primary my-1 font-outfit">{{ $stats['resolved'] }}</div>
                <small class="text-secondary" style="font-size: 0.75rem;">Solved by Police / Authorities</small>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="card card-pro p-3 border-start border-4 border-danger shadow-xs h-100">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <small class="text-muted text-uppercase fw-bold" style="font-size: 0.7rem; letter-spacing: 0.5px;">Rejected Reports</small>
                    <span class="badge bg-danger-subtle text-danger border border-danger px-2 py-0.5 rounded-pill fw-bold" style="font-size: 0.68rem;">Filtered Out</span>
                </div>
                <div class="h2 fw-extrabold text-danger my-1 font-outfit">{{ $stats['rejected'] }}</div>
                <small class="text-secondary" style="font-size: 0.75rem;">Spam / Fake alerts blocked</small>
            </div>
        </div>
    </div>

    <!-- Main Navigation Tabs for all 4 Incident Statuses -->
    <div class="card card-pro p-4 mb-4 shadow-sm border-0">
        <ul class="nav nav-pills gap-2 mb-4 pb-3 border-bottom" id="moderatorTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active fw-bold px-3 py-2 rounded-3" id="pending-tab" data-bs-toggle="tab" data-bs-target="#pending-tab-pane" type="button" role="tab">
                    <i class="bi bi-hourglass-split me-1 text-warning"></i> 🟡 Pending Queue
                    <span class="badge bg-warning text-dark ms-1 rounded-pill">{{ count($pendingIncidents) }}</span>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link fw-bold px-3 py-2 rounded-3" id="verified-tab" data-bs-toggle="tab" data-bs-target="#verified-tab-pane" type="button" role="tab">
                    <i class="bi bi-check-circle-fill me-1 text-success"></i> 🟢 Verified Incidents
                    <span class="badge bg-success ms-1 rounded-pill">{{ count($recentVerified) }}</span>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link fw-bold px-3 py-2 rounded-3" id="rejected-tab" data-bs-toggle="tab" data-bs-target="#rejected-tab-pane" type="button" role="tab">
                    <i class="bi bi-x-circle-fill me-1 text-danger"></i> 🔴 Rejected Reports
                    <span class="badge bg-danger ms-1 rounded-pill">{{ count($rejectedIncidents) }}</span>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link fw-bold px-3 py-2 rounded-3" id="resolved-tab" data-bs-toggle="tab" data-bs-target="#resolved-tab-pane" type="button" role="tab">
                    <i class="bi bi-shield-check me-1 text-primary"></i> 🔵 Resolved Log
                    <span class="badge bg-primary ms-1 rounded-pill">{{ count($resolvedIncidents) }}</span>
                </button>
            </li>
        </ul>

        <div class="tab-content" id="moderatorTabContent">
            <!-- TAB 1: PENDING QUEUE -->
            <div class="tab-pane fade show active" id="pending-tab-pane" role="tabpanel">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div>
                        <h5 class="fw-bold mb-1 text-slate-900"><i class="bi bi-hourglass-split text-warning me-2"></i>Pending Verification Queue</h5>
                        <p class="text-muted small mb-0">Review user-submitted safety reports before publishing them live to the public map.</p>
                    </div>
                </div>

                @if(count($pendingIncidents) === 0)
                    <div class="alert alert-success border-0 text-center py-4 bg-emerald-50 rounded-3">
                        <i class="bi bi-check-circle fs-2 text-emerald-600 d-block mb-2"></i>
                        <h6 class="fw-bold mb-1 text-slate-900">Verification Queue Clear!</h6>
                        <p class="mb-0 text-muted small">No pending incident reports require verification at the moment.</p>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-pro align-middle">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Title & Category</th>
                                    <th>Location</th>
                                    <th>Severity</th>
                                    <th>Reported By</th>
                                    <th>Change Status Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pendingIncidents as $inc)
                                <tr>
                                    <td><span class="font-mono fw-bold">#{{ $inc->id }}</span></td>
                                    <td>
                                        <div class="fw-bold text-slate-900">{{ $inc->title }}</div>
                                        <small class="text-muted">{{ Str::limit($inc->description, 70) }}</small><br>
                                        <span class="badge badge-category mt-1 bg-slate-900 text-white">{{ $inc->category->name }}</span>
                                    </td>
                                    <td><small class="text-slate-700 fw-medium"><i class="bi bi-geo-alt me-1 text-danger"></i>{{ $inc->area_name }}</small></td>
                                    <td>
                                        <span class="badge {{ $inc->severity == 'critical' ? 'bg-danger text-white' : ($inc->severity == 'high' ? 'bg-warning text-dark' : 'bg-info text-dark') }} px-2 py-1">
                                            {{ strtoupper($inc->severity) }}
                                        </span>
                                    </td>
                                    <td><small class="text-muted">{{ $inc->user ? $inc->user->name : 'Public Citizen' }}</small></td>
                                    <td>
                                        <div class="d-flex flex-column gap-1">
                                            <!-- Approve Form -->
                                            <form action="{{ route('incidents.update-status', $inc->id) }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="status" value="verified">
                                                <button type="submit" class="btn btn-sm btn-success w-100 fw-bold py-1" style="font-size: 0.78rem;">
                                                    <i class="bi bi-check-lg me-1"></i> Approve (Verified)
                                                </button>
                                            </form>
                                            <!-- Reject Form -->
                                            <form action="{{ route('incidents.update-status', $inc->id) }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="status" value="rejected">
                                                <button type="submit" class="btn btn-sm btn-outline-danger w-100 fw-bold py-1" style="font-size: 0.78rem;">
                                                    <i class="bi bi-x-lg me-1"></i> Reject (Fake Alert)
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

            <!-- TAB 2: VERIFIED INCIDENTS -->
            <div class="tab-pane fade" id="verified-tab-pane" role="tabpanel">
                <h5 class="fw-bold mb-3 text-slate-900"><i class="bi bi-check2-circle text-success me-2"></i>Verified & Published Hazards</h5>
                <div class="table-responsive">
                    <table class="table table-pro align-middle">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Hazard Title</th>
                                <th>Category</th>
                                <th>Area</th>
                                <th>Status</th>
                                <th>Modify Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentVerified as $v)
                            <tr>
                                <td><span class="font-mono fw-bold">#{{ $v->id }}</span></td>
                                <td>
                                    <strong class="text-slate-900">{{ $v->title }}</strong>
                                    <div class="small text-muted">{{ Str::limit($v->description, 60) }}</div>
                                </td>
                                <td><span class="badge bg-slate-800 text-white">{{ $v->category->name }}</span></td>
                                <td><small class="text-slate-700"><i class="bi bi-geo-alt me-1 text-danger"></i>{{ $v->area_name }}</small></td>
                                <td><span class="badge bg-success-subtle text-success border border-success px-2 py-1">🟢 VERIFIED</span></td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <form action="{{ route('incidents.update-status', $v->id) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="status" value="resolved">
                                            <button type="submit" class="btn btn-sm btn-primary fw-bold py-1 px-2" style="font-size: 0.75rem;">
                                                Mark Resolved
                                            </button>
                                        </form>
                                        <form action="{{ route('incidents.update-status', $v->id) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="status" value="rejected">
                                            <button type="submit" class="btn btn-sm btn-outline-danger fw-bold py-1 px-2" style="font-size: 0.75rem;">
                                                Reject
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- TAB 3: REJECTED REPORTS -->
            <div class="tab-pane fade" id="rejected-tab-pane" role="tabpanel">
                <h5 class="fw-bold mb-3 text-slate-900"><i class="bi bi-x-circle text-danger me-2"></i>Rejected & Filtered Fake Reports</h5>
                @if(count($rejectedIncidents) === 0)
                    <div class="alert alert-light border text-center py-4 rounded-3">
                        <p class="mb-0 text-muted small">No rejected reports recorded in system audit.</p>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-pro align-middle">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Report Title</th>
                                    <th>Area</th>
                                    <th>Moderator Note</th>
                                    <th>Restore Option</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($rejectedIncidents as $rej)
                                <tr>
                                    <td><span class="font-mono fw-bold">#{{ $rej->id }}</span></td>
                                    <td>
                                        <strong class="text-slate-900">{{ $rej->title }}</strong>
                                        <div class="small text-muted">{{ $rej->description }}</div>
                                    </td>
                                    <td><small class="text-slate-700">{{ $rej->area_name }}</small></td>
                                    <td><span class="small text-danger fw-semibold">{{ $rej->moderator_notes ?? 'Flagged as false alert' }}</span></td>
                                    <td>
                                        <form action="{{ route('incidents.update-status', $rej->id) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="status" value="pending">
                                            <button type="submit" class="btn btn-sm btn-outline-warning text-dark fw-bold py-1 px-2" style="font-size: 0.75rem;">
                                                <i class="bi bi-arrow-counterclockwise me-1"></i> Re-Open to Pending
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

            <!-- TAB 4: RESOLVED LOG -->
            <div class="tab-pane fade" id="resolved-tab-pane" role="tabpanel">
                <h5 class="fw-bold mb-3 text-slate-900"><i class="bi bi-shield-check text-primary me-2"></i>Resolved Safety Hazards</h5>
                @if(count($resolvedIncidents) === 0)
                    <div class="alert alert-light border text-center py-4 rounded-3">
                        <p class="mb-0 text-muted small">No resolved hazard records found.</p>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-pro align-middle">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Area</th>
                                    <th>Category</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($resolvedIncidents as $res)
                                <tr>
                                    <td><span class="font-mono fw-bold">#{{ $res->id }}</span></td>
                                    <td><strong class="text-slate-900">{{ $res->title }}</strong></td>
                                    <td><small class="text-slate-700">{{ $res->area_name }}</small></td>
                                    <td><span class="badge bg-slate-800 text-white">{{ $res->category->name }}</span></td>
                                    <td><span class="badge bg-primary-subtle text-primary border border-primary px-2 py-1">🔵 RESOLVED</span></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Broadcast Safety Alert Section -->
    <div class="row g-4" id="broadcastAlertSection">
        <div class="col-lg-5">
            <div class="card card-pro p-4">
                <h5 class="fw-bold mb-3 text-slate-900"><i class="bi bi-broadcast text-warning me-2"></i>Broadcast Community Safety Alert</h5>
                <form action="{{ route('alerts.create') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-slate-700">Alert Title</label>
                        <input type="text" name="title" class="form-control rounded-3" placeholder="e.g. 🐘 Wild Elephant Highway Alert" required>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label fw-semibold text-slate-700">Category</label>
                            <select name="category" class="form-select rounded-3" required>
                                <option value="wildlife">🐘 Wildlife</option>
                                <option value="crime">🚔 Crime</option>
                                <option value="weather">🌧️ Weather</option>
                                <option value="road_closure">🚗 Road</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-semibold text-slate-700">Severity</label>
                            <select name="severity" class="form-select rounded-3" required>
                                <option value="warning">Warning</option>
                                <option value="danger">Danger</option>
                                <option value="critical">Critical</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-slate-700">Target Area</label>
                        <input type="text" name="area_name" class="form-control rounded-3" placeholder="e.g. Habarana / Bentota / Katugastota" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-slate-700">Message Instructions</label>
                        <textarea name="message" class="form-control rounded-3" rows="3" placeholder="Public safety instructions for citizens..." required></textarea>
                    </div>
                    <button type="submit" class="btn btn-warning w-100 fw-bold py-2 text-dark shadow-xs"><i class="bi bi-megaphone-fill me-1"></i> Broadcast Safety Alert Now</button>
                </form>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="card card-pro p-4 h-100">
                <h5 class="fw-bold mb-3 text-slate-900"><i class="bi bi-bell-fill text-danger me-2"></i>Live Broadcasted Alerts Directory</h5>
                <div class="list-group list-group-flush">
                    @foreach($alerts as $alert)
                    <div class="list-group-item border rounded-3 mb-2 p-3 bg-slate-50">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <strong class="text-slate-900 font-outfit">{{ $alert->title }}</strong>
                            <span class="badge bg-warning text-dark uppercase fw-bold" style="font-size: 0.65rem;">{{ strtoupper($alert->severity) }}</span>
                        </div>
                        <p class="small text-slate-700 mb-2">{{ $alert->message }}</p>
                        <small class="text-secondary" style="font-size: 0.75rem;"><i class="bi bi-geo-alt me-1 text-danger"></i>Target Area: <strong>{{ $alert->area_name }}</strong></small>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
