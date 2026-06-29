<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Your Email - Safari Tours</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .pulse-animation {
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
    </style>
</head>
<body class="bg-light">
    <div class="container">
        <div class="row justify-content-center align-items-center" style="min-height: 100vh;">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            @include('components.logo')
                            <h2 class="mt-3">Verify Your Email</h2>
                            <p class="text-muted">Thanks for signing up with Safari Tours!</p>
                        </div>

                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="alert alert-info">
                            <i class="fas fa-envelope-open-text me-2 fa-2x d-block mb-3"></i>
                            <h5 class="alert-heading">Check Your Email</h5>
                            <strong>Before proceeding, please check your email for a verification code.</strong>
                            <p class="mb-2 mt-2">We've sent a 6-digit verification code to your registered email address.</p>
                            @if(session('user_email'))
                            <div class="mt-2">
                                <small class="text-muted">
                                    <i class="fas fa-envelope me-1"></i>
                                    Sent to: <strong>{{ session('user_email') }}</strong>
                                </small>
                            </div>
                            @endif
                            <hr>
                            <small class="text-muted">
                                <strong>Important:</strong> The verification code will expire in 15 minutes.
                            </small>
                        </div>

                        <div class="text-center mb-4">
                            <a href="{{ route('verification.code') }}" class="btn btn-primary btn-lg">
                                <i class="fas fa-key me-2"></i>Enter Verification Code
                            </a>
                        </div>

                        <div class="card bg-light mb-4">
                            <div class="card-body">
                                <h5 class="card-title">Didn't receive the email?</h5>
                                <p class="card-text">Don't worry! You can request a new verification email to be sent to your inbox.</p>
                                
                                @if(auth()->check())
                                <form action="{{ route('verification.resend') }}" method="POST">
                                    @csrf
                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-warning btn-lg pulse-animation">
                                            <i class="fas fa-redo me-2"></i>Resend Verification Email
                                        </button>
                                    </div>
                                </form>
                                @else
                                <form action="{{ route('verification.resend') }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label">Enter your email address</label>
                                        <input type="email" name="email" class="form-control" placeholder="your@email.com" required>
                                    </div>
                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-warning btn-lg pulse-animation">
                                            <i class="fas fa-redo me-2"></i>Resend Verification Email
                                        </button>
                                    </div>
                                </form>
                                @endif
                                
                                <div class="mt-3 text-center">
                                    <small class="text-muted">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Make sure to check your spam folder as well!
                                    </small>
                                </div>
                            </div>
                        </div>

                        <div class="text-center mt-4">
                            <div class="d-grid gap-2">
                                <a href="{{ route('home') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-arrow-left me-2"></i>Back to Home
                                </a>
                                <a href="{{ route('login') }}" class="btn btn-outline-primary">
                                    <i class="fas fa-sign-in-alt me-2"></i>Go to Login
                                </a>
                            </div>
                            <div class="mt-3">
                                <a href="{{ route('login') }}" class="text-muted small">
                                    Already verified? <u>Login here</u>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>