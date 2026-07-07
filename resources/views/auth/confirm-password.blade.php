@extends('layouts.auth')

@section('title', 'Konfirmasi Password - Laundry App')

@section('content')

    {{-- Brand --}}
    <div class="auth-brand">
        <div class="auth-brand-icon" style="background: linear-gradient(135deg, #8b5cf6, #6d28d9);">
            <i class="bi bi-shield-check"></i>
        </div>
        <h2>Konfirmasi Password</h2>
        <p>Ini adalah area aman. Silakan konfirmasi password Anda sebelum melanjutkan.</p>
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

    <form method="POST" action="{{ route('password.confirm') }}" data-loading>
        @csrf

        {{-- PASSWORD --}}
        <div class="mb-4">
            <label for="password" class="form-label">
                <i class="bi bi-lock me-1"></i>Password
            </label>
            <div class="password-wrapper">
                <input
                    type="password"
                    name="password"
                    id="password"
                    class="form-control form-control-password @error('password') is-invalid @enderror"
                    placeholder="Masukkan password Anda"
                    required
                    autocomplete="current-password"
                >
                <button type="button" class="password-toggle" onclick="togglePassword('password', 'confirmPwdIcon')">
                    <i class="bi bi-eye" id="confirmPwdIcon"></i>
                </button>
            </div>
            @error('password')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        {{-- BUTTON --}}
        <button type="submit" class="btn btn-auth-primary">
            <i class="bi bi-check-circle me-1"></i>Konfirmasi
        </button>
    </form>

@endsection
