@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card card-custom border p-4 shadow-sm">
                <div class="text-center mb-4">
                    <h3 class="fw-bold text-dark mb-1"><i class="bi bi-person-plus-fill text-warning me-2"></i>Public Registration</h3>
                    <p class="text-muted small">Register to report safety hazards and send live GPS SOS alerts</p>
                </div>

                <form action="{{ route('register') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Full Name</label>
                        <input type="text" name="name" class="form-control rounded-3" required placeholder="e.g. Kasun Fernando">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Email Address</label>
                        <input type="email" name="email" class="form-control rounded-3" required placeholder="kasun@gmail.com">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Phone Number (For Emergency Alerts)</label>
                        <input type="text" name="phone" class="form-control rounded-3" required placeholder="0771234567">
                    </div>
                    <div class="row g-2 mb-4">
                        <div class="col-6">
                            <label class="form-label fw-semibold">Password</label>
                            <input type="password" name="password" class="form-control rounded-3" required placeholder="••••••••">
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-semibold">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control rounded-3" required placeholder="••••••••">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-warning btn-lg w-100 fw-bold rounded-3 py-2 shadow-sm mb-3">
                        Create Account
                    </button>
                </form>

                <div class="text-center border-top pt-3">
                    <p class="small text-muted mb-0">Already registered? <a href="{{ route('login') }}" class="fw-bold text-warning">Sign In Here</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
