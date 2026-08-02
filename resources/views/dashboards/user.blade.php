@extends('layouts.app')

@section('content')
<div class="container py-4">
    <!-- Header -->
    <div class="d-flex flex-wrap align-items-center justify-content-between mb-4 pb-3 border-bottom">
        <div>
            <span class="badge bg-slate-900 text-slate-300 px-3 py-2 fw-semibold mb-2" style="font-size: 0.75rem;"><i class="bi bi-person-circle me-1"></i> PUBLIC CITIZEN DASHBOARD</span>
            <h3 class="fw-bold mb-0 text-slate-900">Welcome, {{ Auth::user()->name }}</h3>
            <p class="text-muted small mb-0">Track your reported safety hazards and emergency SOS distress history.</p>
        </div>
        <a href="{{ route('home') }}#reportSection" class="btn btn-warning fw-bold text-dark px-4 py-2 shadow-xs">
            <i class="bi bi-plus-circle-fill me-1"></i> Report New Hazard
        </a>
    </div>

    <!-- User Stats Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card card-pro p-3 border-start border-4 border-warning">
                <small class="text-muted text-uppercase fw-semibold" style="font-size: 0.7rem; letter-spacing: 0.5px;">My Hazard Reports</small>
                <div class="h3 fw-bold text-slate-900 my-1">{{ count($myIncidents) }}</div>
                <small class="text-secondary" style="font-size: 0.75rem;">Submitted via platform</small>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-pro p-3 border-start border-4 border-success">
                <small class="text-muted text-uppercase fw-semibold" style="font-size: 0.7rem; letter-spacing: 0.5px;">Verified & Live</small>
                <div class="h3 fw-bold text-emerald-600 my-1">{{ $myIncidents->where('status', 'verified')->count() }}</div>
                <small class="text-secondary" style="font-size: 0.75rem;">Approved by Moderators</small>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-pro p-3 border-start border-4 border-danger">
                <small class="text-muted text-uppercase fw-semibold" style="font-size: 0.7rem; letter-spacing: 0.5px;">SOS Signals Transmitted</small>
                <div class="h3 fw-bold text-danger my-1">{{ count($mySosRequests) }}</div>
                <small class="text-secondary" style="font-size: 0.75rem;">Sent to emergency services</small>
            </div>
        </div>
    </div>

    <!-- Main Content Area -->
    <div class="row g-4">
        <!-- My Reported Hazards Table -->
        <div class="col-lg-8">
            <div class="card card-pro p-4 mb-4">
                <h5 class="fw-bold mb-3 text-slate-900"><i class="bi bi-list-stars text-warning me-2"></i>My Reported Incidents Tracker</h5>
                <p class="text-muted small">Submissions are reviewed by Moderators before displaying publicly on the interactive map.</p>

                @if(count($myIncidents) === 0)
                    <div class="alert alert-light text-center py-4 border bg-slate-50">
                        <i class="bi bi-info-circle fs-2 text-muted d-block mb-2"></i>
                        <h6 class="fw-bold mb-1 text-slate-900">No Incidents Reported Yet</h6>
                        <p class="mb-3 text-muted small">Spot an elephant crossing, flood, or harassment zone? Report it to protect your community.</p>
                        <a href="{{ route('home') }}#reportSection" class="btn btn-sm btn-warning text-dark fw-bold px-3">Report an Incident Now</a>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-pro align-middle">
                            <thead>
                                <tr>
                                    <th>Hazard Title</th>
                                    <th>Category</th>
                                    <th>Area</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($myIncidents as $inc)
                                <tr>
                                    <td>
                                        <div class="fw-bold text-slate-900">{{ $inc->title }}</div>
                                        <small class="text-muted">{{ Str::limit($inc->description, 50) }}</small>
                                    </td>
                                    <td><span class="badge badge-category">{{ $inc->category->name }}</span></td>
                                    <td><small class="text-slate-700"><i class="bi bi-geo-alt me-1"></i>{{ $inc->area_name }}</small></td>
                                    <td>
                                        @if($inc->status === 'verified')
                                            <span class="badge bg-success-subtle text-success border border-success" style="font-size: 0.7rem;"><i class="bi bi-check-circle me-1"></i> VERIFIED & LIVE</span>
                                        @elseif($inc->status === 'pending')
                                            <span class="badge bg-warning-subtle text-warning-emphasis border border-warning" style="font-size: 0.7rem;"><i class="bi bi-hourglass-split me-1"></i> PENDING VERIFICATION</span>
                                        @elseif($inc->status === 'resolved')
                                            <span class="badge bg-primary-subtle text-primary border border-primary" style="font-size: 0.7rem;"><i class="bi bi-check-all me-1"></i> RESOLVED</span>
                                        @else
                                            <span class="badge bg-danger-subtle text-danger border border-danger" style="font-size: 0.7rem;"><i class="bi bi-x-circle me-1"></i> REJECTED</span>
                                        @endif
                                    </td>
                                    <td><small class="text-muted">{{ $inc->created_at->diffForHumans() }}</small></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

            <!-- SOS Logs -->
            <div class="card card-pro p-4">
                <h6 class="fw-bold mb-3 text-danger"><i class="bi bi-bell-fill me-2"></i>My Emergency SOS Signal History</h6>
                @if(count($mySosRequests) === 0)
                    <p class="text-muted small mb-0">No Emergency SOS alerts triggered.</p>
                @else
                    <div class="list-group list-group-flush">
                        @foreach($mySosRequests as $sos)
                        <div class="list-group-item d-flex justify-content-between align-items-center px-0 py-2 border-bottom">
                            <div>
                                <strong class="text-danger small">🚨 Emergency SOS Triggered</strong><br>
                                <small class="text-muted" style="font-size: 0.75rem;">GPS Coordinates: {{ $sos->latitude }}, {{ $sos->longitude }} ({{ $sos->address }})</small>
                            </div>
                            <span class="badge {{ $sos->status == 'active' ? 'bg-danger text-white' : 'bg-success text-white' }}" style="font-size: 0.7rem;">
                                {{ strtoupper($sos->status) }}
                            </span>
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <!-- User Profile Card -->
        <div class="col-lg-4">
            <div class="card card-pro p-4">
                <h6 class="fw-bold mb-3 text-slate-900"><i class="bi bi-person-vcard text-slate-700 me-2"></i>My Account Profile</h6>
                <div class="mb-3">
                    <label class="small text-muted d-block" style="font-size: 0.75rem;">Full Name</label>
                    <span class="fw-bold text-slate-900">{{ Auth::user()->name }}</span>
                </div>
                <div class="mb-3">
                    <label class="small text-muted d-block" style="font-size: 0.75rem;">Email Address</label>
                    <span class="fw-bold text-slate-900">{{ Auth::user()->email }}</span>
                </div>
                <div class="mb-3">
                    <label class="small text-muted d-block" style="font-size: 0.75rem;">Contact Phone</label>
                    <span class="fw-bold text-slate-900 font-mono">{{ Auth::user()->phone ?? '0771234567' }}</span>
                </div>
                <div class="mb-3">
                    <label class="small text-muted d-block" style="font-size: 0.75rem;">Account Type</label>
                    <span class="badge bg-slate-100 text-slate-700 border">Public Citizen Account</span>
                </div>
                <hr>
                <div class="alert alert-secondary py-2 small mb-0" style="font-size: 0.8rem;">
                    <i class="bi bi-shield-check me-1"></i> Public citizen profile for reporting safety hazards & emergency SOS signals.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
