@extends('layouts.app')

@section('content')
<div class="container py-4">
    <!-- Header -->
    <div class="d-flex flex-wrap align-items-center justify-content-between mb-4 pb-3 border-bottom">
        <div>
            <span class="badge bg-slate-900 text-warning px-3 py-2 fw-semibold mb-2" style="font-size: 0.75rem;"><i class="bi bi-shield-lock-fill me-1"></i> MASTER ADMIN CONSOLE</span>
            <h3 class="fw-bold mb-0 text-slate-900">System Administration & Officer Directory</h3>
            <p class="text-muted small mb-0">Administrator: <strong>{{ Auth::user()->name }}</strong> ({{ Auth::user()->email }})</p>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-warning fw-bold text-dark px-3 shadow-xs" data-bs-toggle="modal" data-bs-target="#addStaffModal">
                <i class="bi bi-person-plus-fill me-1"></i> + Create Officer Account
            </button>
            <a href="{{ route('home') }}" class="btn btn-outline-dark fw-medium px-3"><i class="bi bi-house-door me-1"></i> Public View</a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card card-pro p-3 border-start border-4 border-danger">
                <small class="text-muted text-uppercase fw-semibold" style="font-size: 0.7rem; letter-spacing: 0.5px;">Staff & Officers</small>
                <div class="h3 fw-bold text-slate-900 my-1">{{ $staffCount }}</div>
                <small class="text-secondary" style="font-size: 0.75rem;">Admins, Moderators, Authorities</small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card card-pro p-3 border-start border-4 border-primary">
                <small class="text-muted text-uppercase fw-semibold" style="font-size: 0.7rem; letter-spacing: 0.5px;">Public Citizens</small>
                <div class="h3 fw-bold text-slate-900 my-1">{{ $publicUserCount }}</div>
                <small class="text-secondary" style="font-size: 0.75rem;">Self-registered accounts</small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card card-pro p-3 border-start border-4 border-warning">
                <small class="text-muted text-uppercase fw-semibold" style="font-size: 0.7rem; letter-spacing: 0.5px;">Total Reported Hazards</small>
                <div class="h3 fw-bold text-slate-900 my-1">{{ $totalIncidents }}</div>
                <small class="text-secondary" style="font-size: 0.75rem;">{{ $pendingIncidents }} Pending review</small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card card-pro p-3 border-start border-4 border-success">
                <small class="text-muted text-uppercase fw-semibold" style="font-size: 0.7rem; letter-spacing: 0.5px;">Active SOS Emergencies</small>
                <div class="h3 fw-bold text-danger my-1">{{ $activeSosCount }}</div>
                <small class="text-secondary" style="font-size: 0.75rem;">Police dispatch active</small>
            </div>
        </div>
    </div>

    <!-- Main Directory & Analytics -->
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card card-pro p-4">
                <div class="d-flex align-items-center justify-content-between mb-3 pb-3 border-bottom">
                    <h5 class="fw-bold mb-0 text-slate-900"><i class="bi bi-people-fill text-slate-700 me-2"></i>Accounts & Officer Directory</h5>
                    <button class="btn btn-sm btn-outline-dark fw-semibold" data-bs-toggle="modal" data-bs-target="#addStaffModal">
                        + Add Officer
                    </button>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-pro align-middle">
                        <thead>
                            <tr>
                                <th>Name & Email</th>
                                <th>Phone</th>
                                <th>Role</th>
                                <th>Account Origin</th>
                                <th>Joined</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $u)
                            <tr>
                                <td>
                                    <div class="fw-bold text-slate-900">{{ $u->name }}</div>
                                    <small class="text-muted">{{ $u->email }}</small>
                                </td>
                                <td><span class="font-mono small">{{ $u->phone ?? 'N/A' }}</span></td>
                                <td>
                                    <span class="badge badge-pro {{ $u->role == 'admin' ? 'bg-danger text-white' : ($u->role == 'moderator' ? 'bg-warning text-dark' : ($u->role == 'authority' ? 'bg-info text-dark' : 'bg-secondary text-white')) }}">
                                        {{ strtoupper($u->role) }}
                                    </span>
                                </td>
                                <td>
                                    @if($u->role === 'public_user')
                                        <small class="text-muted"><i class="bi bi-globe me-1"></i> Public Self-Registered</small>
                                    @else
                                        <small class="text-danger fw-bold"><i class="bi bi-shield-lock me-1"></i> Admin Created Officer</small>
                                    @endif
                                </td>
                                <td><small class="text-muted">{{ $u->created_at->format('Y-m-d') }}</small></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card card-pro p-4 mb-4">
                <h6 class="fw-bold mb-3 text-slate-900"><i class="bi bi-pie-chart-fill text-warning me-2"></i>Category Breakdown</h6>
                <canvas id="categoryChart" style="max-height: 220px;"></canvas>
            </div>

            <div class="card card-pro p-4">
                <h6 class="fw-bold mb-3 text-slate-900"><i class="bi bi-bar-chart-line-fill text-primary me-2"></i>Report Status Metrics</h6>
                <canvas id="statusChart" style="max-height: 200px;"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Create Officer Account (Admin Only) -->
