<?php $__env->startSection('title', 'Verify Email'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header text-center">
                    <h3>Verify Your Email</h3>
                </div>
                <div class="card-body">
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

                    <p class="text-center mb-4">
                        Please enter the 6-digit verification code sent to your email.
                        The code will expire in 15 minutes.
                    </p>

                    <form method="POST" action="<?php echo e(route('verification.verify.code')); ?>">
                        <?php echo csrf_field(); ?>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email" 
                                   value="<?php echo e(session('user_email', old('email'))); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="code" class="form-label">Verification Code</label>
                            <input type="text" class="form-control" id="code" name="code" 
                                   placeholder="123456" pattern="[0-9]{6}" maxlength="6" required autofocus>
                            <div class="form-text">Enter the 6-digit code from your email</div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                Verify Email
                            </button>
                        </div>
                    </form>

                    <div class="mt-4 text-center">
                        <p>Didn't receive the code?</p>
                        <form method="POST" action="<?php echo e(route('verification.resend.login')); ?>">
                            <?php echo csrf_field(); ?>
                            <div class="mb-3">
                                <input type="email" class="form-control" id="resend_email" name="email" 
                                       placeholder="Enter your email" required>
                            </div>
                            <button type="submit" class="btn btn-link">
                                Resend Verification Code
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/kelvin/Projects/Safari/resources/views/auth/verification-code.blade.php ENDPATH**/ ?>