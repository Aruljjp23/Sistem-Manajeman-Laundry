@extends('layouts.auth')

@section('title', 'Reset Password - Laundry App')

@section('content')

    {{-- Brand --}}
    <div class="auth-brand">
        <div class="auth-brand-icon" style="background: linear-gradient(135deg, #22c55e, #16a34a);">
            <i class="bi bi-shield-lock"></i>
        </div>
        <h2>Reset Password</h2>
        <p>Buat password baru untuk akun Anda</p>
    </div>

    {{-- Validation Errors --}}
    @if ($errors->any())
        <div class="auth-alert auth-alert-danger">
            <i class="bi bi-exclamation-circle me-1"></i>
            @foreach ($errors->all() as $error)
                {{ $error }}@if (!$loop->last)<br>@endif
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('password.store') }}" data-loading>
        @csrf

        {{-- Token --}}
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        {{-- EMAIL --}}
        <div class="mb-3">
            <label for="email" class="form-label">
                <i class="bi bi-envelope me-1"></i>Email
            </label>
            <input
                type="email"
                name="email"
                id="email"
                class="form-control @error('email') is-invalid @enderror"
                value="{{ old('email', $request->email) }}"
                required
                autofocus
                autocomplete="username"
            >
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- PASSWORD BARU --}}
        <div class="mb-3">
            <label for="password" class="form-label">
                <i class="bi bi-lock me-1"></i>Password Baru
            </label>
            <div class="password-wrapper">
                <input
                    type="password"
                    name="password"
                    id="password"
                    class="form-control form-control-password @error('password') is-invalid @enderror"
                    placeholder="Minimal 8 karakter"
                    required
                    autocomplete="new-password"
                    oninput="updateResetPasswordStrength(this.value)"
                >
                <button type="button" class="password-toggle" onclick="togglePassword('password', 'resetPasswordIcon')">
                    <i class="bi bi-eye" id="resetPasswordIcon"></i>
                </button>
            </div>
            @error('password')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror

            {{-- Password Strength --}}
            <div class="password-strength" id="resetStrengthContainer" style="display: none;">
                <div class="password-strength-bar">
                    <div class="password-strength-fill" id="resetStrengthFill"></div>
                </div>
                <div class="password-strength-text" id="resetStrengthText"></div>
            </div>
        </div>

        {{-- KONFIRMASI PASSWORD --}}
        <div class="mb-4">
            <label for="password_confirmation" class="form-label">
                <i class="bi bi-lock-fill me-1"></i>Konfirmasi Password Baru
            </label>
            <div class="password-wrapper">
                <input
                    type="password"
                    name="password_confirmation"
                    id="password_confirmation"
                    class="form-control form-control-password @error('password_confirmation') is-invalid @enderror"
                    placeholder="Ulangi password baru"
                    required
                    autocomplete="new-password"
                >
                <button type="button" class="password-toggle" onclick="togglePassword('password_confirmation', 'resetConfirmIcon')">
                    <i class="bi bi-eye" id="resetConfirmIcon"></i>
                </button>
            </div>
            @error('password_confirmation')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        {{-- BUTTON --}}
        <button type="submit" class="btn btn-auth-primary">
            <i class="bi bi-check-circle me-1"></i>Reset Password
        </button>
    </form>

@endsection

@section('scripts')
<script>
    function updateResetPasswordStrength(password) {
        const container = document.getElementById('resetStrengthContainer');
        const fill = document.getElementById('resetStrengthFill');
        const text = document.getElementById('resetStrengthText');

        if (password.length === 0) {
            container.style.display = 'none';
            return;
        }

        container.style.display = 'block';
        const strength = checkPasswordStrength(password);
        fill.className = 'password-strength-fill';
        fill.classList.add(strength.class);
        text.textContent = 'Kekuatan: ' + strength.text;
        text.style.color = strength.color;
    }
</script>
@endsection
