@extends('layouts.user-dashboard')

@section('title', 'Profile - Patrik Solutions')
@section('page-title', 'Profile Settings')
@section('page-description', 'Manage your account information and preferences')

@section('content')
@if(session('status') === 'profile-updated')
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>Profile updated successfully!
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('status') === 'password-updated')
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle me-2"></i>Password updated successfully!
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="row justify-content-center">
    <div class="col-lg-10">
        <!-- Profile Photo Card -->
        <div class="modern-card mb-4">
            <div class="modern-card-header">
                <h3 class="modern-card-title">
                    <i class="fas fa-image me-2" style="color: var(--primary-color);"></i>Profile Photo
                </h3>
                <p class="modern-card-subtitle">
                    Update your profile picture
                </p>
            </div>
            <div class="text-center py-4">
                <div class="mb-3">
                    @if($user->photo)
                        <img src="{{ asset('storage/' . $user->photo) }}" 
                             alt="{{ $user->name }}" 
                             class="rounded-circle" 
                             style="width: 150px; height: 150px; object-fit: cover; border: 4px solid var(--primary-color); box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
                    @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&color=FFFFFF&background=667eea&size=150" 
                             alt="{{ $user->name }}" 
                             class="rounded-circle" 
                             style="width: 150px; height: 150px; object-fit: cover; border: 4px solid var(--primary-color); box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
                    @endif
                </div>
                <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="d-inline">
                    @csrf
                    @method('patch')
                    <div class="d-flex justify-content-center gap-2">
                        <label for="photo" class="btn btn-modern btn-modern-primary" style="cursor: pointer;">
                            <i class="fas fa-upload me-2"></i>Upload Photo
                        </label>
                        <input type="file" id="photo" name="photo" accept="image/*" class="d-none" onchange="this.form.submit()">
                    </div>
                </form>
            </div>
        </div>

        <!-- Profile Information Card -->
                <div class="modern-card mb-4">
                    <div class="modern-card-header">
                        <h3 class="modern-card-title">
                            <i class="fas fa-user me-2" style="color: var(--primary-color);"></i>Profile Information
                        </h3>
                        <p class="modern-card-subtitle">
                            Update your account's profile information and email address.
                        </p>
                    </div>

                    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="mt-4">
                        @csrf
                        @method('patch')

                        <div class="mb-4">
                            <label for="name" class="form-label fw-semibold">
                                <i class="fas fa-user me-2" style="color: var(--primary-color);"></i>Full Name
                            </label>
                            <input 
                                type="text" 
                                id="name" 
                                name="name" 
                                class="form-control @error('name') is-invalid @enderror" 
                                value="{{ old('name', $user->name) }}" 
                                required 
                                autofocus 
                                autocomplete="name"
                                style="padding: 0.75rem; border-radius: 8px; font-size: 16px;">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="email" class="form-label fw-semibold">
                                <i class="fas fa-envelope me-2" style="color: var(--primary-color);"></i>Email Address
                            </label>
                            <input 
                                type="email" 
                                id="email" 
                                name="email" 
                                class="form-control @error('email') is-invalid @enderror" 
                                value="{{ old('email', $user->email) }}" 
                                required 
                                autocomplete="username"
                                style="padding: 0.75rem; border-radius: 8px; font-size: 16px;">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                                <div class="mt-2">
                                    <p class="text-muted mb-2" style="font-size: 0.875rem;">
                                        Your email address is unverified.
                                    </p>
                                    <form method="post" action="{{ route('verification.send') }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-link p-0 text-primary" style="font-size: 0.875rem;">
                                            Click here to re-send the verification email.
                                        </button>
                                    </form>

                                    @if (session('status') === 'verification-link-sent')
                                        <p class="mt-2 text-success" style="font-size: 0.875rem;">
                                            <i class="fas fa-check-circle me-1"></i>A new verification link has been sent to your email address.
                                        </p>
                                    @endif
                                </div>
                            @endif
                        </div>

                        <div class="d-flex gap-3 align-items-center">
                            <button type="submit" class="btn btn-modern btn-modern-primary">
                                <i class="fas fa-save me-2"></i>Save Changes
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Update Password Card -->
                <div class="modern-card mb-4">
                    <div class="modern-card-header">
                        <h3 class="modern-card-title">
                            <i class="fas fa-lock me-2" style="color: var(--primary-color);"></i>Update Password
                        </h3>
                        <p class="modern-card-subtitle">
                            Ensure your account is using a long, random password to stay secure.
                        </p>
                    </div>

                    <form method="post" action="{{ route('password.update') }}" class="mt-4">
                        @csrf
                        @method('put')

                        <div class="mb-4">
                            <label for="update_password_current_password" class="form-label fw-semibold">
                                <i class="fas fa-key me-2" style="color: var(--primary-color);"></i>Current Password
                            </label>
                            <input 
                                type="password" 
                                id="update_password_current_password" 
                                name="current_password" 
                                class="form-control @error('current_password', 'updatePassword') is-invalid @enderror" 
                                autocomplete="current-password"
                                style="padding: 0.75rem; border-radius: 8px; font-size: 16px;">
                            @error('current_password', 'updatePassword')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="update_password_password" class="form-label fw-semibold">
                                <i class="fas fa-lock me-2" style="color: var(--primary-color);"></i>New Password
                            </label>
                            <input 
                                type="password" 
                                id="update_password_password" 
                                name="password" 
                                class="form-control @error('password', 'updatePassword') is-invalid @enderror" 
                                autocomplete="new-password"
                                style="padding: 0.75rem; border-radius: 8px; font-size: 16px;">
                            @error('password', 'updatePassword')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="update_password_password_confirmation" class="form-label fw-semibold">
                                <i class="fas fa-lock me-2" style="color: var(--primary-color);"></i>Confirm New Password
                            </label>
                            <input 
                                type="password" 
                                id="update_password_password_confirmation" 
                                name="password_confirmation" 
                                class="form-control" 
                                autocomplete="new-password"
                                style="padding: 0.75rem; border-radius: 8px; font-size: 16px;">
                        </div>

                        <div class="d-flex gap-3 align-items-center">
                            <button type="submit" class="btn btn-modern btn-modern-primary">
                                <i class="fas fa-save me-2"></i>Update Password
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Delete Account Card -->
                <div class="modern-card mb-4" style="border-color: var(--danger-color);">
                    <div class="modern-card-header">
                        <h3 class="modern-card-title" style="color: var(--danger-color);">
                            <i class="fas fa-exclamation-triangle me-2"></i>Delete Account
                        </h3>
                        <p class="modern-card-subtitle">
                            Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.
                        </p>
                    </div>

                    <button 
                        type="button" 
                        class="btn btn-modern" 
                        style="background: var(--danger-color); color: white;"
                        data-bs-toggle="modal" 
                        data-bs-target="#deleteAccountModal">
                        <i class="fas fa-trash-alt me-2"></i>Delete Account
                    </button>
                </div>
    </div>
