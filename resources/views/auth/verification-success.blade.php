<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verified - Safari Tours</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        let countdown = 5;
        let isRedirectCancelled = false;

        function updateCountdown() {
            if (isRedirectCancelled) return;
            
            const countdownElement = document.getElementById('countdown');
            if (countdownElement) {
                countdownElement.textContent = countdown;
            }
            
            if (countdown > 0) {
                countdown--;
                setTimeout(updateCountdown, 1000);
            } else {
                if (!isRedirectCancelled) {
                    window.location.href = "{{ route('home') }}";
                }
            }
        }

        function cancelRedirect() {
            isRedirectCancelled = true;
            const countdownElement = document.getElementById('countdown');
            if (countdownElement) {
                countdownElement.parentElement.innerHTML = '<span class="text-muted small">Auto-redirect cancelled</span>';
            }
        }

        // Start the countdown when page loads
        document.addEventListener('DOMContentLoaded', function() {
            updateCountdown();
            
            // Handle the explore button click to cancel the redirect
            const exploreBtn = document.getElementById('explore-btn');
            if (exploreBtn) {
                exploreBtn.addEventListener('click', function() {
                    isRedirectCancelled = true;
                });
            }
        });
    </script>
</head>
<body class="bg-light">
    <div class="container">
        <div class="row justify-content-center align-items-center" style="min-height: 100vh;">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <div class="mb-4">
                                <i class="fas fa-check-circle text-success fa-5x"></i>
                            </div>
                            <h2 class="mb-3">Email Verified Successfully!</h2>
                            <p class="text-muted">Your email has been verified and you're now logged in.</p>
                        </div>

                        @if (session('success'))
                            <div class="alert alert-success text-center">
                                <i class="fas fa-check-circle me-2"></i>
                                {{ session('success') }}
                            </div>
                        @else
                            <div class="alert alert-success text-center">
                                <i class="fas fa-check-circle me-2"></i>
                                Welcome to Safari Tours! Your account is now fully activated.
                            </div>
                        @endif

                        <div class="card bg-light mb-4">
                            <div class="card-body">
                                <h5 class="card-title">Welcome to Safari Tours!</h5>
                                <p class="card-text">
                                    Your account is now fully activated. You can explore our safari packages,
                                    submit enquiries, and book your dream African safari experience.
                                </p>
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <a href="{{ route('home') }}" class="btn btn-primary btn-lg" id="explore-btn">
                                <i class="fas fa-home me-2"></i>Explore Safari Packages
                            </a>
                            <a href="{{ route('packages.index') }}" class="btn btn-outline-primary">
                                <i class="fas fa-list me-2"></i>View All Packages
                            </a>
                        </div>

                        <div class="text-center mt-4">
                            <p class="text-muted small">
                                <i class="fas fa-clock me-1"></i>
                                Redirecting to homepage in <span id="countdown">5</span> seconds...
                            </p>
                            <button class="btn btn-sm btn-link" onclick="cancelRedirect()">Cancel redirect</button>
                        </div>

                        <div class="text-center mt-4">
                            <p class="text-muted small">
                                <i class="fas fa-shield-alt me-1"></i>
                                Your account is secure and verified
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>