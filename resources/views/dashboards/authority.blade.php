@extends('layouts.app')

@section('content')
<div class="container py-4">
    <!-- Header -->
    <div class="d-flex flex-wrap align-items-center justify-content-between mb-4 pb-3 border-bottom">
        <div>
            <span class="badge bg-slate-900 text-success px-3 py-2 fw-semibold mb-2" style="font-size: 0.75rem;"><i class="bi bi-shield-shaded me-1"></i> AUTHORITY & POLICE RESPONSE CONSOLE</span>
            <h3 class="fw-bold mb-0 text-slate-900">Emergency Dispatch & Command Console</h3>
            <p class="text-muted small mb-0">Station / Unit: <strong>{{ Auth::user()->name }}</strong></p>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-emerald-600 btn-success fw-bold text-white px-3 shadow-xs" data-bs-toggle="modal" data-bs-target="#addSafePlaceModal">
                <i class="bi bi-plus-circle me-1"></i> + Add Safe Place / Station
            </button>
            <a href="{{ route('home') }}" class="btn btn-outline-dark fw-medium px-3"><i class="bi bi-house-door me-1"></i> Public View</a>
        </div>
    </div>

    <!-- Active SOS Live Section -->
    <div class="card card-pro p-4 border-start border-4 border-danger mb-4">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <div>
                <h5 class="fw-bold text-danger mb-1"><i class="bi bi-exclamation-octagon-fill me-2"></i>Active Emergency SOS Signals Queue ({{ count($activeSos) }})</h5>
                <p class="text-muted small mb-0">Real-time GPS distress signals transmitted by citizens in danger.</p>
            </div>
            <span class="badge bg-danger px-3 py-2 fw-bold" style="font-size: 0.75rem;">LIVE MONITORING DISPATCH</span>
        </div>

        @if(count($activeSos) === 0)
            <div class="alert alert-light border text-center py-4 bg-slate-50">
                <i class="bi bi-shield-check fs-2 text-success d-block mb-2"></i>
                <h6 class="fw-bold mb-1 text-slate-900">No Active Distress Signals</h6>
                <p class="mb-0 text-muted small">All distress requests have been successfully dispatched and marked resolved.</p>
            </div>
        @else
            <div class="row g-3">
                @foreach($activeSos as $sos)
                <div class="col-md-6">
                    <div class="card border-danger p-3 bg-danger bg-opacity-10 rounded-3">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div>
                                <h6 class="fw-bold text-danger mb-0">🚨 SOS Triggered by {{ $sos->user_name }}</h6>
                                <small class="text-muted"><i class="bi bi-telephone-fill text-success me-1"></i>Phone: <strong>{{ $sos->user_phone }}</strong></small>
                            </div>
                            <span class="badge bg-danger" style="font-size: 0.7rem;">ACTIVE DISTRESS</span>
                        </div>
                        <p class="small mb-3" style="font-size: 0.825rem;"><strong>📍 GPS Location:</strong> {{ $sos->latitude }}, {{ $sos->longitude }} ({{ $sos->address }})</p>
                        <div class="d-flex justify-content-between align-items-center pt-2 border-top border-danger border-opacity-25">
                            <a href="https://maps.google.com/?q={{ $sos->latitude }},{{ $sos->longitude }}" target="_blank" class="btn btn-sm btn-outline-danger fw-bold py-1 px-3" style="font-size: 0.8rem;">
                                <i class="bi bi-map me-1"></i> Track Live Location
                            </a>
                            <form action="{{ route('sos.resolve', $sos->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-success fw-bold py-1 px-3" style="font-size: 0.8rem;">
                                    <i class="bi bi-check-circle me-1"></i> Mark Responded & Resolved
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Verified Incidents Action Queue -->
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card card-pro p-4">
                <h5 class="fw-bold mb-3 text-slate-900"><i class="bi bi-clipboard-check text-primary me-2"></i>Verified Hazards Requiring Authority Action</h5>
                <div class="table-responsive">
                    <table class="table table-pro align-middle">
                        <thead>
                            <tr>
                                <th>Hazard Title</th>
                                <th>Category & Area</th>
                                <th>Severity</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($verifiedIncidents as $inc)
                            <tr>
                                <td>
                                    <div class="fw-bold text-slate-900">{{ $inc->title }}</div>
                                    <small class="text-muted">{{ Str::limit($inc->description, 50) }}</small>
                                </td>
                                <td>
                                    <span class="badge badge-category">{{ $inc->category->name }}</span><br>
                                    <small class="text-muted"><i class="bi bi-geo-alt me-1"></i>{{ $inc->area_name }}</small>
                                </td>
                                <td>
                                    <span class="badge badge-pro {{ $inc->severity == 'critical' ? 'bg-danger text-white' : 'bg-warning text-dark' }}">
                                        {{ strtoupper($inc->severity) }}
                                    </span>
                                </td>
                                <td><span class="badge bg-success-subtle text-success border border-success" style="font-size: 0.7rem;">VERIFIED</span></td>
                                <td>
                                    <form action="{{ route('incidents.update-status', $inc->id) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="status" value="resolved">
                                        <button type="submit" class="btn btn-sm btn-primary fw-bold py-1 px-3" style="font-size: 0.8rem;">
                                            <i class="bi bi-check-all me-1"></i> Mark Resolved
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Safe Places Column -->
        <div class="col-lg-4">
            <div class="card card-pro p-4">
                <div class="d-flex align-items-center justify-content-between mb-3 border-bottom pb-2">
                    <h6 class="fw-bold mb-0 text-slate-900"><i class="bi bi-building-fill text-success me-2"></i>Safe Places Directory</h6>
                    <button class="btn btn-sm btn-outline-success fw-bold" data-bs-toggle="modal" data-bs-target="#addSafePlaceModal">
                        + Add
                    </button>
                </div>
                <div class="list-group list-group-flush">
                    @foreach($safePlaces as $sp)
                    <div class="list-group-item px-0 py-2 border-bottom">
                        <div class="d-flex justify-content-between align-items-center">
                            <strong class="text-slate-900 small">{{ $sp->name }}</strong>
                        </div>
                        <small class="text-muted d-block" style="font-size: 0.75rem;"><i class="bi bi-geo-alt me-1"></i>{{ $sp->area_name }}</small>
                        <small class="text-success fw-semibold" style="font-size: 0.75rem;"><i class="bi bi-telephone-fill me-1"></i>{{ $sp->phone }}</small>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Add Safe Place -->