</div>

<!-- Delete Account Modal -->
<div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-labelledby="deleteAccountModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="border-bottom: 1px solid var(--border-color);">
                <h5 class="modal-title" id="deleteAccountModalLabel">
                    <i class="fas fa-exclamation-triangle text-danger me-2"></i>Delete Account
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="{{ route('profile.destroy') }}">
                @csrf
                @method('delete')
                
                <div class="modal-body">
                    <p class="mb-3">
                        Are you sure you want to delete your account? Once your account is deleted, all of its resources and data will be permanently deleted.
                    </p>
                    <p class="text-danger mb-3">
                        <strong>This action cannot be undone.</strong>
                    </p>
                    <p class="mb-3">
                        Please enter your password to confirm you would like to permanently delete your account.
                    </p>
                    
                    <div class="mb-3">
                        <label for="password" class="form-label fw-semibold">Password</label>
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            class="form-control @error('password', 'userDeletion') is-invalid @enderror" 
                            placeholder="Enter your password to confirm"
                            required
                            style="padding: 0.75rem; border-radius: 8px; font-size: 16px;">
                        @error('password', 'userDeletion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer" style="border-top: 1px solid var(--border-color);">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Cancel
                    </button>
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash-alt me-2"></i>Delete Account
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endpush
@endsection
