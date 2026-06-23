<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Safari Tours</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light">
    <div class="container">
        <div class="row justify-content-center align-items-center" style="min-height: 100vh;">
            <div class="col-md-5">
                <div class="card shadow">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            @include('components.logo')
                            <h1 class="mt-3">Login</h1>
                            <p class="text-muted">Welcome back to Safari Tours</p>
                        </div>

                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                                @if(str_contains(session('error'), 'verify'))
                                <hr>
                                <div class="mt-3">
                                    <p class="mb-2"><strong>Need to verify your email?</strong></p>
                                    <button type="button" class="btn btn-link text-warning p-0" data-bs-toggle="modal" data-bs-target="#resendVerificationModal">
                                        <i class="fas fa-envelope me-1"></i>Resend Verification Email
                                    </button>
                                </div>
                                @endif
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

                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                                @if(session('resent_email'))
                                <hr>
                                <small class="text-muted">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Sent to: {{ session('resent_email') }}
                                </small>
                                @endif
                                @if(session('reset_email'))
                                <hr>
                                <small class="text-muted">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Sent to: {{ session('reset_email') }}
                                </small>
                                @endif
                            </div>
                        @endif

                        @if (session('info'))
                            <div class="alert alert-info">
                                {{ session('info') }}
                                @if(session('verified_email'))
                                <hr>
                                <small class="text-muted">
                                    <i class="fas fa-check-circle me-1"></i>
                                    Verified email: {{ session('verified_email') }}
                                </small>
                                @endif
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required autofocus>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>

                            <div class="mb-3 form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember">
                                <label class="form-check-label" for="remember">
                                    Remember me
                                </label>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Login</button>
                            </div>
                        </form>

                        <div class="text-center mt-4">
                            <div class="mb-2">
                                <button type="button" class="btn btn-link text-warning p-0" onclick="openResendModal()">
                                    <i class="fas fa-envelope me-1"></i>Resend Verification Email
                                </button>
                            </div>
                            <div class="mb-2">
                                <a href="#" onclick="showForgotPassword()" class="text-primary">
                                    <i class="fas fa-key me-1"></i>Forgot Password?
                                </a>
                            </div>
                            <p>Don't have an account? <a href="{{ route('register') }}">Register</a></p>
                            <a href="{{ route('home') }}" class="text-muted">Back to Home</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Resend Verification Modal -->
    <div class="modal fade" id="resendVerificationModal" tabindex="-1" aria-labelledby="resendVerificationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="resendVerificationModalLabel">
                        <i class="fas fa-envelope me-2"></i>Resend Verification Email
                    </h5>
                    <button type="button" class="btn-close" onclick="closeResendModal()" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Enter your email address and we'll send you another verification link.</p>
                    <form action="{{ route('verification.resend.login') }}" method="POST" id="resendVerificationForm">
                        @csrf
                        <div class="mb-3">
                            <label for="resend_email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="resend_email" name="email" required placeholder="your@email.com">
                        </div>
                        @if($errors->has('resend_email'))
                            <div class="alert alert-danger">
                                {{ $errors->first('resend_email') }}
                            </div>
                        @endif
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeResendModal()">Cancel</button>
                    <button type="button" onclick="submitResendForm()" class="btn btn-warning">
                        <i class="fas fa-paper-plane me-2"></i>Send Verification Link
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Forgot Password Modal -->
    <div class="modal fade" id="forgotPasswordModal" tabindex="-1" aria-labelledby="forgotPasswordModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="forgotPasswordModalLabel">
                        <i class="fas fa-key me-2"></i>Reset Password
                    </h5>
                    <button type="button" class="btn-close" onclick="closeForgotModal()" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Enter your email address and we'll send you a link to reset your password.</p>
                    <form action="{{ route('password.request') }}" method="POST" id="forgotPasswordForm">
                        @csrf
                        <div class="mb-3">
                            <label for="forgot_email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="forgot_email" name="email" required placeholder="your@email.com">
                        </div>
                        @if($errors->has('email'))
                            <div class="alert alert-danger">
                                {{ $errors->first('email') }}
                            </div>
                        @endif
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeForgotModal()">Cancel</button>
                    <button type="button" onclick="submitForgotForm()" class="btn btn-primary">
                        <i class="fas fa-paper-plane me-2"></i>Send Reset Link
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function openResendModal() {
            document.getElementById('resendVerificationModal').style.display = 'block';
            document.getElementById('resendVerificationModal').classList.add('show');
            document.body.classList.add('modal-open');
        }

        function closeResendModal() {
            document.getElementById('resendVerificationModal').style.display = 'none';
            document.getElementById('resendVerificationModal').classList.remove('show');
            document.body.classList.remove('modal-open');
        }

        function submitResendForm() {
            document.getElementById('resendVerificationForm').submit();
        }

        function showForgotPassword() {
            document.getElementById('forgotPasswordModal').style.display = 'block';
            document.getElementById('forgotPasswordModal').classList.add('show');
            document.body.classList.add('modal-open');
        }

        function closeForgotModal() {
            document.getElementById('forgotPasswordModal').style.display = 'none';
            document.getElementById('forgotPasswordModal').classList.remove('show');
            document.body.classList.remove('modal-open');
        }

        function submitForgotForm() {
            document.getElementById('forgotPasswordForm').submit();
        }
    </script>
</body>
</html>