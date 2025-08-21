<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-2">
        @csrf
        @method('patch')

        <div class="mb-2">
            <label for="name" class="form-label small">{{ __('Name') }}</label>
            <input id="name" name="name" type="text" class="form-control form-control-sm @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-2">
            <label for="email" class="form-label small">{{ __('Email') }}</label>
            <input id="email" name="email" type="email" class="form-control form-control-sm @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required autocomplete="username">
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-1">
                    <p class="text-muted small">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="btn btn-link btn-sm p-0 text-decoration-none">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <div class="alert alert-success alert-sm mt-1">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </div>
                    @endif
                </div>
            @endif
        </div>

        <div class="d-flex align-items-center gap-2">
            <button type="submit" class="btn btn-primary btn-sm">
                <i class="fas fa-save me-1"></i>{{ __('Save') }}
            </button>

            @if (session('status') === 'profile-updated')
                <div class="alert alert-success alert-sm mb-0 py-1">
                    <i class="fas fa-check-circle me-1"></i>{{ __('Saved.') }}
                </div>
            @endif
        </div>
    </form>
</section>
