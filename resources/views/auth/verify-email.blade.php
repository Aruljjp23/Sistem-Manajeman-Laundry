@extends('layouts.auth')

@section('title', 'Verifikasi Email - Laundry App')

@section('content')

    {{-- Brand --}}
    <div class="auth-brand">
        <div class="auth-brand-icon" style="background: linear-gradient(135deg, #f59e0b, #d97706);">
            <i class="bi bi-envelope-check"></i>
        </div>
        <h2>Verifikasi Email</h2>
        <p>Terima kasih telah mendaftar! Silakan verifikasi alamat email Anda.</p>
    </div>

    {{-- Info --}}
    <div class="auth-alert auth-alert-info">
        <i class="bi bi-info-circle me-1"></i>
        Kami telah mengirimkan kode verifikasi 6-digit ke email Anda. Masukkan kode tersebut di bawah ini.
    </div>

    {{-- Success message when resent --}}
    @if (session('status') == 'verification-link-sent')
        <div class="auth-alert auth-alert-success">
            <i class="bi bi-check-circle me-1"></i>
            Kode verifikasi baru telah dikirim ke alamat email Anda.
        </div>
    @endif

    {{-- Error message --}}
    @if ($errors->any())
        <div class="auth-alert auth-alert-danger">
            <i class="bi bi-exclamation-circle me-1"></i>
            @foreach ($errors->all() as $error)
                {{ $error }}<br>
            @endforeach
        </div>
    @endif

    {{-- OTP Form --}}
    <form method="POST" action="{{ route('verification.code.verify') }}" data-loading class="mb-4">
        @csrf
        <div class="mb-3">
            <label for="code" class="form-label">
                <i class="bi bi-123 me-1"></i>Kode Verifikasi
            </label>
            <input
                type="text"
                name="code"
                id="code"
                class="form-control text-center fs-4 letter-spacing-2 @error('code') is-invalid @enderror"
                placeholder="000000"
                maxlength="6"
                required
                autofocus
                autocomplete="off"
            >
        </div>
        <button type="submit" class="btn btn-auth-primary w-100">
            <i class="bi bi-check-circle me-1"></i>Verifikasi Kode
        </button>
    </form>

    <hr style="border-color: #e2e8f0; margin: 1.5rem 0;">

    <div class="d-flex align-items-center justify-content-between gap-3">
        {{-- Resend Button --}}
        <form method="POST" action="{{ route('verification.send') }}" data-loading class="flex-grow-1">
            @csrf
            <button type="submit" class="btn btn-outline-primary w-100" style="border-radius: 12px; padding: 12px 20px; font-size: 0.875rem;">
                <i class="bi bi-arrow-repeat me-1"></i>Kirim Ulang
            </button>
        </form>

        {{-- Logout --}}
        <form method="POST" action="{{ route('logout') }}" class="flex-grow-1">
            @csrf
            <button type="submit" class="btn btn-outline-secondary w-100" style="border-radius: 12px; padding: 12px 20px; font-size: 0.875rem;">
                <i class="bi bi-box-arrow-right me-1"></i>Keluar
            </button>
        </form>
    </div>

@endsection

@section('scripts')
<style>
    .letter-spacing-2 {
        letter-spacing: 0.5rem;
    }
</style>
<script>
    // Hanya membolehkan input angka
    document.getElementById('code').addEventListener('input', function (e) {
        this.value = this.value.replace(/[^0-9]/g, '');
    });
</script>
@endsection
