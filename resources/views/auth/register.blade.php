@extends('layouts.auth')

@section('title', 'Daftar - Laundry App')

@section('content')

    {{-- Brand --}}
    <div class="auth-brand">
        <div class="auth-brand-icon">
            <i class="bi bi-person-plus"></i>
        </div>
        <h2>Buat Akun Baru</h2>
        <p>Daftar untuk mulai menggunakan Laundry App</p>
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

    <form method="POST" action="{{ route('register') }}" data-loading>
        @csrf

        {{-- NAMA --}}
        <div class="mb-3">
            <label for="name" class="form-label">
                <i class="bi bi-person me-1"></i>Nama Lengkap
            </label>
            <input
                type="text"
                name="name"
                id="name"
                class="form-control @error('name') is-invalid @enderror"
                value="{{ old('name') }}"
                placeholder="Masukkan nama lengkap"
                required
                autofocus
                autocomplete="name"
            >
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

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
                value="{{ old('email') }}"
                placeholder="nama@email.com"
                required
                autocomplete="username"
            >
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- PASSWORD --}}
        <div class="mb-3">
            <label for="registerPassword" class="form-label">
                <i class="bi bi-lock me-1"></i>Password
            </label>
            <div class="password-wrapper">
                <input
                    type="password"
                    name="password"
                    id="registerPassword"
                    class="form-control form-control-password @error('password') is-invalid @enderror"
                    placeholder="Minimal 8 karakter"
                    required
                    autocomplete="new-password"
                    oninput="updatePasswordStrength(this.value)"
                >
                <button type="button" class="password-toggle" onclick="togglePassword('registerPassword', 'registerPasswordIcon')">
                    <i class="bi bi-eye" id="registerPasswordIcon"></i>
                </button>
            </div>
            @error('password')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror

            {{-- Password Strength Indicator --}}
            <div class="password-strength" id="passwordStrengthContainer" style="display: none;">
                <div class="password-strength-bar">
                    <div class="password-strength-fill" id="passwordStrengthFill"></div>
                </div>
                <div class="password-strength-text" id="passwordStrengthText"></div>
            </div>
        </div>

        {{-- KONFIRMASI PASSWORD --}}
        <div class="mb-4">
            <label for="confirmPassword" class="form-label">
                <i class="bi bi-lock-fill me-1"></i>Konfirmasi Password
            </label>
            <div class="password-wrapper">
                <input
                    type="password"
                    name="password_confirmation"
                    id="confirmPassword"
                    class="form-control form-control-password @error('password_confirmation') is-invalid @enderror"
                    placeholder="Ulangi password"
                    required
                    autocomplete="new-password"
                    oninput="checkPasswordMatch()"
                >
                <button type="button" class="password-toggle" onclick="togglePassword('confirmPassword', 'confirmPasswordIcon')">
                    <i class="bi bi-eye" id="confirmPasswordIcon"></i>
                </button>
            </div>
            @error('password_confirmation')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
            <div id="passwordMatchFeedback" class="mt-1" style="font-size: 0.75rem; display: none;"></div>
        </div>

        {{-- BUTTON --}}
        <button type="submit" class="btn btn-auth-primary" id="registerBtn">
            <i class="bi bi-person-plus me-1"></i>Daftar
        </button>
    </form>

    {{-- Login Link --}}
    <div class="auth-footer">
        <p>
            Sudah punya akun?
            <a href="{{ route('login') }}" class="auth-link">Masuk di sini</a>
        </p>
    </div>

@endsection

@section('scripts')
<script>
    // Password strength indicator
    function updatePasswordStrength(password) {
        const container = document.getElementById('passwordStrengthContainer');
        const fill = document.getElementById('passwordStrengthFill');
        const text = document.getElementById('passwordStrengthText');

        if (password.length === 0) {
            container.style.display = 'none';
            return;
        }

        container.style.display = 'block';
        const strength = checkPasswordStrength(password);

        // Remove all strength classes
        fill.className = 'password-strength-fill';
        fill.classList.add(strength.class);
        text.textContent = 'Kekuatan: ' + strength.text;
        text.style.color = strength.color;

        // Also check match if confirm field has value
        checkPasswordMatch();
    }

    // Real-time password match checker
    function checkPasswordMatch() {
        const password = document.getElementById('registerPassword').value;
        const confirm = document.getElementById('confirmPassword').value;
        const feedback = document.getElementById('passwordMatchFeedback');

        if (confirm.length === 0) {
            feedback.style.display = 'none';
            return;
        }

        feedback.style.display = 'block';

        if (password === confirm) {
            feedback.innerHTML = '<i class="bi bi-check-circle me-1"></i>Password cocok';
            feedback.style.color = '#22c55e';
            document.getElementById('confirmPassword').classList.remove('is-invalid');
            document.getElementById('confirmPassword').style.borderColor = '#22c55e';
        } else {
            feedback.innerHTML = '<i class="bi bi-x-circle me-1"></i>Password tidak cocok';
            feedback.style.color = '#ef4444';
            document.getElementById('confirmPassword').style.borderColor = '#ef4444';
        }
    }
</script>
@endsection