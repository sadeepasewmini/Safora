@extends('layouts.app')

@section('content')
<div class="container py-4">
    <!-- Header -->
    <div class="d-flex flex-wrap align-items-center justify-content-between mb-4 pb-3 border-bottom">
        <div>
            <span class="badge bg-slate-900 text-info px-3 py-2 fw-semibold mb-2" style="font-size: 0.75rem;"><i class="bi bi-shield-check me-1"></i> MODERATOR VERIFICATION CENTER</span>
            <h3 class="fw-bold mb-0 text-slate-900">Hazard Review & Verification Console</h3>
            <p class="text-muted small mb-0">Moderator: <strong>{{ Auth::user()->name }}</strong></p>
        </div>
        <a href="{{ route('home') }}" class="btn btn-outline-dark fw-medium px-3"><i class="bi bi-house-door me-1"></i> Public Safety Map</a>
    </div>

    <!-- Stats Row -->
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card card-pro p-3 border-start border-4 border-warning">
                <small class="text-muted text-uppercase fw-semibold" style="font-size: 0.7rem; letter-spacing: 0.5px;">Pending Verification Queue</small>
                <div class="h3 fw-bold text-slate-900 my-1">{{ $stats['pending'] }}</div>
                <small class="text-secondary" style="font-size: 0.75rem;">Requires Moderator action</small>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-pro p-3 border-start border-4 border-success">
                <small class="text-muted text-uppercase fw-semibold" style="font-size: 0.7rem; letter-spacing: 0.5px;">Total Verified & Published</small>
                <div class="h3 fw-bold text-slate-900 my-1">{{ $stats['verified'] }}</div>
                <small class="text-secondary" style="font-size: 0.75rem;">Published to public map</small>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-pro p-3 border-start border-4 border-danger">
                <small class="text-muted text-uppercase fw-semibold" style="font-size: 0.7rem; letter-spacing: 0.5px;">Rejected Fake Reports</small>
                <div class="h3 fw-bold text-danger my-1">{{ $stats['rejected'] }}</div>
                <small class="text-secondary" style="font-size: 0.75rem;">Filtered out of system</small>
            </div>
        </div>
    </div>

    <!-- Main Content Area -->
    <div class="row g-4">
        <!-- Verification Queue List -->
        <div class="col-lg-8">
            <div class="card card-pro p-4 mb-4">
                <h5 class="fw-bold mb-2 text-slate-900"><i class="bi bi-hourglass-split text-warning me-2"></i>Pending Verification Queue</h5>
                <p class="text-muted small mb-3">Review user-submitted safety reports before publishing them to the public map to prevent false alerts.</p>

                @if(count($pendingIncidents) === 0)
                    <div class="alert alert-success border-0 text-center py-4 bg-emerald-50">
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
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pendingIncidents as $inc)
                                <tr>
                                    <td><span class="font-mono fw-bold">#{{ $inc->id }}</span></td>
                                    <td>
                                        <div class="fw-bold text-slate-900">{{ $inc->title }}</div>
                                        <small class="text-muted">{{ Str::limit($inc->description, 60) }}</small><br>
                                        <span class="badge badge-category mt-1">{{ $inc->category->name }}</span>
                                    </td>
                                    <td><small class="text-slate-700"><i class="bi bi-geo-alt me-1"></i>{{ $inc->area_name }}</small></td>
                                    <td>
                                        <span class="badge badge-pro {{ $inc->severity == 'critical' ? 'bg-danger text-white' : ($inc->severity == 'high' ? 'bg-warning text-dark' : 'bg-info text-dark') }}">
                                            {{ strtoupper($inc->severity) }}
                                        </span>
                                    </td>
                                    <td><small class="text-muted">{{ $inc->user ? $inc->user->name : 'Public Citizen' }}</small></td>
                                    <td>
                                        <div class="d-flex flex-column gap-1">
                                            <form action="{{ route('incidents.update-status', $inc->id) }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="status" value="verified">
                                                <button type="submit" class="btn btn-sm btn-success w-100 fw-semibold py-1" style="font-size: 0.8rem;">
                                                    <i class="bi bi-check-lg me-1"></i> Approve
                                                </button>
                                            </form>
                                            <form action="{{ route('incidents.update-status', $inc->id) }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="status" value="rejected">
                                                <button type="submit" class="btn btn-sm btn-outline-danger w-100 fw-semibold py-1" style="font-size: 0.8rem;">
                                                    <i class="bi bi-x-lg me-1"></i> Reject Fake
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

            <!-- Recently Verified -->
            <div class="card card-pro p-4">
                <h6 class="fw-bold mb-3 text-slate-900"><i class="bi bi-check2-circle text-success me-2"></i>Recently Verified Incidents</h6>
                <div class="list-group list-group-flush">
                    @foreach($recentVerified as $v)
                    <div class="list-group-item d-flex justify-content-between align-items-center px-0 py-2">
                        <div>
                            <strong class="text-slate-900 small">{{ $v->title }}</strong> - <span class="text-muted small">{{ $v->area_name }}</span><br>
                            <small class="text-secondary" style="font-size: 0.75rem;">Category: {{ $v->category->name }} | Severity: {{ strtoupper($v->severity) }}</small>
                        </div>
                        <span class="badge bg-success-subtle text-success border border-success" style="font-size: 0.7rem;">VERIFIED</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Broadcast Community Safety Alerts Column -->
        <div class="col-lg-4">
            <div class="card card-pro p-4 mb-4">
                <h6 class="fw-bold mb-3 text-slate-900"><i class="bi bi-broadcast text-warning me-2"></i>Broadcast Safety Alert</h6>
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
                        <input type="text" name="area_name" class="form-control rounded-3" placeholder="e.g. Habarana / Bentota" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-slate-700">Message</label>
                        <textarea name="message" class="form-control rounded-3" rows="3" placeholder="Public safety instructions..." required></textarea>
                    </div>
                    <button type="submit" class="btn btn-warning w-100 fw-bold py-2 text-dark"><i class="bi bi-megaphone-fill me-1"></i> Broadcast Alert</button>
                </form>
            </div>

            <!-- Active Broadcasts -->
            <div class="card card-pro p-4">
                <h6 class="fw-bold mb-3 text-slate-900">Live Broadcasted Alerts</h6>
                <div class="list-group">
                    @foreach($alerts as $alert)
                    <div class="list-group-item border rounded-3 mb-2 p-2">
                        <div class="fw-bold text-slate-900 small">{{ $alert->title }}</div>
                        <p class="small text-muted mb-1" style="font-size: 0.8rem;">{{ $alert->message }}</p>
                        <small class="text-secondary" style="font-size: 0.75rem;"><i class="bi bi-geo-alt me-1"></i>{{ $alert->area_name }}</small>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
