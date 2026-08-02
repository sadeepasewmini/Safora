@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card card-pro p-4 shadow-md">
                <div class="text-center mb-4">
                    <h3 class="fw-bold text-dark mb-1"><i class="bi bi-shield-lock-fill text-warning me-2"></i>Safora Portal Login</h3>
                    <p class="text-muted small">Sign in to report hazards or access management dashboards</p>
                </div>

                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-slate-700">Email Address</label>
                        <input type="email" name="email" class="form-control form-control-lg rounded-3 fs-6" required placeholder="name@safora.lk">
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-semibold text-slate-700">Password</label>
                        <input type="password" name="password" class="form-control form-control-lg rounded-3 fs-6" required placeholder="••••••••">
                    </div>
                    <button type="submit" class="btn btn-warning btn-lg w-100 fw-bold rounded-3 py-3 shadow-sm mb-3 text-dark">
                        <i class="bi bi-box-arrow-in-right me-2"></i> Sign In to Dashboard
                    </button>
                </form>

                <div class="text-center border-top pt-3 mt-3">
                    <p class="small text-muted mb-2">New Public Citizen?</p>
                    <a href="{{ route('register') }}" class="btn btn-outline-secondary btn-sm fw-bold">Create Public Account</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
