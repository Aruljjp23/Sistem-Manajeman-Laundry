@extends('layouts.auth')

@section('title', 'Lupa Password - Laundry App')

@section('content')

    {{-- Brand --}}
    <div class="auth-brand">
        <div class="auth-brand-icon" style="background: linear-gradient(135deg, #f59e0b, #d97706);">
            <i class="bi bi-key"></i>
        </div>
        <h2>Lupa Password?</h2>
        <p>Masukkan email Anda dan kami akan mengirimkan link untuk mengatur ulang password.</p>
    </div>

    {{-- Session Status --}}
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

    <form method="POST" action="{{ route('password.email') }}" data-loading>
        @csrf

        {{-- EMAIL --}}
        <div class="mb-4">
            <label for="email" class="form-label">
                <i class="bi bi-envelope me-1"></i>Alamat Email
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
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- BUTTON --}}
        <button type="submit" class="btn btn-auth-primary">
            <i class="bi bi-send me-1"></i>Kirim Link Reset Password
        </button>
    </form>

    {{-- Back to Login --}}
    <div class="auth-footer">
        <p>
            <a href="{{ route('login') }}" class="auth-link">
                <i class="bi bi-arrow-left me-1"></i>Kembali ke halaman login
            </a>
        </p>
    </div>

@endsection
