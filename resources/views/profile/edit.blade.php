@extends('admin.layouts.app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex align-items-center mb-3">
            <div class="me-2">
                <i class="fas fa-user-circle fa-sm text-primary"></i>
            </div>
            <div>
                <h1 class="h4 mb-0">Profile Settings</h1>
                <p class="text-muted small mb-0">Manage your account information and security</p>
            </div>
        </div>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <!-- Profile Information -->
        <div class="card">
            <div class="card-header py-2">
                <h6 class="card-title mb-0">
                    <i class="fas fa-user me-2 text-primary"></i>Profile Information
                </h6>
            </div>
            <div class="card-body py-3">
                <form method="post" action="{{ route('profile.update') }}" class="needs-validation" novalidate>
                    @csrf
                    @method('patch')
                    
                    <div class="row g-2">
                        <div class="col-md-6">
                            <label for="name" class="form-label small fw-semibold">Full Name</label>
                            <input type="text" 
                                   class="form-control form-control-sm @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name', $user->name) }}" 
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6">
                            <label for="email" class="form-label small fw-semibold">Email Address</label>
                            <input type="email" 
                                   class="form-control form-control-sm @error('email') is-invalid @enderror" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email', $user->email) }}" 
                                   required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                        <div class="mt-3 p-2 bg-light rounded">
                            <p class="text-muted small mb-2">
                                <i class="fas fa-exclamation-triangle text-warning me-1"></i>
                                Your email address is unverified.
                            </p>
                            <form method="post" action="{{ route('verification.send') }}" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-link btn-sm p-0 text-decoration-none">
                                    Click here to re-send the verification email.
                                </button>
                            </form>
                            
                            @if (session('status') === 'verification-link-sent')
                                <div class="alert alert-success alert-sm mt-2 mb-0 py-1">
                                    <i class="fas fa-check-circle me-1"></i>
                                    A new verification link has been sent to your email address.
                                </div>
                            @endif
                        </div>
                    @endif

                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary btn-sm">
                            <i class="fas fa-save me-1"></i>Save Changes
                        </button>
                        
                        @if (session('status') === 'profile-updated')
                            <span class="text-success small ms-2">
                                <i class="fas fa-check-circle me-1"></i>Profile updated successfully!
                            </span>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        <!-- Password Update -->
        <div class="card mt-3">
            <div class="card-header py-2">
                <h6 class="card-title mb-0">
                    <i class="fas fa-lock me-2 text-warning"></i>Update Password
                </h6>
            </div>
            <div class="card-body py-3">
                <form method="post" action="{{ route('password.update') }}" class="needs-validation" novalidate>
                    @csrf
                    @method('put')
                    
                    <div class="row g-2">
                        <div class="col-md-4">
                            <label for="current_password" class="form-label small fw-semibold">Current Password</label>
                            <input type="password" 
                                   class="form-control form-control-sm @error('current_password', 'updatePassword') is-invalid @enderror" 
                                   id="current_password" 
                                   name="current_password" 
                                   required>
                            @error('current_password', 'updatePassword')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-4">
                            <label for="password" class="form-label small fw-semibold">New Password</label>
                            <input type="password" 
                                   class="form-control form-control-sm @error('password', 'updatePassword') is-invalid @enderror" 
                                   id="password" 
                                   name="password" 
                                   required>
                            @error('password', 'updatePassword')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-4">
                            <label for="password_confirmation" class="form-label small fw-semibold">Confirm Password</label>
                            <input type="password" 
                                   class="form-control form-control-sm @error('password_confirmation', 'updatePassword') is-invalid @enderror" 
                                   id="password_confirmation" 
                                   name="password_confirmation" 
                                   required>
                            @error('password_confirmation', 'updatePassword')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-3">
                        <button type="submit" class="btn btn-warning btn-sm">
                            <i class="fas fa-key me-1"></i>Update Password
                        </button>
                        
                        @if (session('status') === 'password-updated')
                            <span class="text-success small ms-2">
                                <i class="fas fa-check-circle me-1"></i>Password updated successfully!
                            </span>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    border: 1px solid #e3e6f0;
    box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
}

.card-header {
    background-color: #f8f9fc;
    border-bottom: 1px solid #e3e6f0;
}

.form-control-sm {
    font-size: 0.875rem;
    padding: 0.375rem 0.75rem;
}

.btn-sm {
    padding: 0.375rem 0.75rem;
    font-size: 0.875rem;
}

.alert-sm {
    padding: 0.375rem 0.75rem;
    font-size: 0.875rem;
}
</style>
@endsection
