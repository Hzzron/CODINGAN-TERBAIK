<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - ShopNow</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/customer.css') }}">
    <style>
        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 20px;
        }

        .login-wrapper {
            width: 100%;
            max-width: 450px;
        }

        .login-card {
            background: white;
            border-radius: 20px;
            padding: 45px 40px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
            animation: slideUp 0.5s ease-out;
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

        .login-header {
            text-align: center;
            margin-bottom: 35px;
        }

        .login-header .icon-wrapper {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
        }

        .login-header .icon-wrapper i {
            font-size: 32px;
            color: white;
        }

        .login-header h2 {
            color: #1f2937;
            font-weight: 700;
            margin-bottom: 8px;
            font-size: 1.8rem;
        }

        .login-header p {
            color: #6b7280;
            margin-bottom: 0;
            font-size: 0.95rem;
        }

        .form-label {
            font-weight: 500;
            color: #374151;
            margin-bottom: 8px;
            font-size: 0.9rem;
        }

        .form-control {
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            padding: 12px 16px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.15);
        }

        .form-control::placeholder {
            color: #9ca3af;
        }

        .btn-login {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 600;
            margin-top: 10px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.5);
            background: linear-gradient(135deg, #5a6fd6 0%, #6a4190 100%);
            color: white;
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .input-group-text {
            background: transparent;
            border: 2px solid #e5e7eb;
            border-left: none;
            border-radius: 0 12px 12px 0;
            color: #6b7280;
        }

        .input-group .form-control {
            border-right: none;
            border-radius: 12px 0 0 12px;
        }

        .input-group:focus-within .form-control {
            border-color: #667eea;
        }

        .input-group:focus-within .input-group-text {
            border-color: #667eea;
            color: #667eea;
        }

        .divider {
            display: flex;
            align-items: center;
            margin: 25px 0;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #e5e7eb;
        }

        .divider span {
            padding: 0 15px;
            color: #9ca3af;
            font-size: 0.85rem;
        }

        .alert {
            border-radius: 12px;
            padding: 12px 16px;
            font-size: 0.9rem;
        }

        .alert-danger {
            background: #fee2e2;
            border: none;
            color: #991b1b;
        }

        .invalid-feedback {
            font-size: 0.85rem;
            margin-top: 6px;
        }

        .remember-forgot {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .form-check-label {
            color: #6b7280;
            font-size: 0.9rem;
        }

        .forgot-link {
            color: #667eea;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
        }

        .forgot-link:hover {
            color: #5a6fd6;
            text-decoration: underline;
        }

        @media (max-width: 480px) {
            .login-card {
                padding: 30px 25px;
            }

            .login-header h2 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="login-wrapper">
        <div class="login-card">
            <div class="login-header">
                <div class="icon-wrapper">
                    <i class="bi bi-bag-heart"></i>
                </div>
                <h2>Welcome Back</h2>
                <p>Please login to your account</p>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Email Address</label>
                    <div class="input-group">
                        <input
                            type="email"
                            name="email"
                            class="form-control @error('email') is-invalid @enderror"
                            value="{{ old('email') }}"
                            required
                            autofocus
                            placeholder="Enter your email">
                        <span class="input-group-text">
                            <i class="bi bi-envelope"></i>
                        </span>
                    </div>
                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <div class="input-group">
                        <input
                            type="password"
                            name="password"
                            class="form-control @error('password') is-invalid @enderror"
                            required
                            placeholder="Enter your password">
                        <span class="input-group-text">
                            <i class="bi bi-lock"></i>
                        </span>
                    </div>
                    @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="remember-forgot">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="remember" name="remember">
                        <label class="form-check-label" for="remember">Remember me</label>
                    </div>
                    <a href="#" class="forgot-link">Forgot password?</a>
                </div>

                <button type="submit" class="btn-login">
                    <i class="bi bi-box-arrow-in-right me-2"></i> Login
                </button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
