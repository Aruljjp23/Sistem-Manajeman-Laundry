@extends('layouts.auth')

@section('title', 'Login - Laundry App')

@section('content')

    {{-- Brand --}}
    <div class="auth-brand">
        <div class="auth-brand-icon">
            <i class="bi bi-water"></i>
        </div>
        <h2>Laundry App</h2>
        <p>Silakan masuk ke akun Anda</p>
    </div>

    {{-- Session Status (e.g. from password reset) --}}
    @if (session('status'))
        <div class="auth-alert auth-alert-success">
            <i class="bi bi-check-circle me-1"></i>{{ session('status') }}
        </div>
    @endif

    {{-- Validation Errors --}}
    @if ($errors->any())
        <div class="auth-alert auth-alert-danger">
            <i class="bi bi-exclamation-circle me-1"></i>
            @foreach ($errors->all() as $error)
                {{ $error }}@if (!$loop->last)<br>@endif
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" data-loading>
        @csrf

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
                autofocus
                autocomplete="username"
            >
        </div>

        {{-- PASSWORD --}}
        <div class="mb-3">
            <div class="d-flex justify-content-between align-items-center">
                <label for="loginPassword" class="form-label mb-0">
                    <i class="bi bi-lock me-1"></i>Password
                </label>
                <a href="{{ route('password.request') }}" class="auth-link" style="font-size: 0.75rem;">
                    Lupa password?
                </a>
            </div>
            <div class="password-wrapper mt-1">
                <input
                    type="password"
                    name="password"
                    id="loginPassword"
                    class="form-control form-control-password @error('password') is-invalid @enderror"
                    placeholder="Masukkan password"
                    required
                    autocomplete="current-password"
                >
                <button type="button" class="password-toggle" onclick="togglePassword('loginPassword', 'loginPasswordIcon')">
                    <i class="bi bi-eye" id="loginPasswordIcon"></i>
                </button>
            </div>
        </div>

        {{-- REMEMBER ME --}}
        <div class="mb-4">
            <div class="form-check">
                <input
                    type="checkbox"
                    name="remember"
                    id="remember"
                    class="form-check-input"
                    {{ old('remember') ? 'checked' : '' }}
                >
                <label class="form-check-label" for="remember">
                    Ingat saya
                </label>
            </div>
        </div>

        {{-- BUTTON --}}
        <button type="submit" class="btn btn-auth-primary">
            <i class="bi bi-box-arrow-in-right me-1"></i>Masuk
        </button>
    </form>

    {{-- Register Link --}}
    <div class="auth-footer">
        <p>
            Belum punya akun?
            <a href="{{ route('register') }}" class="auth-link">Daftar sekarang</a>
        </p>
    </div>

@endsection