<div class="modal fade" id="addSafePlaceModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content rounded-3 border-0 shadow-lg">
            <div class="modal-header bg-slate-900 text-white rounded-top-3">
                <h6 class="modal-title fw-bold text-success mb-0"><i class="bi bi-plus-circle-fill me-2"></i>Add Safe Place / Emergency Station</h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('safe-places.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-slate-700">Station / Shelter Name</label>
                        <input type="text" name="name" class="form-control rounded-3" placeholder="e.g. Bentota Police Station" required>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label fw-semibold text-slate-700">Type</label>
                            <select name="type" class="form-select rounded-3" required>
                                <option value="police">🚔 Police Station</option>
                                <option value="hospital">🏥 Hospital</option>
                                <option value="fire_station">🚒 Fire Station</option>
                                <option value="shelter">⛺ Emergency Shelter</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-semibold text-slate-700">Area / Town</label>
                            <input type="text" name="area_name" class="form-control rounded-3" placeholder="e.g. Bentota" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-slate-700">Contact Phone Number</label>
                        <input type="text" name="phone" class="form-control rounded-3" placeholder="0342275222" required>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label fw-semibold text-slate-700">Latitude</label>
                            <input type="text" name="latitude" class="form-control rounded-3" placeholder="6.4251" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-semibold text-slate-700">Longitude</label>
                            <input type="text" name="longitude" class="form-control rounded-3" placeholder="79.9984" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-slate-700">Full Address</label>
                        <input type="text" name="address" class="form-control rounded-3" placeholder="Main Street, Bentota" required>
                    </div>
                </div>
                <div class="modal-footer bg-slate-50 rounded-bottom-3">
                    <button type="button" class="btn btn-sm btn-secondary fw-semibold" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-sm btn-success fw-bold px-4"><i class="bi bi-check-lg me-1"></i> Save Safe Place</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
