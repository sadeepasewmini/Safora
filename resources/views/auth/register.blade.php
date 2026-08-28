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

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show rounded-3 mb-4 border-0 shadow-sm" role="alert" style="background-color: #fef2f2; border-left: 4px solid #dc2626 !important; color: #991b1b;">
                        <div class="d-flex align-items-start">
                            <i class="bi bi-exclamation-triangle-fill fs-4 me-3 text-danger flex-shrink-0 mt-1"></i>
                            <div>
                                <h6 class="fw-bold mb-1" style="color: #991b1b;"><i class="bi bi-person-x me-1"></i> Registration Error</h6>
                                <ul class="mb-0 ps-3 small fw-semibold">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form action="{{ route('register') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Full Name</label>
                        <input type="text" name="name" class="form-control rounded-3 @error('name') is-invalid @enderror" required placeholder="e.g. Kasun Fernando" value="{{ old('name') }}">
                        @error('name')
                            <div class="invalid-feedback fw-semibold mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Email Address</label>
                        <input type="email" name="email" class="form-control rounded-3 @error('email') is-invalid @enderror" required placeholder="kasun@gmail.com" value="{{ old('email') }}">
                        @error('email')
                            <div class="invalid-feedback fw-semibold mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Phone Number (For Emergency Alerts)</label>
                        <input type="text" name="phone" class="form-control rounded-3 @error('phone') is-invalid @enderror" required placeholder="0771234567" value="{{ old('phone') }}">
                        @error('phone')
                            <div class="invalid-feedback fw-semibold mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="row g-2 mb-4">
                        <div class="col-6">
                            <label class="form-label fw-semibold">Password</label>
                            <input type="password" name="password" class="form-control rounded-3 @error('password') is-invalid @enderror" required placeholder="••••••••">
                            @error('password')
                                <div class="invalid-feedback fw-semibold mt-1">{{ $message }}</div>
                            @enderror
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
