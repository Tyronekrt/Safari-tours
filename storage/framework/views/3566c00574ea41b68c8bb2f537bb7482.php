<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Your Email - Safari Tours</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image/svg+xml" href="<?php echo e(asset('favicon.svg')); ?>">
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
                            <?php echo $__env->make('components.logo', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                            <h2 class="mt-3">Verify Your Email</h2>
                            <p class="text-muted">Thanks for signing up with Safari Tours!</p>
                        </div>

                        <?php if(session('success')): ?>
                            <div class="alert alert-success">
                                <?php echo e(session('success')); ?>

                            </div>
                        <?php endif; ?>

                        <?php if(session('error')): ?>
                            <div class="alert alert-danger">
                                <?php echo e(session('error')); ?>

                            </div>
                        <?php endif; ?>

                        <?php if($errors->any()): ?>
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li><?php echo e($error); ?></li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                        <div class="alert alert-info">
                            <i class="fas fa-envelope-open-text me-2 fa-2x d-block mb-3"></i>
                            <h5 class="alert-heading">Check Your Email</h5>
                            <strong>Before proceeding, please check your email for a verification link.</strong>
                            <p class="mb-2 mt-2">We've sent a verification email to your registered email address.</p>
                            <?php if(auth()->check() && auth()->user()->email): ?>
                            <div class="mt-2">
                                <small class="text-muted">
                                    <i class="fas fa-envelope me-1"></i>
                                    Sent to: <strong><?php echo e(auth()->user()->email); ?></strong>
                                </small>
                            </div>
                            <?php endif; ?>
                            <hr>
                            <small class="text-muted">
                                <strong>Development Note:</strong> Emails are currently logged to the file system for development. 
                                Check the Laravel log file to find your verification link.
                            </small>
                        </div>

                        <div class="card bg-light mb-4">
                            <div class="card-body">
                                <h5 class="card-title">Didn't receive the email?</h5>
                                <p class="card-text">Don't worry! You can request a new verification email to be sent to your inbox.</p>
                                
                                <?php if(auth()->check()): ?>
                                <form action="<?php echo e(route('verification.resend')); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-warning btn-lg pulse-animation">
                                            <i class="fas fa-redo me-2"></i>Resend Verification Email
                                        </button>
                                    </div>
                                </form>
                                <?php else: ?>
                                <form action="<?php echo e(route('verification.resend')); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
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
                                <?php endif; ?>
                                
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
                                <a href="<?php echo e(route('home')); ?>" class="btn btn-outline-secondary">
                                    <i class="fas fa-arrow-left me-2"></i>Back to Home
                                </a>
                                <a href="<?php echo e(route('login')); ?>" class="btn btn-outline-primary">
                                    <i class="fas fa-sign-in-alt me-2"></i>Go to Login
                                </a>
                            </div>
                            <div class="mt-3">
                                <a href="<?php echo e(route('login')); ?>" class="text-muted small">
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
</html><?php /**PATH /home/kelvin/Projects/Safari/resources/views/auth/verification-notice.blade.php ENDPATH**/ ?>