<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Laundry App')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #0f172a 100%);
            position: relative;
            overflow-x: hidden;
            overflow-y: auto;
            padding: 20px 0;
        }

        /* Animated background orbs */
        body::before,
        body::after {
            content: '';
            position: fixed;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.15;
            animation: float 8s ease-in-out infinite;
            z-index: 0;
        }

        body::before {
            width: 400px;
            height: 400px;
            background: #3b82f6;
            top: -100px;
            right: -100px;
            animation-delay: 0s;
        }

        body::after {
            width: 350px;
            height: 350px;
            background: #8b5cf6;
            bottom: -80px;
            left: -80px;
            animation-delay: -4s;
        }

        @keyframes float {
            0%, 100% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(30px, -30px) scale(1.05); }
            66% { transform: translate(-20px, 20px) scale(0.95); }
        }

        .auth-container {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 400px;
            padding: 12px;
        }

        .auth-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 16px;
            padding: 28px 24px;
            box-shadow:
                0 25px 50px -12px rgba(0, 0, 0, 0.4),
                0 0 0 1px rgba(255, 255, 255, 0.05);
            animation: slideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .auth-brand {
            text-align: center;
            margin-bottom: 20px;
        }

        .auth-brand-icon {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            border-radius: 14px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 12px;
            box-shadow: 0 8px 16px rgba(59, 130, 246, 0.3);
        }

        .auth-brand-icon i {
            font-size: 20px;
            color: white;
        }

        .auth-brand h2 {
            font-size: 1.25rem;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 2px;
        }

        .auth-brand p {
            font-size: 0.8125rem;
            color: #64748b;
            margin: 0;
        }

        /* Form Styles */
        .form-label {
            font-size: 0.8125rem;
            font-weight: 600;
            color: #334155;
            margin-bottom: 6px;
        }

        .form-control {
            border-radius: 12px;
            padding: 11px 14px;
            border: 1.5px solid #e2e8f0;
            font-size: 0.875rem;
            transition: all 0.2s ease;
            background: #f8fafc;
        }

        .form-control:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
            background: #fff;
        }

        .form-control.is-invalid {
            border-color: #ef4444;
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
        }

        .form-control-password {
            padding-right: 44px;
        }

        /* Password toggle */
        .password-wrapper {
            position: relative;
        }

        .password-toggle {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: #94a3b8;
            padding: 4px;
            transition: color 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .password-toggle:hover {
            color: #3b82f6;
        }

        /* Primary button */
        .btn-auth-primary {
            width: 100%;
            border-radius: 12px;
            padding: 12px;
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            color: white;
            font-weight: 600;
            font-size: 0.9375rem;
            border: none;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-auth-primary:hover {
            background: linear-gradient(135deg, #2563eb, #1e40af);
            transform: translateY(-1px);
            box-shadow: 0 8px 20px rgba(59, 130, 246, 0.35);
            color: white;
        }

        .btn-auth-primary:active {
            transform: translateY(0);
        }

        .btn-auth-primary:disabled {
            opacity: 0.7;
            cursor: not-allowed;
            transform: none;
        }

        .btn-auth-primary .spinner-border {
            width: 18px;
            height: 18px;
            border-width: 2px;
        }

        /* Links */
        .auth-link {
            color: #3b82f6;
            text-decoration: none;
            font-weight: 500;
            font-size: 0.8125rem;
            transition: color 0.2s;
        }

        .auth-link:hover {
            color: #1d4ed8;
            text-decoration: underline;
        }

        /* Divider */
        .auth-divider {
            text-align: center;
            margin: 20px 0;
            position: relative;
        }

        .auth-divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: #e2e8f0;
        }

        .auth-divider span {
            background: rgba(255, 255, 255, 0.95);
            padding: 0 12px;
            position: relative;
            color: #94a3b8;
            font-size: 0.8125rem;
        }

        /* Alert styles */
        .auth-alert {
            border-radius: 12px;
            padding: 12px 16px;
            font-size: 0.8125rem;
            border: none;
            margin-bottom: 20px;
        }

        .auth-alert-success {
            background: rgba(34, 197, 94, 0.1);
            color: #16a34a;
            border: 1px solid rgba(34, 197, 94, 0.2);
        }

        .auth-alert-danger {
            background: rgba(239, 68, 68, 0.1);
            color: #dc2626;
            border: 1px solid rgba(239, 68, 68, 0.2);
        }

        .auth-alert-info {
            background: rgba(59, 130, 246, 0.1);
            color: #2563eb;
            border: 1px solid rgba(59, 130, 246, 0.2);
        }

        /* Invalid feedback */
        .invalid-feedback {
            font-size: 0.75rem;
            margin-top: 4px;
        }

        /* Checkbox */
        .form-check-input {
            border-radius: 4px;
            border: 1.5px solid #cbd5e1;
        }

        .form-check-input:checked {
            background-color: #3b82f6;
            border-color: #3b82f6;
        }

        .form-check-label {
            font-size: 0.8125rem;
            color: #475569;
        }

        /* Footer text */
        .auth-footer {
            text-align: center;
            margin-top: 24px;
            padding-top: 20px;
            border-top: 1px solid #f1f5f9;
        }

        .auth-footer p {
            font-size: 0.8125rem;
            color: #64748b;
            margin: 0;
        }

        /* Responsive */
        @media (max-width: 480px) {
            .auth-card {
                padding: 20px 16px;
            }
            .auth-brand {
                margin-bottom: 16px;
            }
            .auth-brand-icon {
                width: 40px;
                height: 40px;
            }
            .auth-brand-icon i {
                font-size: 18px;
            }
            .auth-brand h2 {
                font-size: 1.125rem;
            }
        }

        /* High zoom / small viewport */
        @media (max-height: 700px) {
            body {
                align-items: flex-start;
                padding: 12px 0;
            }
            .auth-card {
                padding: 22px 20px;
            }
            .auth-brand {
                margin-bottom: 14px;
            }
            .auth-brand-icon {
                width: 40px;
                height: 40px;
                margin-bottom: 8px;
            }
            .auth-brand-icon i {
                font-size: 18px;
            }
            .auth-brand h2 {
                font-size: 1.1rem;
            }
            .mb-3 {
                margin-bottom: 0.75rem !important;
            }
            .mb-4 {
                margin-bottom: 1rem !important;
            }
            .auth-footer {
                margin-top: 16px;
                padding-top: 14px;
            }
        }

        /* Password strength bar */
        .password-strength {
            margin-top: 8px;
        }

        .password-strength-bar {
            height: 4px;
            background: #e2e8f0;
            border-radius: 4px;
            overflow: hidden;
        }

        .password-strength-fill {
            height: 100%;
            border-radius: 4px;
            transition: all 0.3s ease;
            width: 0%;
        }

        .password-strength-text {
            font-size: 0.6875rem;
            margin-top: 4px;
            font-weight: 500;
        }

        .strength-weak { background: #ef4444; width: 25% !important; }
        .strength-fair { background: #f59e0b; width: 50% !important; }
        .strength-good { background: #3b82f6; width: 75% !important; }
        .strength-strong { background: #22c55e; width: 100% !important; }

        @yield('extra-styles')
    </style>
</head>
<body>

<div class="auth-container">
    <div class="auth-card">
        @yield('content')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Reusable password toggle function
    function togglePassword(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);

        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('bi-eye');
            icon.classList.add('bi-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('bi-eye-slash');
            icon.classList.add('bi-eye');
        }
    }

    // Password strength checker
    function checkPasswordStrength(password) {
        let score = 0;
        if (password.length >= 8) score++;
        if (password.length >= 12) score++;
        if (/[a-z]/.test(password) && /[A-Z]/.test(password)) score++;
        if (/\d/.test(password)) score++;
        if (/[^a-zA-Z0-9]/.test(password)) score++;

        if (score <= 1) return { level: 'weak', text: 'Lemah', class: 'strength-weak', color: '#ef4444' };
        if (score <= 2) return { level: 'fair', text: 'Cukup', class: 'strength-fair', color: '#f59e0b' };
        if (score <= 3) return { level: 'good', text: 'Baik', class: 'strength-good', color: '#3b82f6' };
        return { level: 'strong', text: 'Kuat', class: 'strength-strong', color: '#22c55e' };
    }

    // Loading state for forms
    document.querySelectorAll('form[data-loading]').forEach(form => {
        form.addEventListener('submit', function() {
            const btn = this.querySelector('button[type="submit"]');
            if (btn) {
                btn.disabled = true;
                const originalText = btn.innerHTML;
                btn.setAttribute('data-original-text', originalText);
                btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status"></span>Memproses...';
            }
        });
    });
</script>

@yield('scripts')

</body>
</html>