<div class="modal fade" id="addStaffModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content rounded-3 border-0 shadow-lg">
            <div class="modal-header bg-slate-900 text-white rounded-top-3">
                <h6 class="modal-title fw-bold text-warning mb-0"><i class="bi bi-person-plus-fill me-2"></i>Create New Staff / Officer Account</h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.store-staff') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <p class="small text-muted mb-3">Notice: Only Administrators can create Moderator, Authority, or Admin accounts. Officers cannot self-register publicly.</p>

                    <div class="mb-3">
                        <label class="form-label fw-semibold text-slate-700">Assign Role</label>
                        <select name="role" class="form-select rounded-3" required>
                            <option value="moderator" selected>🛡️ Moderator (Reviews & Verifies Hazards)</option>
                            <option value="authority">🚔 Authority / Police (Responds to SOS & Incidents)</option>
                            <option value="admin">👨💼 System Administrator (Full System Control)</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold text-slate-700">Full Name / Station Name</label>
                        <input type="text" name="name" class="form-control rounded-3" placeholder="e.g. Habarana Police Station" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold text-slate-700">Official Email (Login Username)</label>
                        <input type="email" name="email" class="form-control rounded-3" placeholder="officer@safora.lk" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold text-slate-700">Contact Phone Number</label>
                        <input type="text" name="phone" class="form-control rounded-3" placeholder="0662270222" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold text-slate-700">Temporary Password</label>
                        <input type="password" name="password" class="form-control rounded-3" placeholder="••••••••" minlength="6" required>
                    </div>
                </div>
                <div class="modal-footer bg-slate-50 rounded-bottom-3">
                    <button type="button" class="btn btn-sm btn-secondary fw-semibold" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-sm btn-primary fw-bold px-4"><i class="bi bi-check-lg me-1"></i> Create Account</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const catLabels = @json($categoryBreakdown->pluck('name'));
    const catCounts = @json($categoryBreakdown->pluck('incidents_count'));

    new Chart(document.getElementById('categoryChart'), {
        type: 'doughnut',
        data: {
            labels: catLabels,
            datasets: [{
                data: catCounts,
                backgroundColor: ['#d97706', '#dc2626', '#0284c7', '#059669', '#4b5563', '#8b5cf6']
            }]
        }
    });

    const statusData = @json($statusCounts);
    new Chart(document.getElementById('statusChart'), {
        type: 'bar',
        data: {
            labels: Object.keys(statusData),
            datasets: [{
                label: 'Reports',
                data: Object.values(statusData),
                backgroundColor: ['#f59e0b', '#059669', '#2563eb', '#dc2626']
            }]
        }
    });
</script>
@endpush
