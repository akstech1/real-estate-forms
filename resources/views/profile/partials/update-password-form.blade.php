<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Update Password') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="space-y-2">
        @csrf
        @method('put')

        <div class="mb-2">
            <label for="update_password_current_password" class="form-label small">{{ __('Current Password') }}</label>
            <input id="update_password_current_password" name="current_password" type="password" class="form-control form-control-sm @error('current_password', 'updatePassword') is-invalid @enderror" autocomplete="current-password">
            @error('current_password', 'updatePassword')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-2">
            <label for="update_password_password" class="form-label small">{{ __('New Password') }}</label>
            <input id="update_password_password" name="password" type="password" class="form-control form-control-sm @error('password', 'updatePassword') is-invalid @enderror" autocomplete="new-password">
            @error('password', 'updatePassword')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-2">
            <label for="update_password_password_confirmation" class="form-label small">{{ __('Confirm Password') }}</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="form-control form-control-sm @error('password_confirmation', 'updatePassword') is-invalid @enderror" autocomplete="new-password">
            @error('password_confirmation', 'updatePassword')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-flex align-items-center gap-2">
            <button type="submit" class="btn btn-primary btn-sm">
                <i class="fas fa-save me-1"></i>{{ __('Save') }}
            </button>

            @if (session('status') === 'password-updated')
                <div class="alert alert-success alert-sm mb-0 py-1">
                    <i class="fas fa-check-circle me-1"></i>{{ __('Saved.') }}
                </div>
            @endif
        </div>
    </form>
</section>
